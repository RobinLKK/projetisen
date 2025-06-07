<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès refusé');
}

require_once '../db.php'; // Chemin corrigé

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jour'])) {
    $jour = (int)$_POST['jour'];

    // Récupérer l’ID de la page
    $stmt = $pdo->prepare("SELECT id FROM journal WHERE jour = ?");
    $stmt->execute([$jour]);
    $row = $stmt->fetch();

    if (!$row) {
        die("Page introuvable.");
    }

    $journal_id = $row['id'];
    $mediaDir = "../media/jour$jour"; // Corrigé : remonter depuis /traitement/
    if (!is_dir($mediaDir)) mkdir($mediaDir, 0777, true);

    foreach ($_FILES['medias']['tmp_name'] as $i => $tmpPath) {
        if (!is_uploaded_file($tmpPath)) continue;

        $originalName = basename($_FILES['medias']['name'][$i]);
        $name = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalName);
        $type = mime_content_type($tmpPath);

        $dest = "$mediaDir/$name";
        $baseName = pathinfo($name, PATHINFO_FILENAME);
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $counter = 1;
        while (file_exists($dest)) {
            $name = $baseName . "_$counter." . $ext;
            $dest = "$mediaDir/$name";
            $counter++;
        }

        move_uploaded_file($tmpPath, $dest);

        if (str_starts_with($type, 'image')) $mediaType = 'image';
        elseif (str_starts_with($type, 'video')) $mediaType = 'video';
        elseif (str_starts_with($type, 'audio')) $mediaType = 'audio';
        else continue;

        // On enregistre le chemin relatif pour affichage dans index.php
        $cheminFinal = "media/jour$jour/$name";

        $stmt = $pdo->prepare("INSERT INTO media (journal_id, type, src) VALUES (?, ?, ?)");
        $stmt->execute([$journal_id, $mediaType, $cheminFinal]);
    }

    header("Location: ../index.php?jour=$jour"); // Chemin corrigé
    exit;
}
?>
