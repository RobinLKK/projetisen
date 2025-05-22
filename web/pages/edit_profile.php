    <?php
    session_start();
    require '../includes/db.php';
    require '../includes/functions.php';

    if (!isLoggedIn()) {
        redirect("login.php");
    }

    $user_id = $_SESSION['user_id'];
    $user = getUserProfile($pdo, $user_id);

    $errors = [];

    // Gérer la mise à jour du profil
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $bio = trim($_POST['bio']);
        $bio = htmlspecialchars($bio, ENT_QUOTES, 'UTF-8');
        $avatar_path = null;

        // Vérifie si un fichier avatar a été uploadé
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_path = handleAvatarUpload($_FILES['avatar'], $user_id);
        }

        // Met à jour le profil
        updateUserProfile($pdo, $user_id, $username, $email, $bio, $avatar_path);

        // Vérifie si l'utilisateur veut changer son mot de passe
        if (!empty($_POST['current_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
            $current_password = sanitizeInput($_POST['current_password']);
            $new_password = sanitizeInput($_POST['new_password']);
            $confirm_password = sanitizeInput($_POST['confirm_password']);

            // Vérifie si tous les champs sont remplis
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $errors[] = "Tous les champs de mot de passe doivent être remplis.";
            }

            // Vérifie que les nouveaux mots de passe correspondent
            if ($new_password !== $confirm_password) {
                $errors[] = "Les nouveaux mots de passe ne correspondent pas.";
            }

            // Vérifie l'ancien mot de passe
            $stmt = $pdo->prepare("SELECT password FROM utilisateurs WHERE id = ?");
            $stmt->execute([$user_id]);
            $stored_password = $stmt->fetchColumn();

            if (!password_verify($current_password, $stored_password)) {
                $errors[] = "L'ancien mot de passe est incorrect.";
            }

            // Si pas d'erreurs, on met à jour le mot de passe
            if (empty($errors)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $user_id]);
                setFlashMessage("Mot de passe modifié avec succès.", "success");
                redirect("profile.php");
            }
        }

        // Redirige uniquement si pas d'erreurs
        if (empty($errors)) {
            setFlashMessage("Profil mis à jour avec succès.", "success");
            redirect("profile.php");
        }
    }
    ?>
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
        <title>Modifier le profil</title>
        <link rel="stylesheet" href="../css/profile.css">
    </head>
    <body>
        <div class="profile-container">
            <h2>Modifier le profil</h2>

            <!-- Affichage des erreurs -->
            <?php if (!empty($errors)): ?>
                <div class="flash-message danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email :</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="bio">Bio :</label>
                <textarea name="bio" id="bio" rows="4"><?php echo $user['bio']; ?></textarea>

            <label for="avatar">Avatar :</label>
                <input type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png,.gif" onchange="previewImage(event)">

                <!-- Prévisualisation de l'avatar -->
                <div id="avatar-preview-container">
                    <img id="avatar-preview" src="../<?php echo htmlspecialchars($user['avatar']); ?>" alt="Aperçu de l'avatar" class="avatar-preview">
                </div>

                <div class="password-section">
                    <label for="current_password">Ancien mot de passe :</label>
                    <input type="password" name="current_password" id="current_password">

                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new_password">

                    <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </div>

                <button type="submit" class="primary-btn">Enregistrer les modifications</button>
            </form>

            <a href="profile.php" class="primary-btn">Retour au profil</a>
        </div>
        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('avatar-preview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

    </body>
    </html>
