<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>R</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de Rob1, étudiant développeur">
    <meta name="author" content="rob1.lkk">
</head>
<body>
<div id="welcome-screen">
    <h1>Welcome</h1>
    <p id="press-key">Press any key or click to continue</p>
</div>

<div id="bg-gif"></div>
<div class="profile-wrapper">
  <div class="profile-container">
    <div class="light"></div>
    <img class="avatar" src="media/aomine.jpg" alt="Avatar rob1">
    <h1>rob1.lkk</h1>
    <p class="tagline">Un jour j'irai sur Saturn</p>
    <div class="socials">
        <a href="https://discord.com/users/rob1.lkk" target="_blank" title="Discord">
            <img src="https://cdn-icons-png.flaticon.com/512/5968/5968756.png" alt="Discord">
        </a>
        <a href="https://github.com/rob1" target="_blank" title="GitHub">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub">
        </a>
        <a href="#" title="Spotify">
            <img src="https://cdn-icons-png.flaticon.com/512/2111/2111624.png" alt="Spotify">
        </a>
    </div>
    <div class="views">👁 666 666</div>
  </div>
</div>

<button id="toggle-music">🔊</button>
<audio id="bg-music" loop>
    <source src="media/khali.mp3" type="audio/mpeg">
</audio>

<script src="js/main.js"></script>
<script src="js/welcome.js"></script>
<script src="js/audio.js"></script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const fullTitle = "R o b 1 |";
    let i = 0;
    let adding = true;

    function updateTitle() {
        if (adding) {
            document.title = fullTitle.slice(0, i + 1);
            i++;
            if (i === fullTitle.length) {
                adding = false;
                setTimeout(updateTitle, 1000); // pause avant d'effacer
                return;
            }
        } else {
            document.title = fullTitle.slice(0, i - 1);
            i--;
            if (i === 0) {
                adding = true;
                document.title = "_ "; // ou "_" si tu veux un effet visuel
                setTimeout(updateTitle, 1000); // pause avant de recommencer
                return;
            }
        }
        setTimeout(updateTitle, 325); // vitesse ajustée
    }

    updateTitle();
});

</script>


</body>
</html>
