<?php
session_start();
if (!isset($_SESSION['authentifie']) || $_SESSION['authentifie'] !== true) {
    header('Location: connexion.php');
    exit();
}

$user_id = $_SESSION['id_user'];
require_once '../traitements/db.php';

$stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE id = :id');
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    $updateStmt = $conn->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, password = :password WHERE id = :id');
    $updateStmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'password' => $password,
        'id' => $user_id
    ]);

    header('Location: profil.php');
    exit();
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
    <link rel="stylesheet" type="text/css" href="../style/profil.css">
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
            <div class="container">
                <h1>Modifier votre profil</h1>
                <form method="POST" class="profile-form">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>"
                        required>

                    <label for="password">Mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" id="password" name="password">

                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>