<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès refusé');
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['src'], $_POST['jour'])) {
    $src = $_POST['src'];
    $jour = (int)$_POST['jour'];

    // Supprime le fichier physique si existant
    if (file_exists($src)) {
        unlink($src);
    }

    // Supprime de la base de données
    $stmt = $pdo->prepare("DELETE FROM media WHERE src = ?");
    $stmt->execute([$src]);

    header("Location: ../index.php?jour=$jour");
    exit;
} else {
    echo "Erreur lors de la suppression.";
}
?>
