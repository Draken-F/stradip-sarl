<?php
require_once 'auth.php';
require_once '../includes/db.php';

$message = "";

// 1. Récupération des catégories pour le menu déroulant
$categories = $pdo->query("SELECT * FROM categories ORDER BY nom_matiere ASC")->fetchAll();

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $ref = $_POST['reference'];
    $dim = $_POST['dimension'];
    $type = $_POST['type_pose'];
    $piece = $_POST['piece'];
    $cat_id = $_POST['categorie_id'];
    $couleur = $_POST['couleur'];
    $style = $_POST['style'];

    // Gestion de l'upload d'image
    $image_name = $_FILES['image']['name'];
    $target_dir = "../assets/img/";
    $target_file = $target_dir . basename($image_name);

    // Vérification et déplacement du fichier
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO produits (nom, reference, dimension, type_pose, piece, categorie_id, couleur, style, image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nom, $ref, $dim, $type, $piece, $cat_id, $couleur, $style, $image_name])) {
            $message = "Produit ajouté avec succès !";
        } else {
            $message = "Erreur lors de l'enregistrement en base de données.";
        }
    } else {
        $message = "Erreur lors de l'upload de l'image. Vérifiez les permissions du dossier assets/img/.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex">

    <aside class="w-64 bg-[#0f172a] text-white hidden md:block p-8">
        <h1 class="font-bold tracking-widest uppercase mb-10">NOUPA<span class="text-amber-500">ADMIN</span></h1>
        <nav class="space-y-4">
            <a href="dashboard.php" class="block text-slate-400 hover:text-white uppercase text-xs font-bold tracking-widest">← Retour Dashboard</a>
        </nav>
    </aside>

    <main class="flex-1 p-8 md:p-12">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-slate-900 mb-8 uppercase tracking-tighter">Nouveau Carreau</h2>

            <?php if ($message): ?>
                <div class="p-4 mb-6 bg-amber-100 text-amber-800 font-bold text-xs uppercase tracking-widest border-l-4 border-amber-500">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-8 shadow-sm border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Nom du modèle</label>
                    <input type="text" name="nom" required class="w-full p-3 border border-slate-200 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Référence</label>
                    <input type="text" name="reference" placeholder="Ex: NC-2026-01" required class="w-full p-3 border border-slate-200 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Dimensions (cm)</label>
                    <input type="text" name="dimension" placeholder="Ex: 60x60" required class="w-full p-3 border border-slate-200 focus:border-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Type de pose</label>
                    <select name="type_pose" class="w-full p-3 border border-slate-200 outline-none">
                        <option value="Sol">Sol</option>
                        <option value="Mur">Mur</option>
                        <option value="Sol et Mur">Sol et Mur</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Matière</label>
                    <select name="categorie_id" class="w-full p-3 border border-slate-200 outline-none">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['nom_matiere'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Couleur principal (Nom ou Hexa)</label>
                    <input type="text" name="couleur" placeholder="Ex: White ou #FFFFFF" class="w-full p-3 border border-slate-200 outline-none">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Style</label>
                    <select name="style" class="w-full p-3 border border-slate-200 outline-none">
                        <option value="Standard">Standard</option>
                        <option value="Décoratif">Décoratif / Motif</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Pièces recommandées (Séparées par des virgules)</label>
                    <input type="text" name="piece" placeholder="Ex: Salon, Salle de bain, Cuisine" class="w-full p-3 border border-slate-200 outline-none">
                </div>

                <div class="md:col-span-2 bg-slate-50 p-6 border-2 border-dashed border-slate-200">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Photo du produit</label>
                    <input type="file" name="image" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[0.6rem] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-amber-600 transition">
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition-all duration-500">
                        Enregistrer le produit
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>

</html>