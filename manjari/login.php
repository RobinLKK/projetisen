<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Chercher user
    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Identifiant ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="login-container">
    <h2>Connexion</h2>
    <form method="POST" action="">
        <label for="username">Utilisateur :</label>
        <input id="username" type="text" name="username" required autofocus>
        
        <label for="password">Mot de passe :</label>
        <input id="password" type="password" name="password" required>
        
        <button type="submit">Se connecter</button>
    </form>
    <?php if ($error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>
</body>


<style>/* css/login.css */

@import url('https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap');

body {
  margin: 0;
  background: linear-gradient(135deg, #fbc490, #f7a654);
  font-family: 'Homemade Apple', cursive;
  color: #3b1f0b;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-container {
  background: #fff3e6;
  padding: 40px 35px;
  border-radius: 20px;
  box-shadow: 0 8px 20px rgba(251, 196, 144, 0.4);
  width: 360px;
  text-align: center;
  border: 2px solid #f7a654;
  transition: box-shadow 0.3s ease;
}

.login-container:hover {
  box-shadow: 0 12px 28px rgba(251, 196, 144, 0.7);
}

.login-container h2 {
  margin-bottom: 30px;
  font-size: 32px;
  font-weight: normal;
  letter-spacing: 1.2px;
  color: #d2691e;
  text-shadow: 1px 1px 0 #f7a654;
}

.login-container form label {
  display: block;
  text-align: left;
  margin-bottom: 6px;
  font-size: 18px;
  color: #a65300;
}

.login-container form input[type="text"],
.login-container form input[type="password"] {
  width: 100%;
  padding: 12px 15px;
  margin-bottom: 20px;
  border: 2px solid #f7a654;
  border-radius: 15px;
  font-family: 'Homemade Apple', cursive;
  font-size: 18px;
  box-sizing: border-box;
  transition: border-color 0.3s ease;
}

.login-container form input[type="text"]:focus,
.login-container form input[type="password"]:focus {
  border-color: #d2691e;
  outline: none;
}

.login-container form button {
  width: 100%;
  background-color: #d2691e;
  color: #fff3e6;
  border: none;
  border-radius: 18px;
  padding: 14px 0;
  font-size: 22px;
  cursor: pointer;
  font-family: 'Homemade Apple', cursive;
  transition: background-color 0.3s ease;
  box-shadow: 0 4px 10px rgba(210, 105, 30, 0.5);
}

.login-container form button:hover {
  background-color: #b45300;
  box-shadow: 0 6px 15px rgba(180, 83, 0, 0.7);
}

.error-message {
  color: #b22222;
  margin-top: 12px;
  font-size: 16px;
  font-weight: bold;
  text-shadow: 1px 1px 1px #fbe6d6;
}
</style></html>
