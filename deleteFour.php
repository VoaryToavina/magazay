<?php
include './config/config.php';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'ID du stock est passé en paramètre
if (isset($_GET['id'])) {
    $idfour = $_GET['id'];

    // Requête SQL pour supprimer le stock
    $sql = "DELETE FROM fournisseurs WHERE idfournisseur = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idfour);

    if (mysqli_stmt_execute($stmt)) {
        // Redirection après suppression
        header("Location: listFour.php?success=Stock supprimé avec succès");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression du stock.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Aucun stock sélectionné.</div>";
}

// Fermer la connexion
mysqli_close($conn);
?>
