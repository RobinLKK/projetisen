<!-- web/pages/index.php -->
<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>The Big Bang ISEN</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/main.js" defer></script>
</head>
    <body>
    <?php include '../includes/navbar.php'; ?>

    <main>
        <h2>Coucou, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h2>
        <p>Bienvenue sur The Big Bang ISEN project.</p>
        <div class="play-button-container">
            <a href="menu.php" class="play-button">Jouer</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 The Big Bang ISEN. All rights reserved.</p>
    </footer>
</body>
</html>
