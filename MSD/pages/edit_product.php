<?php
session_start();
require_once '../traitements/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: accueil.php?error=unauthorized');
    exit;
}

$error_message = '';
$success_message = '';
$product = null;
$categories = [];
$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$product_id) {
    header('Location: admin.php?error=invalid_product_id#stock');
    exit;
}

try {
    $stmt_product = $conn->prepare("SELECT * FROM produits WHERE id = :id");
    $stmt_product->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt_product->execute();
    $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header('Location: admin.php?error=product_not_found#stock');
        exit;
    }

    $stmt_categories = $conn->query("SELECT id, nom FROM categories_produits ORDER BY nom");
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $error_message = "Erreur lors de la récupération des données. Impossible d'afficher le formulaire.";
    $product = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
    $categorie_id = filter_input(INPUT_POST, 'categorie_id', FILTER_VALIDATE_INT);
    $a_des_tailles = isset($_POST['a_des_tailles']) ? 1 : 0;

    if (empty($nom) || $prix === false || $prix < 0 || !$categorie_id) {
        $error_message = "Veuillez remplir tous les champs obligatoires (Nom, Prix >= 0, Catégorie).";
    } else {
        $upload_dir = '../media/products/';
        $image_filename = $product['image'];
        $image_hover_filename = $product['image_hover'];
        $upload_ok = true;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_file = $upload_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
                $new_filename = uniqid('prod_') . '_' . time() . '.' . $imageFileType;
                $target_path = $upload_dir . $new_filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                    if ($image_filename && file_exists($upload_dir . $image_filename) && $upload_dir . $image_filename != $target_path) {
                    }
                    $image_filename = $new_filename;
                } else {
                    $error_message .= " Erreur lors du déplacement du fichier image.";
                    $upload_ok = false;
                }
            } else {
                $error_message .= " Fichier image invalide ou type non autorisé (jpg, png, jpeg, gif, webp).";
                $upload_ok = false;
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error_message .= " Erreur lors du téléversement de l'image principale (code: ".$_FILES['image']['error'].").";
            $upload_ok = false;
        }

        if ($upload_ok && isset($_FILES['image_hover']) && $_FILES['image_hover']['error'] === UPLOAD_ERR_OK) {
            $target_file_hover = $upload_dir . basename($_FILES["image_hover"]["name"]);
            $imageFileType_hover = strtolower(pathinfo($target_file_hover, PATHINFO_EXTENSION));
            $check_hover = getimagesize($_FILES["image_hover"]["tmp_name"]);
            if ($check_hover !== false && in_array($imageFileType_hover, ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
                $new_filename_hover = uniqid('prodhover_') . '_' . time() . '.' . $imageFileType_hover;
                $target_path_hover = $upload_dir . $new_filename_hover;
                if (move_uploaded_file($_FILES["image_hover"]["tmp_name"], $target_path_hover)) {
                    if ($image_hover_filename && file_exists($upload_dir . $image_hover_filename) && $upload_dir . $image_hover_filename != $target_path_hover) {
                    }
                    $image_hover_filename = $new_filename_hover;
                } else {
                    $error_message .= " Erreur lors du déplacement du fichier image hover.";
                    $upload_ok = false;
                }
            } else {
                $error_message .= " Fichier image hover invalide ou type non autorisé (jpg, png, jpeg, gif, webp).";
                $upload_ok = false;
            }
        } elseif (isset($_FILES['image_hover']) && $_FILES['image_hover']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error_message .= " Erreur lors du téléversement de l'image hover (code: ".$_FILES['image_hover']['error'].").";
            $upload_ok = false;
        }

        if ($upload_ok && empty($error_message)) {
            try {
                $sql = "UPDATE produits SET
                            nom = :nom,
                            description = :description,
                            prix = :prix,
                            image = :image,
                            image_hover = :image_hover,
                            categorie_id = :categorie_id,
                            a_des_tailles = :a_des_tailles
                        WHERE id = :id";

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
                $stmt->bindParam(':image', $image_filename, PDO::PARAM_STR);
                $stmt->bindParam(':image_hover', $image_hover_filename, PDO::PARAM_STR);
                $stmt->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT);
                $stmt->bindParam(':a_des_tailles', $a_des_tailles, PDO::PARAM_INT);
                $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $success_message = "Produit mis à jour avec succès !";
                    $stmt_product->execute();
                    $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
                } else {
                    $error_message = "Erreur lors de la mise à jour du produit.";
                }
            } catch (\PDOException $e) {
                error_log("Erreur: " . $e->getMessage());
                $error_message = "Erreur base de données lors de la mise à jour du produit.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/admin.css">
    <title>Modifier Produit - Admin</title>
</head>
<body>
    <div class="form-container">
        <h1>Modifier le Produit</h1>
        <a href="admin.php#stock" class="link-back">« Retour au Panneau Admin</a>

        <?php if ($error_message): ?>
            <p class="message error"><?php echo htmlspecialchars(trim($error_message)); ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if ($product): ?>
            <form action="edit_product.php?id=<?php echo htmlspecialchars($product_id); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom du Produit : *</label>
                    <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($product['nom'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea name="description" id="description"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (€) : *</label>
                    <input type="number" name="prix" id="prix" value="<?php echo htmlspecialchars($product['prix'] ?? ''); ?>" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="categorie_id">Catégorie : *</label>
                    <select name="categorie_id" id="categorie_id" required>
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                <?php echo (isset($product['categorie_id']) && $product['categorie_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Image Principale :</label>
                    <?php if (!empty($product['image']) && file_exists('../media/products/' . $product['image'])): ?>
                         <p>Actuelle : <img src="../media/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Image actuelle" class="current-image"></p>
                    <?php elseif (!empty($product['image'])): ?>
                         <p>Actuelle : Fichier non trouvé (<?php echo htmlspecialchars($product['image']); ?>)</p>
                    <?php else: ?>
                         <p>Actuelle : Aucune image</p>
                    <?php endif; ?>
                    <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif, image/webp">
                    <small>Laissez vide pour conserver l'image actuelle.</small>
                </div>

                 <div class="form-group">
                    <label for="image_hover">Image Hover :</label>
                     <?php if (!empty($product['image_hover']) && file_exists('../media/products/' . $product['image_hover'])): ?>
                         <p>Actuelle : <img src="../media/products/<?php echo htmlspecialchars($product['image_hover']); ?>" alt="Image hover actuelle" class="current-image"></p>
                    <?php elseif (!empty($product['image_hover'])): ?>
                         <p>Actuelle : Fichier non trouvé (<?php echo htmlspecialchars($product['image_hover']); ?>)</p>
                    <?php else: ?>
                         <p>Actuelle : Aucune image hover</p>
                    <?php endif; ?>
                    <input type="file" name="image_hover" id="image_hover" accept="image/png, image/jpeg, image/gif, image/webp">
                     <small>Laissez vide pour conserver l'image hover actuelle.</small>
                </div>

                 <div class="form-group">
                    <label for="a_des_tailles">
                        <input type="checkbox" name="a_des_tailles" id="a_des_tailles" value="1"
                            <?php echo (isset($product['a_des_tailles']) && $product['a_des_tailles'] == 1) ? 'checked' : ''; ?>>
                        Ce produit utilise des tailles (affecte l'affichage boutique) ?
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit">Mettre à jour le Produit</button>
                </div>
            </form>
        <?php elseif (empty($error_message)): ?>
            <p class="message error">Le produit demandé n'a pas été trouvé.</p>
        <?php endif; ?>
         <a href="admin.php#stock" class="link-back" style="display: block; text-align: center; margin-top: 20px;">« Retour au Panneau Admin</a>
    </div>
</body>
</html>
