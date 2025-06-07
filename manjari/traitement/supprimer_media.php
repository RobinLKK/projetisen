<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['src'], $_POST['jour'])) {
    $src = $_POST['src'];
    $jour = (int)$_POST['jour'];

    // Supprimer le fichier physique s’il existe
    $cheminFichier = "../" . $src; // car src = "media/jourX/nom.ext"
    if (file_exists($cheminFichier)) {
        unlink($cheminFichier);
    }

    // Supprimer l’entrée en base
    $stmt = $pdo->prepare("DELETE FROM media WHERE src = ?");
    $stmt->execute([$src]);

    // Redirection vers le jour courant
    header("Location: ../index.php?jour=$jour");
    exit;
}
?>
