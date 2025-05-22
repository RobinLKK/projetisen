
let startTime = Date.now();

window.addEventListener('beforeunload', function () {
    const endTime = Date.now();
    const durationInSeconds = Math.floor((endTime - startTime) / 1000);

    navigator.sendBeacon('../actions/save_playtime.php', JSON.stringify({
        duration: durationInSeconds
    }));
});

function saveScore(score) {
    fetch('../actions/save_score.php', {
        method: 'POST',
        body: JSON.stringify({ score }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(res => {
        if (res.ok) {
            console.log("Score sauvegardé !");
        }
    });
}


// Définition des niveaux
const levels = [
    {
        grid: [
            [2, 3, 6, 7, 8],
            [5, 9, 12, 13, 4],
            [1, 6, 18, 3, 9],
            [2, 5, 7, 15, 6],
            [1, 2, 3, 4, 9]
        ],
        rule: "multiple",
        ruleParam: 3,
        ruleText: "Déplacement uniquement sur un multiple de 3"
    },
    {
        // A revoir
         grid: [
        [2, 4, 6, 8, 10],
        [3, 5, 7, 9, 11],
        [12, 14, 16, 18, 20],
        [21, 23, 25, 27, 29],
        [30, 32, 34, 36, 38]
        ],
    rule: "paire",
    ruleText: "Déplacement uniquement sur un nombre pair"
    },
    {
        grid: [
        [2,  4,  6,  8, 10, 11],
        [3,  5,  7, 13, 12, 17], 
        [14, 19, 23, 29, 16, 31],
        [18, 37, 41, 43, 44, 47],
        [20, 53, 59, 61, 62, 67],
        [70, 71, 73, 79, 83, 89]
        ],
    rule: "premier",
    ruleText: "Déplacement uniquement sur un nombre premier"
    },
    {
        grid: [
            [2, 3, 4, 5, 6],
            [8, 7, 10, 9, 12],
            [14, 13, 16, 15, 18],
            [20, 19, 22, 21, 24],
            [26, 25, 28, 27, 30]
        ],
        rule: "meme_parite",
        ruleText: "Déplacement uniquement sur une case de même parité que la précédente"
    },
    {
        grid: [
            [2, 4, 8, 16, 32],
            [3, 6, 12, 24, 48],
            [5, 10, 20, 40, 80],
            [7, 14, 28, 56, 112],
            [9, 18, 36, 72, 144]
        ],
        rule: "multiple_precedent",
        ruleText: "Déplacement uniquement sur une case multiple de la précédente"
    },

    // autres niveaux
];

let currentLevel = 0;
const start = { x: 0, y: 0 };
const end = { x: 4, y: 4 };
let designerMode = false;
let grid, rule, position, history, steps;

// Change le niveau actuel
function changeLevel(n) {
    if (n < 0 || n >= levels.length) return;
    currentLevel = n;
    grid = JSON.parse(JSON.stringify(levels[currentLevel].grid));
    rule = levels[currentLevel].rule;
    position = { ...start };
    history = [ { ...start } ];
    steps = 0;
    renderGrid();
    
}

function isMultiple(val, n) {
    return val % n === 0;
}
function isPair(val) {
    return val % 2 === 0;
}
function isImpair(val) {
    return val % 2 === 1;
}
function isPremier(val) {
    if (val < 2) return false;
    for (let i = 2; i <= Math.sqrt(val); i++) {
        if (val % i === 0) return false;
    }
    return true;
}
function sommeChiffres(val) {
    return val.toString().split('').reduce((sum, c) => sum + Number(c), 0);
}
function isSommeChiffres(val, cible) {
    return sommeChiffres(val) === cible;
}
function isCroissant(val, prev) {
    return val > prev;
}
function isSuperieur(val, prev) {
    return val > prev;
}
function isInferieur(val, prev) {
    return val < prev;
}
function isMemeParite(val, prev) {
    return (val % 2) === (prev % 2);
}
function isSommeChiffresPaire(val) {
    return sommeChiffres(val) % 2 === 0;
}
function isMultiplePrecedent(val, prev) {
    return prev !== 0 && val % prev === 0;
}
// Applique la règle de déplacement
function checkRule(nx, ny) {
    const prev = grid[position.y][position.x];
    const next = grid[ny][nx];
    if (rule === "croissant") return isCroissant(next, prev);
    if (rule === "superieur") return isSuperieur(next, prev);
    if (rule === "inferieur") return isInferieur(next, prev);
    if (rule === "multiple") return isMultiple(next, levels[currentLevel].ruleParam);
    if (rule === "paire") return isPair(next);
    if (rule === "impair") return isImpair(next);
    if (rule === "meme_parite") return isMemeParite(next, prev);
    if (rule === "somme_chiffres_paire") return isSommeChiffresPaire(next);
    if (rule === "multiple_precedent") return isMultiplePrecedent(next, prev);
    if (rule === "premier") return isPremier(next);
    if (rule === "somme_chiffres") return isSommeChiffres(next, levels[currentLevel].ruleParam);

    return false;
}

// Affiche la grille à l’écran, met à jour le nombre d’étapes, la règle et le numéro du niveau.
function renderGrid() {
    const board = document.getElementById('board');
    const rows = grid.length;
    const cols = grid[0].length;
    board.style.setProperty('--rows', rows);
    board.style.setProperty('--cols', cols);
    board.innerHTML = '';
    for (let y = 0; y < rows; y++) {
        for (let x = 0; x < cols; x++) {
            const cell = document.createElement('div');
            cell.textContent = grid[y][x];
            if (x === position.x && y === position.y) cell.classList.add('current');
            else if (x === 0 && y === 0) cell.classList.add('start');
            else if (x === cols - 1 && y === rows - 1) cell.classList.add('end');
            if (designerMode) {
                cell.style.cursor = "pointer";
                cell.onclick = () => editCell(x, y);
            }
            board.appendChild(cell);
        }
    }
    document.getElementById('steps').textContent = `Étapes : ${steps}`;
    document.getElementById('rule-text').innerHTML = `<strong>Règle :</strong> ${levels[currentLevel].ruleText}`;
     document.getElementById('level-number').textContent = `Niveau : ${currentLevel + 1}`;
}   

window.changeLevel = changeLevel;

// Déplace la position actuelle
function move(dx, dy) {
    if (designerMode) return;
    const rows = grid.length;
    const cols = grid[0].length;
    const nx = position.x + dx;
    const ny = position.y + dy;
    if (nx < 0 || nx >= cols || ny < 0 || ny >= rows) return;
    // Appliquer la règle dès le premier déplacement
    if (!checkRule(nx, ny)) {
        alert("Déplacement interdit selon la règle !");
        return;
    }
    position = { x: nx, y: ny };
    history.push({ ...position });
    steps++;
    renderGrid();
    if (nx === cols - 1 && ny === rows - 1) {
    setTimeout(() => {
        alert(`Bravo ! Chemin trouvé en ${steps} étapes.`);
        saveScore(steps); 
    }, 100);
}

}
// Annuler le dernier mouvement
function undo() {
    if (designerMode) return;
    if (history.length > 1) {
        history.pop();
        position = { ...history[history.length - 1] };
        steps--;
        renderGrid();
    }
}
// Redémarre le niveau
function replay() {
    if (designerMode) return;
    position = { ...start };
    history = [ { ...start } ];
    steps = 0;
    renderGrid();
}
// Affiche l'historique du chemin
function showHistory() {
    const output = document.getElementById('output');
    output.style.display = 'block';
    output.textContent = "Historique du chemin :\n" + history.map(h => `[${h.x+1},${h.y+1}]`).join(" → ");
}
// activer/désactiver le mode concepteur
function toggleDesigner() {
    designerMode = !designerMode;
    document.getElementById('designer').textContent = designerMode ? "Quitter concepteur" : "Mode concepteur";
    document.getElementById('output').style.display = designerMode ? "block" : "none";
    renderGrid();
    if (designerMode) {
        document.getElementById('output').textContent = "Cliquez sur une case pour modifier sa valeur.";
    }
}
// Modifier la valeur d'une case
function editCell(x, y) {
    let val = prompt("Nouvelle valeur pour la case :", grid[y][x]);
    if (val !== null && !isNaN(val)) {
        grid[y][x] = parseInt(val, 10);
        renderGrid();
    }
}
// Exporter la grille en JSON
function exportJSON() {
    const output = document.getElementById('output');
    output.style.display = 'block';
    output.textContent = JSON.stringify(grid, null, 2);
}

// Dark/light mode (optionnel)
window.addEventListener('keydown', (e) => {
    if (designerMode) return;
    if (["ArrowUp", "z"].includes(e.key)) { move(0, -1); e.preventDefault(); }
    if (["ArrowDown", "s"].includes(e.key)) { move(0, 1); e.preventDefault(); }
    if (["ArrowLeft", "q"].includes(e.key)) { move(-1, 0); e.preventDefault(); }
    if (["ArrowRight", "d"].includes(e.key)) { move(1, 0); e.preventDefault(); }
    if (e.key === 'Backspace') { undo(); e.preventDefault(); }
    if (e.key === 'l') document.body.classList.toggle('dark');
});

document.getElementById('replay').onclick = replay;
document.getElementById('undo').onclick = undo;
document.getElementById('history').onclick = showHistory;
document.getElementById('export').onclick = exportJSON;
document.getElementById('designer').onclick = () => {
    if (!designerMode) {
        const size = prompt("Taille de la grille (ex : 5 pour 5x5)", "5");
        const n = parseInt(size);
        if (isNaN(n) || n < 2 || n > 20) {
            alert("Taille invalide.");
            return;
        }

        const rules = [
            "croissant", "superieur", "inferieur", "multiple",
            "paire", "impair", "meme_parite", "somme_chiffres_paire",
            "multiple_precedent", "premier", "somme_chiffres"
        ];

        const rule = prompt("Choisissez une règle parmi :\n" + rules.join(", "), "multiple");
        if (!rules.includes(rule)) {
            alert("Règle invalide.");
            return;
        }

        let ruleParam = null;
        if (rule === "multiple" || rule === "somme_chiffres") {
            const param = prompt("Entrez la valeur de ruleParam :", "3");
            ruleParam = parseInt(param);
            if (isNaN(ruleParam) || ruleParam < 1) {
                alert("Paramètre invalide.");
                return;
            }
        }

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

        // Crée une grille vide
        grid = Array.from({ length: n }, () => Array(n).fill(0));

        levels[0] = {
            grid: JSON.parse(JSON.stringify(grid)),
            rule,
            ruleParam,
            ruleText: ruleTextMap[rule]
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
    } else {
        designerMode = false;
        document.getElementById('designer').textContent = "Mode concepteur";
        document.getElementById('output').style.display = "none";
        renderGrid();
    }
};



window.onload = () => changeLevel(0);

document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('generate-random');
    if (btn) {
        btn.addEventListener('click', function() {
            fetch('../levels/generate_level.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Pour vérifier la réponse
                    levels[0] = {
                        grid: data.grid,
                        rule: data.rule,
                        ruleParam: data.ruleParam,
                        ruleText: data.ruleText
                    };
                    changeLevel(0);
                })
                .catch(err => alert("Erreur lors de la génération du niveau : " + err));
        });
    }
});

document.getElementById('solve-level').onclick = function() {
    let level = levels[currentLevel];
    let N = level.grid.length;
    let txt = N + " " + level.rule;
    if (level.ruleParam !== undefined) txt += " " + level.ruleParam;
    txt += "\n";
    for (let i = 0; i < N; i++) {
        txt += level.grid[i].join(" ") + "\n";
    }

    fetch('../levels/solver.php', {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "niveau=" + encodeURIComponent(txt)
    })
    .then(res => res.json())
    .then(data => {
        // Affiche la réponse du solver
        const output = document.getElementById('output');
        output.style.display = 'block';
        if (data.error) {
            output.textContent = "Erreur solveur : " + data.error;
        } else if (data.solvable) {
            output.textContent = "Ce niveau est solvable en " + data.steps + " étapes.";
            if (data.path) {
                output.textContent += "\nChemin : " + data.path.map(([x, y]) => `[${x+1},${y+1}]`).join(" → ");
            }
        } else {
            output.textContent = "Ce niveau n'est pas solvable.";
        }
    });
};