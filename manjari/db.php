<?php
$servername = "robeuxw977.mysql.db"; 
$username = "robeuxw977"; 
$password = "Robaxel1209"; 
$database = "robeuxw977";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
