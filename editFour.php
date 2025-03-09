<?php
include './template/header.php';
include './config/config.php';

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'ID du fournisseur est passé en paramètre
if (isset($_GET['id'])) {
    $idfour = $_GET['id'];

    // Récupérer les informations actuelles du fournisseur
    $sql = "SELECT * FROM fournisseurs WHERE idfournisseur = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idfour);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nom = $row['nom'];
        $contact = $row['contact'];
    } else {
        echo "<div class='alert alert-danger'>Fournisseur non trouvé.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Aucun fournisseur sélectionné.</div>";
    exit();
}

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $new_contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Mise à jour des informations du fournisseur
    $updateSql = "UPDATE fournisseurs SET nom = ?, contact = ? WHERE idfournisseur = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "ssi", $new_nom, $new_contact, $idfour);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<div class='alert alert-success'>Fournisseur mis à jour avec succès.</div>";
        header("Location: listFour.php?success=Fournisseur mis à jour"); // Redirection après succès
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du fournisseur.</div>";
    }
}

?>

<div class="container w-75 p-5">
    <h2>Modifier un fournisseur</h2>

    <form action="editFour.php?id=<?php echo $idfour; ?>" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du fournisseur</label>
            <input type="text" class="form-control w-50" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact (+261)</label>
            <input type="number" class="form-control w-50" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="./listFour.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<?php
include './template/footer.php';
?>
