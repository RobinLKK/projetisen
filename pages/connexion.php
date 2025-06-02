<?php
session_start();
if (isset($_SESSION["authentifie"]) && $_SESSION["authentifie"] === true) {
    header("Location: profil.php");
    exit();
}

$errorMessage = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'empty') {
        $errorMessage = "Veuillez remplir tous les champs.";
    } elseif ($_GET['error'] == 'mdp') {
        $errorMessage = "Mot de passe incorrect.";
    } elseif ($_GET['error'] == 'email') {
        $errorMessage = "Email invalide";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device.width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>MSD - Connexion</title>
    <link rel="icon" type="image/x-icon" href="../media/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../style/main.css">
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/connexion.css">
</head>

<body>
    <section class="fond">
        <video autoplay loop muted playsinline class="video-webm">
            <source src="../media/fond.webm" type="video/webm">
        </video>
        <div class="overlay">
            <nav class="navbar">
                <div class="logo">
                    <a href="../index.html"><img src="../media/logo_msd.png" alt="Logo"></a>
                </div>
                <div class="navbar-menu">
                    <a href="accueil.php">ACCUEIL</a>
                    <a href="shop.php">BOUTIQUE</a>
                    <a href="contact.php">CONTACT</a>
                </div>
            </nav>
            <div class="conteneur-login-global">
                <?php if (!empty($errorMessage)): ?>
                    <div class="error-message">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="conteneur-login">
                    <form action="../traitements/traitement_connexion.php" method="post">
                        <h1>Connexion</h1>
                        <div class="input-box">
                            <input type="email" placeholder="Email" name="email" required>
                            <img id="user" src="../media/icon-mail.png" alt="icon-account">
                        </div>
                        <div class="input-box">
                            <input type="password" placeholder="Mot de passe" name="password" required>
                            <img id="pwd" src="../media/icon-lock.png" alt="icon-lock">
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="remember-me" name="remember-me">
                            <label for="remember-me">Se souvenir de moi</label>
                        </div>
                        <button type="submit" class="btn" name="Connexion">Se connecter</button>
                        <div class="inscription">
                            <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
