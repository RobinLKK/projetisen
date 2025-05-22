<?php
$host = 'robeuxw977.mysql.db';
$dbname = 'robeuxw977';
$username = 'robeuxw977';
$password = 'Robaxel1209';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Affiche clairement les erreurs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Résultat sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Meilleure sécurité sur les requêtes préparées
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
