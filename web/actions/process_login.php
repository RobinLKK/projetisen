<!-- web/actions/process_login.php -->
<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// Vérification des données du formulaire
if (isset($_POST['identifier']) && isset($_POST['password'])) {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];
    
    // Vérifie si l'identifiant est un email ou un nom d'utilisateur
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        // Si c'est un email
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :identifier");
    } else {
        // Sinon, c'est un nom d'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = :identifier");
    }
    
    // Exécute la requête avec l'identifiant
    $stmt->execute(['identifier' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Vérifie le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../pages/index.php');
        exit();
    } else {
        // Erreur de connexion
        header('Location: ../pages/login.php?error=Identifiant ou mot de passe incorrect');
        exit();
    }
} else {
    header('Location: ../pages/login.php?error=Veuillez remplir tous les champs');
    exit();
}
?>
