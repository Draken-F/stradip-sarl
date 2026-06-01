<?php
require_once 'auth.php';
require_once '../includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// 1. Récupération du projet
$stmt = $pdo->prepare("SELECT * FROM realisations WHERE id = ?");
$stmt->execute([$id]);
$projet = $stmt->fetch();

if (!$projet) {
    header('Location: manage_projets.php');
    exit;
}

// 2. Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_projet'])) {
    $nom = $_POST['nom'];
    $ville = $_POST['ville'];
    $intro = $_POST['introduction'];
    $img_globale = $projet['image_globale'];

    if (!empty($_FILES['image_globale']['name'])) {
        $img_globale = time() . "_" . $_FILES['image_globale']['name'];
        move_uploaded_file($_FILES['image_globale']['tmp_name'], "../assets/img/realisations/" . $img_globale);
        if (file_exists("../assets/img/realisations/" . $projet['image_globale'])) {
            unlink("../assets/img/realisations/" . $projet['image_globale']);
        }
    }

    $stmt = $pdo->prepare("UPDATE realisations SET nom=?, ville=?, image_globale=?, introduction=? WHERE id=?");
    if ($stmt->execute([$nom, $ville, $img_globale, $intro, $id])) {
        $message = "Projet mis à jour avec succès.";
        // Refresh des données locales
        $projet['nom'] = $nom;
        $projet['ville'] = $ville;
        $projet['image_globale'] = $img_globale;
        $projet['introduction'] = $intro;
    }
}

// 3. Récupération des sections (pièces) pour ce projet
$sections = $pdo->prepare("SELECT * FROM realisation_sections WHERE realisation_id = ? ORDER BY ordre_affichage ASC");
$sections->execute([$id]);
$all_sections = $sections->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Projet | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-start">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-12">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter mb-8">Modifier le projet</h2>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-10 border border-slate-200 shadow-sm grid grid-cols-2 gap-8 mb-16">
                <input type="hidden" name="update_projet" value="1">
                <div class="col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Titre du Projet</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($projet['nom']) ?>" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none focus:border-amber-500 font-bold">
                </div>
                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Ville</label>
                    <input type="text" name="ville" value="<?= htmlspecialchars($projet['ville']) ?>" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Image Globale Actuelle</label>
                    <img src="../assets/img/realisations/<?= $projet['image_globale'] ?>" class="h-14 w-24 object-cover border">
                    <input type="file" name="image_globale" class="mt-2 text-xs">
                </div>
                <div class="col-span-2">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Introduction</label>
                    <textarea name="introduction" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none"><?= htmlspecialchars($projet['introduction'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="col-span-2 bg-slate-900 text-white py-4 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition">Enregistrer les modifications générales</button>
            </form>

            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-bold uppercase tracking-tight text-slate-800">Pièces & Sections du projet</h3>
                <a href="add_section.php?id=<?= $id ?>" class="text-[0.6rem] font-black uppercase bg-amber-600 text-white px-4 py-2 hover:bg-slate-900 transition">+ Ajouter une pièce</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($all_sections as $s): ?>
                    <div class="bg-white p-4 border border-slate-200 flex items-center justify-between group">
                        <div class="flex items-center">
                            <img src="../assets/img/realisations/<?= $s['image_ambiance'] ?>" class="w-12 h-12 object-cover mr-4">
                            <span class="text-sm font-bold uppercase text-slate-700"><?= htmlspecialchars($s['titre_piece']) ?></span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="edit_section.php?id=<?= $s['id'] ?>" class="text-slate-400 hover:text-amber-600 transition">Modifier</a>
                            <a href="delete_section.php?id=<?= $s['id'] ?>" onclick="return confirm('Supprimer cette pièce ?')" class="text-slate-400 hover:text-red-600 transition">Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>

</html>