<?php
require_once 'auth.php';
require_once '../includes/db.php';

$section_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// 1. Logique de SUPPRESSION d'une photo de la galerie
if (isset($_GET['delete_photo'])) {
    $photo_id = intval($_GET['delete_photo']);
    $stmtP = $pdo->prepare("SELECT image_url FROM realisation_section_photos WHERE id = ?");
    $stmtP->execute([$photo_id]);
    $old_img = $stmtP->fetchColumn();

    if ($old_img && file_exists("../assets/img/realisations/" . $old_img)) {
        unlink("../assets/img/realisations/" . $old_img);
    }

    $pdo->prepare("DELETE FROM realisation_section_photos WHERE id = ?")->execute([$photo_id]);
    header("Location: edit_section.php?id=$section_id&msg=photo_deleted");
    exit;
}

// 2. Récupération des infos de la section et de sa galerie
$stmtS = $pdo->prepare("SELECT * FROM realisation_sections WHERE id = ?");
$stmtS->execute([$section_id]);
$section = $stmtS->fetch();

$stmtGallery = $pdo->prepare("SELECT * FROM realisation_section_photos WHERE section_id = ? ORDER BY ordre ASC");
$stmtGallery->execute([$section_id]);
$current_gallery = $stmtGallery->fetchAll();

// 3. Traitement du Formulaire de Mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre_piece'];
    $desc = $_POST['description'];

    // Mise à jour de l'image d'ambiance (principale)
    $img_amb = $section['image_ambiance'];
    if (!empty($_FILES['image_ambiance']['name'])) {
        $img_amb = time() . "_amb_" . $_FILES['image_ambiance']['name'];
        move_uploaded_file($_FILES['image_ambiance']['tmp_name'], "../assets/img/realisations/" . $img_amb);
    }

    $pdo->prepare("UPDATE realisation_sections SET titre_piece=?, description=?, image_ambiance=? WHERE id=?")
        ->execute([$titre, $desc, $img_amb, $section_id]);

    // AJOUT de nouvelles photos à la galerie
    if (!empty($_FILES['new_galerie']['name'][0])) {
        foreach ($_FILES['new_galerie']['tmp_name'] as $key => $tmp_name) {
            $filename = time() . "_gal_" . $_FILES['new_galerie']['name'][$key];
            if (move_uploaded_file($tmp_name, "../assets/img/realisations/" . $filename)) {
                $pdo->prepare("INSERT INTO realisation_section_photos (section_id, image_url) VALUES (?, ?)")->execute([$section_id, $filename]);
            }
        }
    }

    header("Location: edit_projet.php?id=" . $section['realisation_id'] . "&msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Section | Noupa Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-start">
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-12">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-bold text-slate-900 uppercase tracking-tighter mb-8 italic">Édition : <?= htmlspecialchars($section['titre_piece']) ?></h2>

            <form method="POST" enctype="multipart/form-data" class="bg-white p-10 border border-slate-200 shadow-sm space-y-12">

                <div class="grid grid-cols-2 gap-8">
                    <div class="col-span-2">
                        <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Titre de la section</label>
                        <input type="text" name="titre_piece" value="<?= htmlspecialchars($section['titre_piece']) ?>" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full p-4 bg-slate-50 border border-slate-200 outline-none"><?= htmlspecialchars($section['description'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-2">Photo d'ambiance actuelle</label>
                        <img src="../assets/img/realisations/<?= $section['image_ambiance'] ?>" class="w-full aspect-video object-cover border mb-2">
                        <input type="file" name="image_ambiance" class="text-xs">
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100">
                    <label class="block text-[0.6rem] font-black uppercase text-slate-400 mb-6 tracking-widest">Galerie Photo (Gérer les images)</label>

                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <?php foreach ($current_gallery as $photo): ?>
                            <div class="relative aspect-square group overflow-hidden border border-slate-200 bg-slate-100">
                                <img src="../assets/img/realisations/<?= $photo['image_url'] ?>" class="w-full h-full object-cover">
                                <a href="edit_section.php?id=<?= $section_id ?>&delete_photo=<?= $photo['id'] ?>"
                                    onclick="return confirm('Supprimer cette photo de la galerie ?')"
                                    class="absolute inset-0 bg-red-600/90 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-[0.6rem] font-black uppercase">
                                    Supprimer
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <div id="add-image-btn" onclick="document.getElementById('new-gallery-input').click()"
                            class="aspect-square border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-all group">
                            <span class="text-3xl text-slate-300 group-hover:text-amber-600">+</span>
                            <span class="text-[0.5rem] font-bold uppercase text-slate-400 mt-1">Ajouter</span>
                        </div>
                    </div>
                    <input type="file" id="new-gallery-input" name="new_galerie[]" multiple class="hidden" accept="image/*">
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white py-5 text-[0.7rem] font-black uppercase tracking-[4px] hover:bg-amber-600 transition shadow-xl">
                    Enregistrer les modifications
                </button>
            </form>
        </div>
    </main>

    <script>
        const input = document.getElementById('new-gallery-input');
        const container = document.getElementById('preview-container');
        const btn = document.getElementById('add-image-btn');

        input.addEventListener('change', function() {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "relative aspect-square border-2 border-amber-500 overflow-hidden shadow-lg";
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="bg-amber-500 text-white text-[0.5rem] px-2 py-1 font-black uppercase">Nouveau</span>
                        </div>
                    `;
                    container.insertBefore(div, btn);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>

</html>