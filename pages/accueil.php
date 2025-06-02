<?php
require("../traitements/init_session.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>MSD - Accueil</title>
  <link rel="icon" type="image/x-icon" href="../media/favicon.ico">
  <link rel="stylesheet" type="text/css" href="../style/main.css">
  <link rel="stylesheet" type="text/css" href="../style/navbar.css">
  <link rel="stylesheet" type="text/css" href="../style/accueil.css">
  <link rel="stylesheet" type="text/css" href="../style/cart.css">
</head>

<body>
  <section class="fond">
  <video autoplay loop muted playsinline class="video-webm">
    <source src="../media/fond.webm" type="video/webm">
  </video>
  <div class="overlay">
    <?php require_once 'navbar.php'; ?>
    <div class="bienvenue">
    <h1 class="msd">MSD</h1>
    <h2 style="color: white;">Un jeune rappeur indépendant</h2>
    <a class="infos" href="#infos">En savoir plus</a>
    </div>
  </div>
  </section>

  <div class="contenu" id="infos">
  <div class="conteneur-complet">
    <div class="conteneur-bio">
    <div class="question">
      <h2>Qui est MSD ?</h2>
    </div>
    <div class="image">
      <img src="../media/msd-cagoule.jpg" alt="Photo de MSD cagoulé avec un pull 'MSD'">
    </div>
    <div class="texte">
      <p>
      MSD est un jeune rappeur qui s'est lancé dans la musique en 2023 et n'a pas perdu de temps pour se faire remarquer.
      En juin 2024, il publie son premier single intitulé "Rockstar" sur SoundCloud, qui devient rapidement son morceau le plus streamé.
      Cet accueil encourageant marque un premier succès pour lui et le pousse à sortir un deuxième single, "BIG BIG Msd" cinq mois plus tard, en octobre 2024. Actuellement,
      MSD travaille sur une mixtape très attendue, bien que pour l'instant, aucune date de sortie n'ait été
      <a href="../media/sillycat.jpg" style="text-decoration: none; color: #FFFFFF;"> révélée</a>.
      </p>
    </div>
    </div>
  </div>
  </div>

  <h1>Discographie</h1>
  <div class="conteneur-discographie">
  <div class="discographie-grid">
    <div class="item" id="item1">
    <a href="#modal1">
      <img src="../media/covers/2k23.png" alt="Vinyl 1">
      <p>2k23</p>
    </a>
    </div>
    <div class="item" id="item2">
    <a href="#modal2">
      <img src="../media/covers/gros-potentiel.png" alt="Vinyl 2">
      <p>Gros Potentiel (feat. MaS)</p>
    </a>
    </div>
    <div class="item" id="item3">
    <a href="#modal3">
      <img src="../media/covers/fab.png" alt="Vinyl 3">
      <p>F.A.B</p>
    </a>
    </div>
    <div class="item" id="item4">
    <a href="#modal4">
      <img src="../media/covers/au-dessus-de-mon-toit.png" alt="Vinyl 4">
      <p>Au dessus de mon toit</p>
    </a>
    </div>
    <div class="item" id="item5">
    <a href="#modal5">
      <img src="../media/covers/nostalgie.png" alt="Vinyl 5">
      <p>Nostalgie</p>
    </a>
    </div>
    <div class="item" id="item6">
    <a href="#modal6">
      <img src="../media/covers/iris.png" alt="Vinyl 6">
      <p>Iris</p>
    </a>
    </div>
    <div class="item" id="item7">
    <a href="#modal7">
      <img src="../media/covers/rockstar.png" alt="Vinyl 7">
      <p>Rockstar</p>
    </a>
    </div>
    <div class="item" id="item8">
    <a href="#modal8">
      <img src="../media/covers/masda.png" alt="Vinyl 8">
      <p>Masda (feat. MSD)</p>
    </a>
    </div>
    <div class="item" id="item9">
    <a href="#modal9">
      <img src="../media/covers/big-big-msd.png" alt="Vinyl 9">
      <p>Big Big MSD</p>
    </a>
    </div>
  </div>
  </div>

  <div id="modal1" class="modal">
  <div class="modal-content">
    <a href="#item1" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>2k23</h2>
      <p class="description">
      Étant le premier son de MSD, nous n'avons pas plus d'information. Mis à part sa date de sortie, le
      21 septembre 2023, ce son marque un tournant car il est le premier d'une longue liste mais également
      par son mix dégelasse (il n'est pas mixé).
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal2" class="modal">
  <div class="modal-content">
    <a href="#item2" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Gros Potentiel (feat. MaS)</h2>
      <p class="description">
      Il s'agit d'un feat entre MSD et MaS, sorti le 23 septembre 2023, soit deux jours plus tard que "2k23",
      son tout premier son. Une petite drill bien méchante, mais toujours aucun signe d'un mix.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal3" class="modal">
  <div class="modal-content">
    <a href="#item3" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>F.A.B</h2>
      <p class="description">
      Un son dans un premier temps leaké, puis sorti le 17 octobre 2023. MSD fait ce son pour son meilleur ami,
      évoquant une amitié forte et produisant une masterclass.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal4" class="modal">
  <div class="modal-content">
    <a href="#item4" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Au dessus de mon toit</h2>
      <p class="description">
      Sur un petit synthé, MSD découpe la prod en faisant notamment des références à Death Note, Minecraft, son
      lycée, ou encore Fortnite. Sorti le 17 novembre 2023, il commence enfin à mixer un peu sa voix.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal5" class="modal">
  <div class="modal-content">
    <a href="#item5" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Nostalgie</h2>
      <p class="description">
      Il parle de nostalgie et le sort le 10 décembre 2023.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal6" class="modal">
  <div class="modal-content">
    <a href="#item6" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Iris</h2>
      <p class="description">
      Premier son sorti sur YouTube, sur une sad jersey. Sorti le 30 janvier 2024, il découpe la prod avec
      une performance impressionnante.
      <a href="https://www.youtube.com/watch?v=KJY0sKENe_Q" target="_blank">Lien YouTube</a>.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal7" class="modal">
  <div class="modal-content">
    <a href="#item7" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Rockstar</h2>
      <p class="description">
      Le plus gros classique de MSD et son tout premier son sorti officiellement sur SoundCloud.
      "Rockstar" sort pendant les vacances d'été, le 24 juin 2024, inspiré par son rêve de devenir une star,
      la prod hyperpop de SKT Kosmo, et sa femme. Un classique reconnu à l'international.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal8" class="modal">
  <div class="modal-content">
    <a href="#item8" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Masda (feat. MSD)</h2>
      <p class="description">
      Sorti le 22 août 2024, MSD mange son pote alors qu'il est invité sur le son.
      </p>
    </div>
    </div>
  </div>
  </div>

  <div id="modal9" class="modal">
  <div class="modal-content">
    <a href="#item9" class="close">×</a>
    <div class="modal-layout">
    <div class="modal-info">
      <h2>Big Big MSD</h2>
      <p class="description">
      Deuxième son sorti sur SoundCloud, "Big Big MSD" est sorti le 6 octobre 2024. MSD parle de sa peur
      de l'industrie musicale et de son envie de tout casser en 2025, sur une prod hyperpop brazil funk.
      </p>
    </div>
    </div>
  </div>
  </div>

  <?php require_once 'footer.php'; ?>
</body>

</html>
