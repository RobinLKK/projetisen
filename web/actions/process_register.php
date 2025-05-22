<?php
session_start();
require_once '../includes/db.php';

function redirectWithError($msg) {
    header("Location: ../pages/register.php?error=" . urlencode($msg));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!$username || !$email || !$password || !$confirm) {
        redirectWithError("Tous les champs sont obligatoires.");
    }

    if ($password !== $confirm) {
        redirectWithError("Les mots de passe ne correspondent pas.");
    }

    // Vérifier unicité email/username
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = ? OR email = ?");
    $check->execute([$username, $email]);
    if ($check->fetch()) {
        redirectWithError("Nom d'utilisateur ou email déjà utilisé.");
    }

    // Hashage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion avec champs initiaux à 0
    $stmt = $pdo->prepare("
        INSERT INTO utilisateurs (username, email, password, total_games, best_score, total_time_played)
        VALUES (?, ?, ?, 0, 0, 0)
    ");
    $stmt->execute([$username, $email, $hashedPassword]);

    // Auto-login après inscription (optionnel)
    $_SESSION['user_id'] = $pdo->lastInsertId();
    header("Location: ../pages/index.php");
    exit();
} else {
    redirectWithError("Méthode invalide.");
}
