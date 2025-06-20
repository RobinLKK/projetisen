<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>R</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DEV">
    <meta name="author" content="rob1.lkk">
</head>
<body>
<div id="welcome-screen">
    <h1>Welcome</h1>
    <p id="press-key">Press any key or click to continue</p>
</div>

<!-- <div id="bg-gif"></div> -->

<video autoplay muted loop id="bg-video">
    <source src="bg/cloud.mp4" type="video/mp4">
</video>



<div class="profile-wrapper">
  <div class="profile-container">
    <div class="light"></div>
    <img class="avatar" src="media/aomine.jpg" alt="Avatar rob1">
    <h1 class="username">
    rob1.lkk
    <span class="badge">
        <img src="https://i.postimg.cc/g2n10FHt/badge-dev.png" alt="Dev badge">
        <span>Developer</span>
    </span>
    </h1>

<p class="tagline typewriter-glow" id="dynamic-desc"> </p>
    <div class="socials">
        <a href="#" target="_blank" title="Discord">
            <img src="https://cdn-icons-png.flaticon.com/512/5968/5968756.png" alt="Discord">
        </a>
        <a href="#" target="_blank" title="GitHub">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub">
        </a>
        <a href="#" title="Spotify">
            <img src="https://cdn-icons-png.flaticon.com/512/2111/2111624.png" alt="Spotify">
        </a>
    </div>
    <div class="views">👁 666 666</div>
  </div>
</div>

<div id="volume-control">
  <button id="toggle-music">🔊</button>
  <div id="volume-slider-wrapper">
    <input type="range" id="volume-slider" min="0" max="1" step="0.01" value="0.5">
  </div>
</div>



<audio id="bg-music" loop>
    <source src="media/khali.mp3" type="audio/mpeg">
</audio>

<script src="js/welcome.js" defer></script>
<script src="js/main.js"></script>
<script src="js/audio.js"></script>
<script src="js/description.js"></script>


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

<div id="song-info">🎵 Khali - PLM Deathrow</div>

</body>
</html>
