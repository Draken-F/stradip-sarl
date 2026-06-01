<?php
// Configuration des paramètres de la base de données
$host = 'localhost';
$db   = 'db_carreaux';
$user = 'root';
$pass = ''; // Par défaut sur WAMP, le mot de passe est vide
$charset = 'utf8mb4';
$port = 3308;

// Création du DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";

// Options de PDO pour plus de sécurité et de facilité de débogage
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lance une erreur si la connexion échoue
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retourne les données sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Utilise les vraies requêtes préparées (sécurité)
];

try {
     // Tentative de connexion
     $pdo = new PDO($dsn, $user, $pass, $options);
     // echo "Connexion réussie !"; // (Décommenter pour tester, puis effacer)
} catch (\PDOException $e) {
     // Si la connexion échoue, on affiche l'erreur
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>