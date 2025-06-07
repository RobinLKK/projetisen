<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour = (int)$_POST['jour'];
    $texte = $_POST['texte'];

    $stmt = $pdo->prepare("UPDATE journal SET texte = ? WHERE jour = ?");
    $stmt->execute([$texte, $jour]);

    header("Location: index.php?jour=$jour");
    exit;
}
?>
