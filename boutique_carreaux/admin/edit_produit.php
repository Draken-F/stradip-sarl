<?php
require_once 'auth.php';
require_once '../includes/db.php';

$message = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. Récupération du produit actuel
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    header('Location: manage_produits.php');
    exit;
}

// 2. Récupération des catégories pour le menu
$categories = $pdo->query("SELECT * FROM categories ORDER BY nom_matiere ASC")->fetchAll();

// 3. Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $ref = $_POST['reference'];
    $dim = $_POST['dimension'];
    $type = $_POST['type_pose'];
    $piece = $_POST['piece'];
    $cat_id = $_POST['categorie_id'];
    $couleur = $_POST['couleur'];
    $style = $_POST['style'];
    $image_url = $p['image_url']; // Par défaut, on garde l'ancienne image

    // Si une nouvelle image est téléchargée
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/img/";
        $new_image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Supprimer l'ancienne image physiquement si elle existe
            if (file_exists($target_dir . $p['image_url'])) {
                unlink($target_dir . $p['image_url']);
            }
            $image_url = $new_image_name;
        }
    }

    $sql = "UPDATE produits SET nom=?, reference=?, dimension=?, type_pose=?, piece=?, categorie_id=?, couleur=?, style=?, image_url=? WHERE id=?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nom, $ref, $dim, $type, $piece, $cat_id, $couleur, $style, $image_url, $id])) {
        header('Location: manage_produits.php?msg=updated');
        exit;
    } else {
        $message = "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le Produit | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;600&display=swap');

        .logo-font {
            font-family: 'Playfair Display', serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-start">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8 md:p-12">
        <div class="max-w-4xl mx-auto">
            <header class="mb-12">
                <a href="manage_produits.php" class="text-amber-600 text-[0.6rem] font-black uppercase tracking-[3px] hover:underline">← Retour à la liste</a>
                <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter mt-4">Modifier : <?= htmlspecialchars($p['nom']) ?></h2>
            </header>

            <?php if ($message): ?>
                <div class="p-4 mb-6 bg-red-50 text-red-600 font-bold text-[0.6rem] uppercase tracking-widest border-l-4 border-red-500">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-10 shadow-sm border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="md:col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Nom du modèle</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($p['nom']) ?>" required class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-500 outline-none font-semibold">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Référence</label>
                    <input type="text" name="reference" value="<?= htmlspecialchars($p['reference']) ?>" required class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Dimensions</label>
                    <input type="text" name="dimension" value="<?= htmlspecialchars($p['dimension']) ?>" required class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Type de pose</label>
                    <select name="type_pose" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                        <option value="Sol" <?= $p['type_pose'] == 'Sol' ? 'selected' : '' ?>>Sol</option>
                        <option value="Mur" <?= $p['type_pose'] == 'Mur' ? 'selected' : '' ?>>Mur</option>
                        <option value="Sol et Mur" <?= $p['type_pose'] == 'Sol et Mur' ? 'selected' : '' ?>>Sol et Mur</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Matière</label>
                    <select name="categorie_id" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $p['categorie_id'] == $cat['id'] ? 'selected' : '' ?>><?= $cat['nom_matiere'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Couleur principal</label>
                    <input type="text" name="couleur" value="<?= htmlspecialchars($p['couleur']) ?>" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Style</label>
                    <select name="style" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                        <option value="Standard" <?= $p['style'] == 'Standard' ? 'selected' : '' ?>>Standard</option>
                        <option value="Décoratif" <?= $p['style'] == 'Décoratif' ? 'selected' : '' ?>>Décoratif</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Espaces (Séparés par virgules)</label>
                    <input type="text" name="piece" value="<?= htmlspecialchars($p['piece']) ?>" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>

                <div class="md:col-span-1">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Image actuelle</label>
                    <div class="w-full aspect-video bg-slate-100 border border-slate-200 overflow-hidden">
                        <img src="../assets/img/<?= $p['image_url'] ?>" class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="md:col-span-1 flex flex-col justify-end">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Remplacer l'image (optionnel)</label>
                    <div class="p-6 border-2 border-dashed border-slate-200 bg-slate-50">
                        <input type="file" name="image" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[0.6rem] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-amber-600 transition">
                    </div>
                </div>

                <div class="md:col-span-2 pt-6">
                    <button type="submit" class="w-full bg-slate-900 text-white py-5 text-[0.7rem] font-black uppercase tracking-[4px] hover:bg-amber-600 transition-all duration-500 shadow-xl">
                        Mettre à jour la référence
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>

</html>