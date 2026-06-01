<?php
require_once 'auth.php';
require_once '../includes/db.php';

// 1. Suppression d'un projet
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmtImg = $pdo->prepare("SELECT image_globale FROM realisations WHERE id = ?");
    $stmtImg->execute([$id]);
    $img = $stmtImg->fetchColumn();

    if ($img && file_exists("../assets/img/realisations/" . $img)) {
        unlink("../assets/img/realisations/" . $img);
    }

    $stmt = $pdo->prepare("DELETE FROM realisations WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_projets.php?msg=deleted');
    exit;
}

$projets = $pdo->query("SELECT r.*, s.description 
        FROM realisations r 
        LEFT JOIN realisation_sections s ON r.id = s.realisation_id 
        GROUP BY r.id 
        ORDER BY r.date_ajout DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gérer les Réalisations | Admin</title>
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
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter">Portfolio de Réalisations</h2>
                <p class="text-slate-500 text-sm">Gérez vos chantiers et projets d'exception.</p>
            </div>
            <a href="add_projet.php" class="bg-slate-900 text-white px-6 py-3 text-[0.6rem] font-black uppercase tracking-widest hover:bg-amber-600 transition shadow-lg">
                + Ajouter un projet
            </a>
        </div>



        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <?php foreach ($projets as $p): ?>
                <div class="bg-white border border-slate-200 flex overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="w-40 h-40 shrink-0 bg-slate-100 overflow-hidden">
                        <img src="../assets/img/realisations/<?= $p['image_globale'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <span class="text-[0.55rem] font-black uppercase tracking-widest text-amber-600"><?= htmlspecialchars($p['ville']) ?></span>
                                <div class="flex space-x-2">
                                    <a href="edit_projet.php?id=<?= $p['id'] ?>" class="text-slate-300 hover:text-slate-900 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></a>
                                    <a href="manage_projets.php?delete=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce projet ?')" class="text-slate-300 hover:text-red-600 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg></a>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 uppercase tracking-tighter mt-1"><?= htmlspecialchars($p['nom']) ?></h3>
                        </div>
                        <p class="text-[0.65rem] text-slate-400 italic line-clamp-1 mt-2"><?= htmlspecialchars($p['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>