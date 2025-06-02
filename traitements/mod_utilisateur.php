<?php

require_once 'db.php';

$user_id_to_edit = null;
$user_data = null;
$error_message = '';
$success_message = '';
$form_errors = [];

$nom = '';
$prenom = '';
$email = '';
$admin = 0;

if (isset($_POST['user_id']) && filter_var($_POST['user_id'], FILTER_VALIDATE_INT)) {
    $user_id_to_edit = (int)$_POST['user_id'];
} elseif (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $user_id_to_edit = (int)$_GET['id'];
}

if ($user_id_to_edit === null) {
    header('location: ../pages/admin.php?error=invalid_user_id');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $admin = isset($_POST['admin']) ? 1 : 0;
    $password = trim($_POST['password'] ?? '');

    if (empty($nom)) {
        $form_errors['nom'] = 'Le nom est requis';
    }
    if (empty($prenom)) {
        $form_errors['prenom'] = 'Le prénom est requis';
    }
    if (empty($email)) {
        $form_errors['email'] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_errors['email'] = "Le format de l'email est invalide";
    } else {
        try {
            $sql_check_email = "SELECT id FROM utilisateurs WHERE email = :email AND id != :id";
            $stmt_check_email = $conn->prepare($sql_check_email);
            $stmt_check_email->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_check_email->bindParam(':id', $user_id_to_edit, PDO::PARAM_INT);
            $stmt_check_email->execute();
            if ($stmt_check_email->fetch()) {
                $form_errors['email'] = 'Cet email est déjà utilisé par un autre compte';
            }
        } catch (PDOException $e) {
            $error_message = 'Erreur lors de la vérification de l\'email';
        }
    }

    if (empty($form_errors) && empty($error_message)) {
        try {
            if (!empty($password)) {
                $sql_update = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, admin = :admin, password = :password WHERE id = :id";
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $sql_update = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, admin = :admin WHERE id = :id";
            }

            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt_update->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_update->bindParam(':admin', $admin, PDO::PARAM_INT);
            $stmt_update->bindParam(':id', $user_id_to_edit, PDO::PARAM_INT);
            if (!empty($password)) {
                $stmt_update->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            }

            if ($stmt_update->execute()) {
                header('location: ../pages/admin.php?success=user_updated');
                exit;
            } else {
                $error_message = 'Erreur lors de la mise à jour de l\'utilisateur';
            }
        } catch (PDOException $e) {
            $error_message = 'Erreur technique lors de la mise à jour';
        }
    }
}

if (empty($success_message) && empty($error_message) && $_SERVER['REQUEST_METHOD'] !== 'POST' || !empty($form_errors)) {
    try {
        $sql_select = "SELECT nom, prenom, email, admin FROM utilisateurs WHERE id = :id";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bindParam(':id', $user_id_to_edit, PDO::PARAM_INT);
        $stmt_select->execute();
        $user_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if (!$user_data) {
            $error_message = 'Utilisateur non trouvé';
        } else {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $nom = $user_data['nom'];
                $prenom = $user_data['prenom'];
                $email = $user_data['email'];
                $admin = $user_data['admin'];
            }
        }
    } catch (PDOException $e) {
        $error_message = 'Erreur lors de la récupération des données utilisateur';
        $user_data = null;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur - Administration</title>
    <!-- <link rel="stylesheet" href="../style/admin.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #444;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #333;
        }
        input[type="checkbox"] {
            margin-right: 5px;
            vertical-align: middle;
        }
        .checkbox-label {
            display: inline-block;
            margin-bottom: 15px;
            color: #555;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .form-error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: -10px;
            margin-bottom: 10px;
            display: block;
        }
        input.error-field {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier Utilisateur #<?php echo htmlspecialchars($user_id_to_edit ?? ''); ?></h1>

        <?php if ($error_message): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if ($user_data !== null || $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <form action="mod_utilisateur.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id_to_edit); ?>">

            <div>
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required
                       class="<?php echo isset($form_errors['nom']) ? 'error-field' : ''; ?>">
                <?php if (isset($form_errors['nom'])): ?>
                    <span class="form-error"><?php echo $form_errors['nom']; ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required
                       class="<?php echo isset($form_errors['prenom']) ? 'error-field' : ''; ?>">
                <?php if (isset($form_errors['prenom'])): ?>
                    <span class="form-error"><?php echo $form_errors['prenom']; ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required
                       class="<?php echo isset($form_errors['email']) ? 'error-field' : ''; ?>">
                <?php if (isset($form_errors['email'])): ?>
                    <span class="form-error"><?php echo $form_errors['email']; ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">Nouveau Mot de Passe</label>
                <input type="password" id="password" name="password"
                       class="<?php echo isset($form_errors['password']) ? 'error-field' : ''; ?>">
                <small style="color: #aaa; font-size: 0.8em;">Laisser vide pour ne pas changer le mot de passe.</small>
                <?php if (isset($form_errors['password'])): ?>
                    <span class="form-error"><?php echo $form_errors['password']; ?></span>
                <?php endif; ?>
            </div>

            <div>
                <input type="checkbox" id="admin" name="admin" value="1" <?php echo ($admin == 1) ? 'checked' : ''; ?>>
                <label for="admin" class="checkbox-label">Administrateur</label>
            </div>

            <button type="submit">Mettre à jour</button>

        </form>
        <?php elseif (!$error_message): ?>
            <p>Chargement des données utilisateur...</p>
        <?php endif; ?>

        <a href="../pages/admin.php#users" class="back-link">Retour à la liste des utilisateurs</a>
    </div>
</body>
</html>
