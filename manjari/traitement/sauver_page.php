<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès refusé');
}

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
