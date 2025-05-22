<?php
// functions.php

/**
 * Sanitize user input to prevent XSS attacks.
 *
 * @param string $data
 * @return string
 */
function sanitizeInput($data) {
    // On ne doit pas utiliser htmlspecialchars ici pour éviter le double encodage
    return trim($data);
}


/**
 * Redirect to a specified URL.
 *
 * @param string $url
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Check if a user is logged in.
 *
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Display a flash message.
 *
 * @param string $message
 * @param string $type
 */
function setFlashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Get and clear the flash message.
 *
 * @return array|null
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}

/**
 * Get the current logged-in user's profile.
 *
 * @param PDO $pdo
 * @param int $user_id
 * @return array|null

 */function getUserProfile($pdo, $user_id) {
    $stmt = $pdo->prepare("
        SELECT id, username, email, avatar, bio, best_score, total_games, total_time_played
        FROM utilisateurs
        WHERE id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Update the profile of a user.
 *
 * @param PDO $pdo
 * @param int $user_id
 * @param string $username
 * @param string $email
 * @param string|null $bio
 * @param string|null $avatar_path
 */
function updateUserProfile($pdo, $user_id, $username, $email, $bio = null, $avatar_path = null) {
    if ($avatar_path) {
        $stmt = $pdo->prepare("
            UPDATE utilisateurs 
            SET username = ?, email = ?, bio = ?, avatar = ? 
            WHERE id = ?
        ");
        $stmt->execute([
            sanitizeInput($username), 
            sanitizeInput($email), 
            sanitizeInput($bio), 
            sanitizeInput($avatar_path), 
            $user_id
        ]);
    } else {
        $stmt = $pdo->prepare("
            UPDATE utilisateurs 
            SET username = ?, email = ?, bio = ? 
            WHERE id = ?
        ");
        $stmt->execute([
            sanitizeInput($username), 
            sanitizeInput($email), 
            sanitizeInput($bio), 
            $user_id
        ]);
    }

    // Set a success message
    setFlashMessage("Profil mis à jour avec succès.", "success");
}








/**
 * Handle file upload for avatar.
 *
 * @param array $file
 * @param int $user_id
 * @return string|null
 */
function handleAvatarUpload($file, $user_id) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Vérifie l'extension du fichier
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed_extensions)) {
            setFlashMessage("Extension de fichier non autorisée. Utilisez JPG, JPEG, PNG ou GIF.", "danger");
            return null;
        }

        // Crée un nom unique pour le fichier
        $uploads_dir = __DIR__ . '/../uploads/';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $filename = "avatar_" . $user_id . "_" . time() . "." . $extension;
        $target_path = $uploads_dir . $filename;

        // Déplace le fichier
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Retourne le chemin relatif pour la base de données
            return 'uploads/' . $filename;
        } else {
            setFlashMessage("Erreur lors du téléversement de l'avatar.", "danger");
        }
    } else {
        setFlashMessage("Erreur lors du téléversement de l'avatar. Code d'erreur : " . $file['error'], "danger");
    }

    return null;
}

