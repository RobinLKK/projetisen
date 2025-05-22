<?php
// session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Non connecté");
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    UPDATE utilisateurs
    SET total_games = COALESCE(total_games, 0) + 1
    WHERE id = ?
");
$stmt->execute([$user_id]);
