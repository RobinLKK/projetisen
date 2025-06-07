<?php
// ⚙️ Affichage des erreurs PHP/PDO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 💾 Connexion MySQL
$servername = "robeuxw977.mysql.db";
$username   = "robeuxw977";
$password   = "Robaxel1209";
$database   = "robeuxw977";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // ⛔ En cas d'erreur de connexion
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
