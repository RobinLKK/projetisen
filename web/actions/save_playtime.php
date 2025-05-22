<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Non connecté");
}

$data = json_decode(file_get_contents("php://input"), true);
$duration = isset($data['duration']) ? intval($data['duration']) : 0;

if ($duration > 0) {
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        UPDATE utilisateurs
        SET total_time_played = COALESCE(total_time_played, 0) + ?
        WHERE id = ?
    ");
    $stmt->execute([$duration, $user_id]);
}
