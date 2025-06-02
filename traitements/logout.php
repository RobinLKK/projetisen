<?php
session_start();
require("db.php");

if (isset($_SESSION['id_user'])) {
    $stmt = $conn->prepare("UPDATE utilisateurs SET remember_token = NULL WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['id_user']]);
}

session_destroy();

setcookie('remember_token', '', time() - 3600, '/');

header("Location: ../pages/connexion.php");
exit();
?>
