<?php
require_once 'db.php';

// Récupère le jour demandé
$jour = isset($_GET['jour']) ? (int)$_GET['jour'] : 1;

// Charge les jours disponibles
$data_json = json_decode(file_get_contents('data/journal.json'), true);
$jours_json = array_map(fn($key) => (int)str_replace('jour_', '', $key), array_keys($data_json));

$stmt = $pdo->query("SELECT jour FROM journal");
$jours_bdd = $stmt->fetchAll(PDO::FETCH_COLUMN);

$jours_disponibles = array_unique(array_merge($jours_json, $jours_bdd));
sort($jours_disponibles);

// Redirection si jour inexistant
if (!in_array($jour, $jours_disponibles)) {
    $jour = max($jours_disponibles);
    header("Location: index.php?jour=$jour");
    exit;
}

// Charge le contenu
$entryKey = "jour_$jour";
if (in_array($jour, $jours_json)) {
    $entry = $data_json[$entryKey] ?? null;
} else {
    $stmt = $pdo->prepare("SELECT id, texte FROM journal WHERE jour = ?");
    $stmt->execute([$jour]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entry) {
        $stmt = $pdo->prepare("SELECT type, src FROM media WHERE journal_id = ?");
        $stmt->execute([$entry['id']]);
        $entry['media'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal de Manjari - Jour <?= $jour ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Journal de Manjari">
    <meta name="author" content="Rob1, Xam">
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap" rel="stylesheet">
</head>
<body>

<div class="journal">
    <div class="page gauche">
        <h2>Jour <?= $jour ?></h2>

        <?php if ($entry && empty(trim($entry['texte']))): ?>
            <form method="POST" action="traitement/sauver_page.php" style="text-align:center;">
                <input type="hidden" name="jour" value="<?= $jour ?>">
                <textarea name="texte" rows="12" cols="50" placeholder="Écris ici ta nouvelle page..." required></textarea><br>
                <button type="submit">💾 Enregistrer</button>
            </form>
        <?php elseif ($entry): ?>
            <p><?= nl2br(htmlspecialchars($entry['texte'])) ?></p>
            <div style="text-align:right; margin-top: 20px;">
                <button onclick="document.getElementById('form-edit-texte').style.display='block'">✏️ Modifier le texte</button>
            </div>
            <form id="form-edit-texte" method="POST" action="traitement/sauver_page.php" style="display:none; margin-top:15px;">
                <input type="hidden" name="jour" value="<?= $jour ?>">
                <textarea name="texte" rows="10" cols="50"><?= htmlspecialchars($entry['texte']) ?></textarea><br>
                <button type="submit">💾 Sauvegarder</button>
            </form>
        <?php else: ?>
            <p>Rien écrit ce jour-là...</p>
        <?php endif; ?>
    </div>

    <div class="page droite">
        <?php if ($entry && isset($entry['media'])): ?>
            <?php foreach ($entry['media'] as $media): ?>
                <?php if ($media['type'] === 'image'): ?>
                    <img src="<?= htmlspecialchars($media['src']) ?>" alt="media">
                <?php elseif ($media['type'] === 'video'): ?>
                    <video controls src="<?= htmlspecialchars($media['src']) ?>"></video>
                <?php elseif ($media['type'] === 'audio'): ?>
                    <audio controls src="<?= htmlspecialchars($media['src']) ?>"></audio>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Ajout de médias -->
        <div id="media-upload">
            <form id="form-media" action="traitement/ajouter_media.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jour" value="<?= $jour ?>">
                <label for="fichier">➕ Ajouter des médias :</label><br><br>
                <input type="file" name="medias[]" id="fichier" multiple accept="image/*,video/*,audio/*"><br><br>
                <button type="submit">📤 Envoyer</button>
            </form>
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="controls">
    <?php if ($jour > min($jours_disponibles)): ?>
        <button onclick="changerJour(<?= $jour - 1 ?>)">⟵ Jour précédent</button>
    <?php endif; ?>
    <?php if ($jour < max($jours_disponibles)): ?>
        <button onclick="changerJour(<?= $jour + 1 ?>)">Jour suivant ⟶</button>
    <?php endif; ?>
</div>

<!-- Ajouter une page -->
<?php if ($jour === max($jours_disponibles)): ?>
    <div class="controls">
        <form method="POST" action="traitement/ajouter_page.php" style="display:inline;">
            <button type="submit">➕ Ajouter une page</button>
        </form>
    </div>
<?php endif; ?>

<script src="js/main.js"></script>

</body>
</html>
