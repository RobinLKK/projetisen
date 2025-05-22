<!-- web/pages/login.php -->
<!DOCTYPE html>
<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $httpsUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $httpsUrl");
    exit;
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - The Big Bang ISEN</title>
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <header>
        <h1>Connexion</h1>
    </header>
    
    <main>
        <?php
        if (isset($_GET['error'])) {
            echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>
        
        <form method="POST" action="https://rob1.eu/web/actions/process_login.php">
            <label for="identifier">Nom d'utilisateur / e-mail<span class="required">*</span> :</label>
            <input type="text" name="identifier" id="identifier" required>

            <label for="password">Mot de passe<span class="required">*</span> :</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <div class="auth-links">
            <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 The Big Bang ISEN. All rights reserved.</p>
    </footer>
</body>
</html>
