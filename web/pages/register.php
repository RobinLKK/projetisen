<!-- web/pages/register.php -->
 <?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $httpsUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $httpsUrl");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte - The Big Bang ISEN</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <header>
        <h1>Créer un compte</h1>
    </header>
    
    <main>
        <?php
        if (isset($_GET['error'])) {
            echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>
        
        <form method="POST" action="../actions/process_register.php">
            <label for="username">Nom d'utilisateur<span class="required">*</span> :</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Adresse e-mail<span class="required">*</span> :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Mot de passe<span class="required">*</span> :</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirm_password">Confirmer le mot de passe<span class="required">*</span> :</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit">Créer un compte</button>
        </form>
        
        <div class="auth-links">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 The Big Bang ISEN. All rights reserved.</p>
    </footer>
</body>
</html>
