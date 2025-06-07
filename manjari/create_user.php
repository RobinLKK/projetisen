<?php
require_once 'db.php';  // connexion PDO

$username = 'Manjari';
$password = 'Carol';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
$stmt->execute([$username, $password_hash]);

echo "Utilisateur créé avec succès.";
echo "<br>Identifiant : $username";
echo "<br>Mot de passe : $password";