<?php
if (isset($_POST["Envoyer"])) {
    try {
        require("db.php");

        // verif si la méthode est bien POST
        if ($_SERVER["REQUEST_METHOD"] != "POST")
            header("location:../pages/contact.php");

        // verif si les champs obligatoires sont remplis
        if (
            empty($_POST["email"]) || 
            empty($_POST["message"])
        ) {
            header("location:../pages/contact.php?error=empty");
            exit();
        }

        $email = $_POST["email"];
        $message = $_POST["message"];
        


        // on insere les informations dans la base de données
        $reqInsertContact = "INSERT INTO contact (email, message)
                             VALUES (:email, :message)";
        $stmtContact = $conn->prepare($reqInsertContact);
        $stmtContact->execute([
            ":email" => $email,
            ":message" => $message
        ]);

        
        // fermer la connexion et rediriger
        $conn = NULL;
        header("location:../pages/contact.php?success=1");

    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
