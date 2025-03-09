<?php
include './template/header.php';
include './config/config.php';
echo '   <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.min.css">
';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'ID du stock est passé en paramètre
if (isset($_GET['id'])) {
    $idstock = $_GET['id'];

    // Récupérer les informations actuelles du stock
    $sql = "SELECT * FROM stock JOIN produits ON stock.idproduit = produits.idproduit WHERE idstock = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idstock);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nombre = $row['nombre'];
        $idproduit = $row['idproduit'];
    } else {
        echo "<div class='alert alert-danger'>Stock non trouvé.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Aucun stock sélectionné.</div>";
    exit();
}

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $idproduit = $_POST['idproduit'];

    // Mettre à jour les données du stock
    $updateSql = "UPDATE stock SET nombre = ?, idproduit = ? WHERE idstock = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "iii", $nombre, $idproduit, $idstock);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<div class='alert alert-success'>Stock mis à jour avec succès.</div>";
        header("Location: listStock.php?id=" . $idstock); // Rediriger pour éviter la resoumission
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du stock.</div>";
    }
}

?>

<div class="container bg-light w-75">
    <div class="row pt-2 w-75">
        <div class="col-9">
            <h2><a href="./"><i class="fa-arrow-left fa-solid"></i></a> Modifier le stock</h2>
        </div>
    </div>

    <form action="editStock.php?id=<?php echo $idstock; ?>" method="POST">
        <div class="mb-3">
            <label for="idproduit" class="form-label">Produit</label>
            <select name="idproduit" id="idproduit" class="form-control" required>
                <option value="">Sélectionner un produit</option>
                <?php
                // Récupérer tous les produits pour remplir la liste déroulante
                $produitsSql = "SELECT * FROM produits";
                $produitsResult = mysqli_query($conn, $produitsSql);
                while ($produit = mysqli_fetch_assoc($produitsResult)) {
                    $selected = ($produit['idproduit'] == $idproduit) ? "selected" : "";
                    echo "<option value='" . $produit['idproduit'] . "' $selected>" . $produit['nom'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Quantité</label>
            <input type="number" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>

<?php
include './template/footer.php';
?>
