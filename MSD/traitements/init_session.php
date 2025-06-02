<?php
session_start();
require("db.php");

if (isset($_SESSION["authentifie"]) && $_SESSION["authentifie"] === true) {
    return;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (!isset($_SESSION['authentifie']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE remember_token = :token");
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['authentifie'] = true;
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['date_creation'] = $user['date_creation'];
    } else {
        setcookie('remember_token', '', time() - 3600, '/');
    }
}
?>
