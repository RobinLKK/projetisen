<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>rob1.lkk</title>
    <link rel="stylesheet" href="css/main.css">
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

<script src="JS/welcome.js"></script>
<script src="JS/main.js"></script>
<script src="JS/music.js"></script>

</body>
</html>
