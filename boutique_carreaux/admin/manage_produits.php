<?php
require_once 'auth.php';
require_once '../includes/db.php'; // Vérifie bien que le chemin est correct ici

// 1. Logique de suppression (Inchangée)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmtImg = $pdo->prepare("SELECT image_url FROM produits WHERE id = ?");
    $stmtImg->execute([$id]);
    $img = $stmtImg->fetchColumn();

    if ($img && file_exists("../assets/img/" . $img)) {
        unlink("../assets/img/" . $img);
    }

    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_produits.php?msg=deleted');
    exit;
}

// 2. Récupération des produits
$sql = "SELECT p.*, c.nom_matiere FROM produits p 
        JOIN categories c ON p.categorie_id = c.id 
        ORDER BY p.date_ajout DESC";
$produits = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gérer le Catalogue | Noupa Admin</title>
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
                <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter">Gestion du Catalogue</h2>
                <p class="text-slate-500 text-sm">Modifiez ou supprimez vos références de carreaux.</p>
            </div>

            <div class="flex items-center space-x-6">
                <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-400">
                    <?= count($produits) ?> Références
                </span>
                <a href="add_produit.php" class="bg-slate-900 text-white px-6 py-3 text-[0.6rem] font-black uppercase tracking-widest hover:bg-amber-600 transition shadow-lg">
                    + Ajouter un produit
                </a>
            </div>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="p-4 mb-6 bg-red-50 text-red-600 font-bold text-xs uppercase tracking-widest border-l-4 border-red-500">
                Produit et image supprimés avec succès.
            </div>
        <?php endif; ?>

        <div class="bg-white border border-slate-200 shadow-sm overflow-hidden rounded-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="p-4 text-[0.6rem] font-black uppercase tracking-widest">Aperçu</th>
                        <th class="p-4 text-[0.6rem] font-black uppercase tracking-widest">Produit</th>
                        <th class="p-4 text-[0.6rem] font-black uppercase tracking-widest">Référence</th>
                        <th class="p-4 text-[0.6rem] font-black uppercase tracking-widest">Matière</th>
                        <th class="p-4 text-[0.6rem] font-black uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($produits as $p): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="w-12 h-12 bg-slate-100 border border-slate-200 overflow-hidden rounded-sm">
                                    <img src="../assets/img/<?= $p['image_url'] ?>" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-bold text-slate-800 uppercase"><?= htmlspecialchars($p['nom']) ?></p>
                                <p class="text-[0.6rem] text-slate-400 uppercase tracking-widest"><?= $p['dimension'] ?> cm</p>
                            </td>
                            <td class="p-4 font-mono text-xs text-slate-500 italic">
                                <?= htmlspecialchars($p['reference']) ?>
                            </td>
                            <td class="p-4">
                                <span class="text-[0.55rem] font-black uppercase tracking-widest bg-slate-100 px-3 py-1.5 text-slate-600 rounded-full">
                                    <?= htmlspecialchars($p['nom_matiere']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end space-x-3">
                                    <a href="edit_produit.php?id=<?= $p['id'] ?>" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-amber-100 hover:text-amber-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="manage_produits.php?delete=<?= $p['id'] ?>"
                                        onclick="return confirm('Supprimer définitivement ce modèle ?')"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-red-100 hover:text-red-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>