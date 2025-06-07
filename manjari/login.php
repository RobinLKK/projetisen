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
<head><title>Connexion</title></head>
<body>
<h2>Connexion</h2>
<form method="POST">
    <label>Utilisateur : <input type="text" name="username" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button type="submit">Se connecter</button>
</form>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
</body>


<style>
    /* login.css */

body {
  margin: 0;
  background: #fff3e6;
  font-family: 'Homemade Apple', cursive;
  color: #4b2e2e;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-container {
  background: #f2c6a0;
  padding: 30px 40px;
  border-radius: 15px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  width: 320px;
  text-align: center;
}

.login-container h2 {
  margin-bottom: 25px;
  font-size: 28px;
}

.login-container form label {
  display: block;
  text-align: left;
  margin-bottom: 8px;
  font-size: 18px;
}

.login-container form input[type="text"],
.login-container form input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 18px;
  border: 2px solid #c49d79;
  border-radius: 10px;
  font-family: 'Homemade Apple', cursive;
  font-size: 18px;
  box-sizing: border-box;
}

.login-container form button {
  width: 100%;
  background-color: #4b2e2e;
  color: #fff3e6;
  border: none;
  border-radius: 12px;
  padding: 12px;
  font-size: 20px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  font-family: 'Homemade Apple', cursive;
}

.login-container form button:hover {
  background-color: #7f553f;
}

.error-message {
  color: red;
  margin-top: 12px;
  font-size: 16px;
}


</style>

</html>
