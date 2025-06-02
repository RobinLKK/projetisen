<?php
require("../traitements/init_session.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>MSD - Contact</title>
  <link rel="icon" type="image/x-icon" href="../media/favicon.ico">
  <link rel="stylesheet" type="text/css" href="../style/main.css">
  <link rel="stylesheet" type="text/css" href="../style/navbar.css">
  <link rel="stylesheet" type="text/css" href="../style/contact.css">
</head>

<body>
  <?php require_once 'navbar.php'; ?>

  <div class="conteneur-faq-global">
    <h1>FAQ</h1>
    <div class="conteneur-faq">
      <div class="faq-item">
        <label class="faq-question" for="faq1">
          <span>Quel est votre morceau préféré parmi ceux que vous avez créés ?</span>
        </label>
        <input type="checkbox" id="faq1">
        <div class="faq-reponse">
          Mon morceau préféré est Rockstar c’est mon petit bébé car c’est mon tout premier son.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq2">
          <span>Êtes-vous indépendant ou signé sous un label ?</span>
        </label>
        <input type="checkbox" id="faq2">
        <div class="faq-reponse">
          Je suis indépendant pour garder le contrôle de ma musique et je n’ai pas de contrat à respecter, je fais de la musique quand l’envie me vient.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq3">
          <span>Quelle est votre stratégie pour promouvoir votre musique ?</span>
        </label>
        <input type="checkbox" id="faq3">
        <div class="faq-reponse">
          Je mise sur les réseaux sociaux, les plateformes de streaming, et les collaborations avec d’autres artistes pour toucher plus de monde.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq4">
          <span>Quel est le rôle des réseaux sociaux dans votre carrière ?</span>
        </label>
        <input type="checkbox" id="faq4">
        <div class="faq-reponse">
          C’est un outil puissant pour connecter avec mes fans, partager mon art, et promouvoir mes projets.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq5">
          <span>Un album ou EP est-il en préparation ?</span>
        </label>
        <input type="checkbox" id="faq5">
        <div class="faq-reponse">
          Oui, je travaille actuellement sur « La route est longue vers les étoiles » un album sur le thème du temps et des étoiles.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq6">
          <span>Comment choisissez-vous avec qui collaborer ?</span>
        </label>
        <input type="checkbox" id="faq6">
        <div class="faq-reponse">
          Je privilégie les connexions authentiques et les artistes qui partagent la même passion que moi.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq7">
          <span>Quelle serait votre collaboration rêvée ?</span>
        </label>
        <input type="checkbox" id="faq7">
        <div class="faq-reponse">
          Travailler avec houdi aka l’homme au masque de ski ça serait un rêve, car il a eu un impact énorme sur ma vision de la musique.
        </div>
      </div>
      <div class="faq-item">
        <label class="faq-question" for="faq8">
          <span>Quel est votre plus grand rêve en tant qu’artiste ?</span>
        </label>
        <input type="checkbox" id="faq8">
        <div class="faq-reponse">
          Marquer l’histoire du rap et inspirer des générations, tout en restant fidèle à mes valeurs.
        </div>
      </div>
    </div>
  </div>

  <div class="conteneur-contact-global">
    <div class="conteneur-contact">
      <form action="../traitements/traitement_contact.php" method="POST" enctype="multipart/form-data">
        <h1>Autres Questions ?</h1>
        <div class="input-box">
          <input type="email" name="email" placeholder="Adresse e-mail" required>
          <img id="mail" src="../media/icon-mail.png" alt="icon-mail">
        </div>
        <div class="input-box-text">
          <textarea id="question" name="message" rows="4" placeholder="Message" required></textarea>
        </div>
        <button type="submit" class="btn" name="Envoyer">Envoyer</button>
      </form>
    </div>
  </div>

  <?php require_once 'footer.php'; ?>
</body>

</html>
