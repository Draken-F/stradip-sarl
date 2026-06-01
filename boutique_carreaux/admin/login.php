<?php
session_start();
require_once '../includes/db.php'; // On remonte d'un dossier pour trouver db.php

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Identifiants invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Noupa Ceramic Admin</title>
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

<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <h1 class="logo-font text-3xl text-white tracking-widest uppercase">
                NOUPA<span class="text-amber-500">ADMIN</span>
            </h1>
            <p class="text-slate-400 text-xs mt-2 uppercase tracking-[3px]">Gestion de stock & Réalisations</p>
        </div>

        <div class="bg-white p-10 rounded-sm shadow-2xl">
            <h2 class="text-xl font-bold text-slate-900 mb-8 uppercase tracking-tighter">Connexion sécurisée</h2>

            <?php if ($error): ?>
                <div class="bg-red-50 text-red-600 p-4 mb-6 text-xs font-bold uppercase tracking-widest border-l-4 border-red-500">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-[0.6rem] font-black uppercase tracking-widest text-slate-400 mb-2">Identifiant</label>
                    <input type="text" name="username" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-amber-500 focus:outline-none transition-all text-sm font-semibold">
                </div>

                <div>
                    <label class="block text-[0.6rem] font-black uppercase tracking-widest text-slate-400 mb-2">Mot de passe</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-amber-500 focus:outline-none transition-all">
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 text-white py-4 text-[0.7rem] font-black uppercase tracking-[3px] hover:bg-amber-600 transition-all duration-500 shadow-lg">
                    Entrer dans le Dashboard
                </button>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="../index.php" class="text-slate-500 text-[0.6rem] uppercase tracking-widest hover:text-white transition">
                ← Retour au site public
            </a>
        </div>
    </div>

</body>

</html>