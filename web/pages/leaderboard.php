<!-- web/pages/leaderboard.php -->
<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// On récupère les meilleurs scores avec le temps total
$stmt = $pdo->prepare("
    SELECT u.username, 
           COALESCE(MAX(s.score), 0) AS best_score, 
           COALESCE(u.total_time_played, 0) AS total_time_played
    FROM utilisateurs u
    LEFT JOIN scores s ON s.user_id = u.id
    GROUP BY u.id
    ORDER BY best_score DESC
    LIMIT 10
");

$stmt->execute();
$scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard - The Big Bang ISEN</title>
    <link rel="stylesheet" href="../css/leaderboard.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <main>
        <h2>Top 10 des joueurs</h2>
        <table>
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Nom d'utilisateur</th>
                    <th>Meilleur score</th>
                    <th>Temps total joué</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1;
                foreach ($scores as $row) {
                    $temps = intval($row['total_time_played']);
                    $h = floor($temps / 3600);
                    $m = floor(($temps % 3600) / 60);
                    $s = $temps % 60;

                    if ($h > 0) {
                        $tempsAffiche = "{$h}h {$m}min";
                    } elseif ($m > 0) {
                        $tempsAffiche = "{$m}min {$s}sec";
                    } else {
                        $tempsAffiche = "{$s}sec";
                    }

                    echo "<tr>";
                    echo "<td>" . $rank . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['best_score']) . "</td>";
                    echo "<td>" . htmlspecialchars($tempsAffiche) . "</td>";
                    echo "</tr>";
                    $rank++;
                }
                ?>
            </tbody>
        </table>
    </main>
    
    <footer>
        <p>&copy; 2025 The Big Bang ISEN. All rights reserved.</p>
    </footer>
</body>
</html>
