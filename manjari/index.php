<?php
// Récupère le jour à afficher (par défaut : 1)
$jour = isset($_GET['jour']) ? (int)$_GET['jour'] : 1;

// Charge les données depuis le fichier JSON
$data = json_decode(file_get_contents('data/journal.json'), true);
$entryKey = "jour_$jour";
$entry = $data[$entryKey] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal de Manjari - Jour <?= $jour ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manjareine">
    <meta name="author" content="Rob1, Xam">
</head>
<body>
    <div class="journal">
        <div class="page gauche">
            <h2>Jour <?= $jour ?></h2>
            <p><?= $entry ? htmlspecialchars($entry['texte']) : "Rien écrit ce jour-là..." ?></p>
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
        </div>
    </div>
    <div class="controls">
        <?php if ($jour > 1): ?>
            <button onclick="changerJour(<?= $jour - 1 ?>)">⟵ Jour précédent</button>
        <?php endif; ?>
        <button onclick="changerJour(<?= $jour + 1 ?>)">Jour suivant ⟶</button>
    </div>
    <script src="js/main.js"></script>
</body>
</html>
