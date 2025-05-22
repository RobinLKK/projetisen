<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Non connecté");
}

$data = json_decode(file_get_contents("php://input"), true);
$newScore = isset($data['score']) ? intval($data['score']) : 0;

if ($newScore > 0) {
    $user_id = $_SESSION['user_id'];

    // Récupérer le score actuel
    $stmt = $pdo->prepare("SELECT best_score FROM utilisateurs WHERE id = ?");
    $stmt->execute([$user_id]);
    $current = $stmt->fetchColumn();

    // Vérifie si on bat le score
    if ($current === null || $newScore > intval($current)) {
        $update = $pdo->prepare("UPDATE utilisateurs SET best_score = ? WHERE id = ?");
        $update->execute([$newScore, $user_id]);
    }
}
