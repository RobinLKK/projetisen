<?php
if (isset($_POST["Connexion"])) {
    try {
        require("db.php");

        if (empty($_POST['email']) || empty($_POST['password'])) {
            header('location:../pages/connexion.php?error=empty');
            exit();
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $req = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $req->execute([':email' => $email]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['id_user'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['authentifie'] = TRUE;
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['date_creation'] = $user['date_creation'];

            
            if (isset($_POST['remember-me'])) {
                $token = bin2hex(random_bytes(32));
                $stmt = $conn->prepare("UPDATE utilisateurs SET remember_token = :token WHERE id = :id");
                $stmt->execute([':token' => $token, ':id' => $user['id']]);

                setcookie('remember_token', $token, [
                    'expires' => time() + (30 * 24 * 60 * 60),
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
            }

            header("location:../pages/" . ($user['admin'] ? "admin.php" : "accueil.php"));
            exit();
        } else {
            header('location:../pages/connexion.php?error=' . ($user ? 'mdp' : 'email'));
            exit();
        }

    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>