<?php
session_start();
require '../includes/db.php';
require '../includes/functions.php';
$mode = $_POST['mode'] ?? $_GET['mode'] ?? null;
$submittedDesigner = isset($_POST['submit_designer']);


if (!isLoggedIn()) {
    header("Location: ../pages/login.php");
    exit();
}

// Incrémente le compteur de parties jouées
include_once '../actions/start_play_session.php';
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiPath - The Big Bang ISEN</title>
    <link rel="stylesheet" href="../css/main.css"> <!-- styles globaux -->
    <link rel="stylesheet" href="../css/logipath.css"> <!-- styles spécifiques au jeu -->
</head>
<body>

    <!-- Header + navigation -->
    <?php include '../includes/navbar.php'; ?>


    <!-- Contenu principal -->
 <main>
<?php if ($mode === 'designer' && !$submittedDesigner): ?>
    <h2>Création d’un niveau personnalisé</h2>
    <form method="post" style="display:flex; flex-direction:column; gap:15px; align-items:center;">
        <input type="hidden" name="mode" value="designer">

        <label>
            Taille de la grille :
            <input type="number" name="grid_size" min="2" max="20" required value="5">
        </label>

        <label>
            Règle :
            <select name="rule" id="rule-selector" onchange="toggleRuleParam(this.value)" required>
                <option value="croissant">croissant</option>
                <option value="superieur">supérieur</option>
                <option value="inferieur">inférieur</option>
                <option value="multiple">multiple</option>
                <option value="paire">paire</option>
                <option value="impair">impair</option>
                <option value="meme_parite">même parité</option>
                <option value="somme_chiffres_paire">somme chiffres paire</option>
                <option value="multiple_precedent">multiple précédent</option>
                <option value="premier">premier</option>
                <option value="somme_chiffres">somme chiffres</option>
            </select>
        </label>

        <label id="rule-param-container" style="display:none;">
            Paramètre (ex : 3) :
            <input type="number" name="ruleParam" min="1">
        </label>

        <button type="submit" name="submit_designer">Générer la grille</button>
    </form>

    <script>
    function toggleRuleParam(val) {
        const needsParam = ['multiple', 'somme_chiffres'].includes(val);
        document.getElementById('rule-param-container').style.display = needsParam ? 'block' : 'none';
    }
    </script>

<?php else: ?>
    <!-- Interface de jeu normale -->
    <h3 id="level-number">Niveau : 1</h3>
    <hr>
    <h2 id="steps">Étapes : 0</h2>

    <div class="controls">
        <span id="rule-text"><strong>Règle :</strong></span>
    </div>

    <div id="board"></div>
    <h1><div id="message">Commande dev </div></h1>
    <div class="controls">
        <button id="replay">Rejouer</button>
        <button id="undo">Annuler</button>
        <button id="history">Historique</button>
        <button id="designer">Mode concepteur</button>
        <button id="export">Exporter JSON</button>
        <button id="generate-random">Générer un niveau aléatoire</button>
        <button id="solve-level">Résoudre</button>
    </div>

    <pre id="output"></pre>

    <div class="controls">
        <button onclick="changeLevel(currentLevel - 1)">Niveau précédent</button>
        <button onclick="changeLevel(currentLevel + 1)">Niveau suivant</button>
    </div>
<?php endif; ?>
</main>

    <!-- Footer -->
    <footer>
        &copy; 2025 - The Big Bang ISEN - LogiPath
    </footer>

    <!-- Script JS -->
    <script src="../js/logipath.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mode = <?php echo json_encode($mode); ?>;
    const submittedDesigner = <?php echo json_encode($submittedDesigner); ?>;
    const gridSize = <?php echo json_encode($_POST['grid_size'] ?? null); ?>;
    const rule = <?php echo json_encode($_POST['rule'] ?? null); ?>;
    const ruleParam = <?php echo json_encode($_POST['ruleParam'] ?? null); ?>;

    if (mode === 'designer' && submittedDesigner) {
        const n = parseInt(gridSize) || 5;
        grid = Array.from({ length: n }, () => Array(n).fill(0));

        const ruleTextMap = {
            croissant: "Déplacement vers une case supérieure",
            superieur: "Déplacement vers une case supérieure",
            inferieur: "Déplacement vers une case inférieure",
            multiple: "Déplacement sur un multiple de " + ruleParam,
            paire: "Déplacement sur un nombre pair",
            impair: "Déplacement sur un nombre impair",
            meme_parite: "Même parité que la case précédente",
            somme_chiffres_paire: "Somme des chiffres paire",
            multiple_precedent: "Multiple de la case précédente",
            premier: "Nombre premier",
            somme_chiffres: "Somme des chiffres = " + ruleParam
        };

        levels[0] = {
            grid: JSON.parse(JSON.stringify(grid)),
            rule: rule,
            ruleParam: ruleParam,
            ruleText: ruleTextMap[rule] || "Règle personnalisée"
        };

        currentLevel = 0;
        position = { x: 0, y: 0 };
        history = [ { ...position } ];
        steps = 0;
        designerMode = true;

        document.getElementById('designer').textContent = "Quitter concepteur";
        document.getElementById('output').style.display = "block";
        document.getElementById('output').textContent = "Cliquez sur une case pour modifier sa valeur.";
        renderGrid();
    }

    if (mode === 'random') {
        // Force le clic sur le bouton "Générer un niveau aléatoire"
        const btn = document.getElementById('generate-random');
        if (btn) {
            setTimeout(() => {
                btn.click();
            }, 100); // délai pour que le DOM soit prêt
        }
    }
});
</script>



</body>
</html>
