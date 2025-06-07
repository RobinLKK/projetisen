<?php
require_once '../db.php'; // ← car db.php est dans la racine

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour = (int)$_POST['jour'];
    $texte = $_POST['texte'];

    // Mets à jour le texte de la page
    $stmt = $pdo->prepare("UPDATE journal SET texte = ? WHERE jour = ?");
    $stmt->execute([$texte, $jour]);

    // Redirige proprement
    header("Location: ../index.php?jour=$jour");
    exit;
}
?>
