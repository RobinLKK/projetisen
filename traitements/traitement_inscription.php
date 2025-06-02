<?php

function nettoyer_donnees($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

function valider_NomPrenom($NomPrenom){
    return preg_match("/^[a-zA-ZÀ-ÿ\s'-]{1,40}$/u", $NomPrenom);
}

if (isset($_POST["Ajouter"])) {
    try {
        require("db.php");

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('Location: ../pages/inscription.php');
            exit;
        }

        if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirm'])) {
            header('Location: ../pages/inscription.php?error=empty');
            exit;
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            header('Location: ../pages/inscription.php?error=mdp_confirm');
            exit;
        }

        $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt->execute([':email' => $_POST['email']]);
        if ($stmt->fetch()) {
            header('Location: ../pages/inscription.php?error=email_utilise');
            exit;
        }

        $nom = nettoyer_donnees($_POST['nom']);
        $prenom = nettoyer_donnees($_POST['prenom']);
        $email = nettoyer_donnees($_POST['email']);
        $password = password_hash(nettoyer_donnees($_POST['password']), PASSWORD_BCRYPT);

        if (!valider_NomPrenom($nom) || !valider_NomPrenom($prenom)) {
            header('Location: ../pages/inscription.php?error=nom_prenom_invalide');
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, remember_token, authentifie, admin, date_creation) VALUES (:nom, :prenom, :email, :password, NULL, TRUE, FALSE, CURRENT_TIMESTAMP)");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $password
        ]);

        $conn = null;
        header("Location: ../pages/connexion.php?success=inscription");
        exit;
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
