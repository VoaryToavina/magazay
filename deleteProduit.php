<?php
include './template/header.php';
include './config/config.php';

// Vérifier si un ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en le convertissant en entier

    // Vérifier que l'ID existe dans la base
    $sql_check = "SELECT * FROM produits WHERE idproduit = $id";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Supprimer le produit
        $sql_delete = "DELETE FROM produits WHERE idproduit = $id";
        if (mysqli_query($conn, $sql_delete)) {
            header("Location: listProduit.php?message=Produit supprimé avec succès");
            exit();
        } else {
            echo "Erreur lors de la suppression : " . mysqli_error($conn);
        }
    } else {
        echo "Produit introuvable.";
    }
} else {
    echo "ID non valide.";
}
?>
