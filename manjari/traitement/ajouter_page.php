<?php
require_once 'includes/db.php';

try {
    $texte = $_POST['texte'];

    // Récupérer le dernier jour
    $stmt = $pdo->query("SELECT MAX(jour) as max_jour FROM journal");
    $lastJour = $stmt->fetch(PDO::FETCH_ASSOC)['max_jour'] ?? 0;
    $newJour = $lastJour + 1;

    // Insère dans journal
    $stmt = $pdo->prepare("INSERT INTO journal (jour, texte) VALUES (?, ?)");
    $stmt->execute([$newJour, $texte]);
    $journal_id = $pdo->lastInsertId();

    // Dossier médias
    $mediaDir = "medias/jour$newJour";
    if (!is_dir($mediaDir)) mkdir($mediaDir, 0777, true);

    // Gestion des médias
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

    header("Location: index.php?jour=$newJour");
    exit;

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
