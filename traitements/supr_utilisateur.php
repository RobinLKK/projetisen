<?php

require_once 'db.php';

$user_id_to_delete = null;
$redirect_url = '../pages/admin.php';

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $user_id_to_delete = (int)$_GET['id'];
} else {
    header('location: ' . $redirect_url . '?error=id_utilisateur_invalide');
    exit;
}

if ($user_id_to_delete) {
    try {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $user_id_to_delete, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('location: ' . $redirect_url . '?success=utilisateur_supprime');
            exit;
        } else {
            header('location: ' . $redirect_url . '?error=utilisateur_introuvable');
            exit;
        }
    } catch (PDOException $e) {
        header('location: ' . $redirect_url . '?error=echec_suppression');
        exit;
    }
}

header('location: ' . $redirect_url . '?error=erreur_inconnue');
exit;

?>
