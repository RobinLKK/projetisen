<?php
session_start();
require '../includes/db.php';
require '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link rel="stylesheet" href="../css/main.css"> <!-- Ce fichier doit contenir le CSS que tu as fourni -->
    <link rel="stylesheet" href="../css/menu.css"> 
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <main>
        <h1>Menu Principal</h1>
        <div class="menu-buttons">
            <form method="post" action="game.php">
                <input type="hidden" name="mode" value="level">
                <button type="submit" class="menu-button">Niveau</button>
            </form>
            <form method="post" action="game.php">
                <input type="hidden" name="mode" value="designer">
                <button type="submit" class="menu-button">Mode concepteur</button>
            </form>
            <form method="post" action="game.php">
                <input type="hidden" name="mode" value="random">
                <button type="submit" class="menu-button">Mode aléatoire</button>
            </form>
        </div>



    </main>

    <footer>
        <p>&copy;</p>
    </footer>
</body>
</html>
