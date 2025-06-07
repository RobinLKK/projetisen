<?php
require_once 'db.php';

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
    $mediaDir = "medias/jour$jour";
    if (!is_dir($mediaDir)) mkdir($mediaDir, 0777, true);

    foreach ($_FILES['medias']['tmp_name'] as $i => $tmpPath) {
        if (!is_uploaded_file($tmpPath)) continue;

        $name = basename($_FILES['medias']['name'][$i]);
        $type = mime_content_type($tmpPath);
        $dest = "$mediaDir/$name";
        move_uploaded_file($tmpPath, $dest);

        if (str_starts_with($type, 'image')) $mediaType = 'image';
        elseif (str_starts_with($type, 'video')) $mediaType = 'video';
        elseif (str_starts_with($type, 'audio')) $mediaType = 'audio';
        else continue;

        $stmt = $pdo->prepare("INSERT INTO media (journal_id, type, src) VALUES (?, ?, ?)");
        $stmt->execute([$journal_id, $mediaType, $dest]);
    }

    header("Location: index.php?jour=$jour");
    exit;
}
?>
