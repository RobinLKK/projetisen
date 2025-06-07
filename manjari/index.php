<?php
// Récupère le jour à afficher (par défaut : 1)
$jour = isset($_GET['jour']) ? (int)$_GET['jour'] : 1;

// Charge les données depuis le fichier JSON
$data = json_decode(file_get_contents('data/journal.json'), true);
$entryKey = "jour_$jour";
$entry = $data[$entryKey] ?? null;

// 🔽 AJOUT : calcule le dernier jour du JSON
$dernierJour = max(array_map(function($key) {
    return (int)str_replace('jour_', '', $key);
}, array_keys($data)));
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
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap" rel="stylesheet">


</head>
<body>
    <div class="journal">
        <div class="page gauche">
            <h2>Jour <?= $jour ?></h2>
<?php if ($entry): ?>
    <?php if (empty(trim($entry['texte']))): ?>
        <!-- Si le texte est vide : on affiche un formulaire pour écrire -->
<form method="POST" action="traitement/sauver_page.php" style="display:none; margin-top:15px;">
            <input type="hidden" name="jour" value="<?= $jour ?>">
            <textarea name="texte" rows="12" cols="50" placeholder="Écris ici ta nouvelle page..." required></textarea><br>
            <button type="submit">💾 Enregistrer</button>
        </form>
    <?php else: ?>
        <!-- Sinon on affiche le texte normalement -->
        <p><?= nl2br(htmlspecialchars($entry['texte'])) ?></p>
    <?php endif; ?>
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
            <?php if ($entry): ?>
            <div style="text-align:right; margin-top: 20px;">
                <button onclick="document.getElementById('form-edit-texte').style.display='block'">✏️ Modifier le texte</button>
            </div>
             <?php endif; ?>
                        <!-- Formulaire d'ajout de médias -->
            <div id="media-upload">
                <form id="form-media" action="traitement/ajouter_media.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="jour" value="<?= $jour ?>">
                    <label for="fichier">➕ Ajouter des médias (glisser-déposer ou cliquer) :</label><br><br>
                    <input type="file" name="medias[]" id="fichier" multiple accept="image/*,video/*,audio/*"><br><br>
                    <button type="submit">📤 Envoyer</button>
                </form>
            </div>


        </div>
    </div>
    <div class="controls">
        <?php if ($jour > 1): ?>
            <button onclick="changerJour(<?= $jour - 1 ?>)">⟵ Jour précédent</button>
        <?php endif; ?>
        <button onclick="changerJour(<?= $jour + 1 ?>)">Jour suivant ⟶</button>
    </div>
    <?php if ($jour >= $dernierJour): ?>
    <div class="controls">
<button onclick="toggleAjoutPage()">➕ Ajouter une page</button>
    </div>
    <?php endif; ?>
    <?php if ($jour < $dernierJour): ?>
    <button onclick="changerJour(<?= $jour + 1 ?>)">Jour suivant ⟶</button>
    <?php endif; ?>


    <script src="js/main.js"></script>

    <form id="form-ajout" action="traitement/ajouter_page.php" method="POST" enctype="multipart/form-data" style="display:none; text-align:center; margin-top:20px;">
    <h3>Nouvelle page de journal</h3>
    <textarea name="texte" rows="10" cols="60" placeholder="Écris ta nouvelle page ici...">Aujourd'hui...</textarea>
    
    <label>Médias :</label><br>
    <input type="file" name="medias[]" multiple accept="image/*,video/*,audio/*"><br><br>

    <button type="submit">📥 Enregistrer</button>
</form>

</body>
</html>
