<?php
session_start();
require '../includes/db.php';
require '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = getUserProfile($pdo, $user_id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" href="../css/profile.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="../js/main.js" defer></script>
</head>
<body>
        <?php include '../includes/navbar.php'; ?>
    <div class="profile-container">

        <a href="#" onclick="goBackSkippingEdit()" class="back-arrow">
            <i class="fas fa-arrow-left"></i>
        </a>

        <img src="../<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar de <?php echo htmlspecialchars($user['username']); ?>" class="profile-avatar">
        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        <p>Email : <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Bio : <?php echo nl2br(htmlspecialchars_decode($user['bio'], ENT_QUOTES)); ?></p> 
        <p>Meilleur score : <?php echo htmlspecialchars($user['best_score']); ?></p>
        <p>Total de parties jouées : <?php echo htmlspecialchars($user['total_games']); ?></p>
        <p>Temps total joué :
        <?php
            $temps = intval($user['total_time_played']);
            $h = floor($temps / 3600);
            $m = floor(($temps % 3600) / 60);
            $s = $temps % 60;

            if ($h > 0) {
                echo htmlspecialchars("{$h}h {$m}min");
            } elseif ($m > 0) {
                echo htmlspecialchars("{$m}min {$s}sec");
            } else {
                echo htmlspecialchars("{$s}sec");
            }
        ?>
        </p>

        <!-- Boutons -->
        <a href="edit_profile.php" class="primary-btn">Modifier le profil</a>
        <a href="login.php" class="secondary-btn">Déconnexion</a>
    </div>
</body>
</html>


