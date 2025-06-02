<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device.width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>MSD - Inscription</title>
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
                    <a href="contact.html">CONTACT</a>
                </div>
            </nav>

            <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $errorMessage = '';

                    if ($error == 'empty') {
                        $errorMessage = "Veuillez remplir tous les champs.";
                    } elseif ($error == 'mdp') {
                        $errorMessage = "Mot de passe incorrect.";
                    } elseif ($error == 'email') {
                        $errorMessage = "Email invalide";
                    } elseif ($error == 'nom_prenom_invalide') {
                        $errorMessage = "Nom / Prénom invalide";
                    }
                }
            ?>

            <div class="conteneur-login-global">
                <?php if (!empty($errorMessage)): ?>
                    <div class="error-message">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="conteneur-login">
                    <form action="../traitements/traitement_inscription.php" method="post">
                        <h1>Inscription</h1>
                        <div class="np">
                            <div class="input-box" id="nom">
                                <input type="text" placeholder="Nom" name="nom" required>
                            </div>
                            <div class="input-box">
                                <input type="text" placeholder="Prénom" name="prenom" required>
                            </div>
                        </div>
                        <div class="input-box">
                            <input type="email" placeholder="Adresse e-mail" name="email" required>
                            <img id="mail" src="../media/icon-mail.png" alt="icon-mail">
                        </div>
                        <div class="input-box">
                            <input type="password" placeholder="Mot de passe" name="password" required>
                            <img id="pwd" src="../media/icon-lock.png" alt="icon-lock">
                        </div>
                        <div class="input-box">
                            <input type="password" placeholder="Confirmer le mot de passe" name="password_confirm" required>
                            <img id="pwd" src="../media/icon-lock.png" alt="icon-lock">
                        </div>
                        <button type="submit" class="btn" name="Ajouter">S'inscrire</button>
                        <div class="inscription">
                            <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php require_once 'footer.php'; ?>
</body>

</html>
