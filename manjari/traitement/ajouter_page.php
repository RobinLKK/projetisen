<?php
require_once '../db.php'; // ← car db.php est dans la racine

try {
    $texte = $_POST['texte'];

    // Récupérer le dernier jour déjà enregistré
    $stmt = $pdo->query("SELECT MAX(jour) as max_jour FROM journal");
    $lastJour = $stmt->fetch(PDO::FETCH_ASSOC)['max_jour'] ?? 0;
    $newJour = $lastJour + 1;

    // Insérer dans la table journal
    $stmt = $pdo->prepare("INSERT INTO journal (jour, texte) VALUES (?, ?)");
    $stmt->execute([$newJour, $texte]);
    $journal_id = $pdo->lastInsertId();

    // Créer le dossier des médias dans /medias/
    $mediaDir = "../media/jour$newJour";
    if (!is_dir($mediaDir)) mkdir($mediaDir, 0777, true);

    // Traitement des fichiers uploadés
    foreach ($_FILES['medias']['tmp_name'] as $i => $tmpPath) {
        if (!is_uploaded_file($tmpPath)) continue;

        $originalName = basename($_FILES['medias']['name'][$i]);
        $name = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $originalName);
        $type = mime_content_type($tmpPath);

        // Évite les doublons de fichiers
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

        // Type de média
        if (str_starts_with($type, 'image')) $mediaType = 'image';
        elseif (str_starts_with($type, 'video')) $mediaType = 'video';
        elseif (str_starts_with($type, 'audio')) $mediaType = 'audio';
        else continue;

        // Insère en BDD
        $stmt = $pdo->prepare("INSERT INTO media (journal_id, type, src) VALUES (?, ?, ?)");
        $stmt->execute([$journal_id, $mediaType, "media/jour$newJour/$name"]);
    }

    // Redirection vers la nouvelle page
    header("Location: ../index.php?jour=$newJour");
    exit;

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
