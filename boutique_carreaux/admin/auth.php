<?php
session_start();

// Si la variable de session n'existe pas, on redirige vers le login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
