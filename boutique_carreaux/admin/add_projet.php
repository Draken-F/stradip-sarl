<?php
require_once 'auth.php';
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $ville = $_POST['ville'];
    $intro = $_POST['introduction'];

    $img_globale = time() . "_" . $_FILES['image_globale']['name'];
    move_uploaded_file($_FILES['image_globale']['tmp_name'], "../assets/img/realisations/" . $img_globale);

    $stmt = $pdo->prepare("INSERT INTO realisations (nom, ville, image_globale, introduction) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $ville, $img_globale, $intro]);

    $projet_id = $pdo->lastInsertId();
    // On redirige vers l'ajout de sections pour ce projet précis
    header("Location: add_section.php?id=$projet_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nouveau Projet | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-start">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter mb-8">Étape 1 : Créer le projet</h2>
            <form method="POST" enctype="multipart/form-data" class="bg-white p-10 border border-slate-200 shadow-sm space-y-6">
                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Nom du Projet</label>
                    <input type="text" name="nom" required class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Ville</label>
                    <input type="text" name="ville" required class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Introduction</label>
                    <textarea name="introduction" rows="4" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none"></textarea>
                </div>
                <div class="p-6 border-2 border-dashed border-slate-200 bg-slate-50">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Image de couverture principale</label>
                    <input type="file" name="image_globale" required>
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white py-5 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition">
                    Créer et passer aux pièces →
                </button>
            </form>
        </div>
    </main>
</body>

</html>