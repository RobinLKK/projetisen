<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès refusé');
}

require_once '../db.php';

try {
    // Récupère le dernier jour déjà utilisé
    $stmt = $pdo->query("SELECT MAX(jour) as max_jour FROM journal");
    $lastJour = $stmt->fetch(PDO::FETCH_ASSOC)['max_jour'] ?? 0;
    $newJour = $lastJour + 1;

    // Crée la nouvelle page vide
    $stmt = $pdo->prepare("INSERT INTO journal (jour, texte) VALUES (?, '')");
    $stmt->execute([$newJour]);

    // Crée le dossier médias
    $mediaDir = "../media/jour$newJour";
    if (!is_dir($mediaDir)) mkdir($mediaDir, 0777, true);

    // Redirection directe
    header("Location: ../index.php?jour=$newJour");
    exit;

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
