<?php
include './template/header.php';
include './config/config.php';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si l'ID du produit est passé en paramètre
if (isset($_GET['id'])) {
    $idproduit = intval($_GET['id']);

    // Récupérer les informations actuelles du produit
    $sql = "SELECT * FROM produits WHERE idproduit = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idproduit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nom = $row['nom'];
        $prix = $row['prix'];
        $idfournisseur = $row['idfournisseur'];
    } else {
        echo "<div class='alert alert-danger'>Produit non trouvé.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Aucun produit sélectionné.</div>";
    exit();
}

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nouveauId = intval($_POST['nouveauId']); // Récupérer le nouvel ID
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = floatval($_POST['prix']);
    $idfournisseur = intval($_POST['idfournisseur']);

    // Vérifier si le nouvel ID existe déjà
    if ($nouveauId !== $idproduit) {
        $checkSql = "SELECT idproduit FROM produits WHERE idproduit = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "i", $nouveauId);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<div class='alert alert-danger'>L'ID choisi est déjà utilisé par un autre produit.</div>";
        } else {
            // Mise à jour avec changement d'ID
            $updateSql = "UPDATE produits SET idproduit = ?, nom = ?, prix = ?, idfournisseur = ? WHERE idproduit = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "isdii", $nouveauId, $nom, $prix, $idfournisseur, $idproduit);
        }
    } else {
        // Mise à jour sans changer l'ID
        $updateSql = "UPDATE produits SET nom = ?, prix = ?, idfournisseur = ? WHERE idproduit = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "sdii", $nom, $prix, $idfournisseur, $idproduit);
    }

    // Exécuter la requête
    if (mysqli_stmt_execute($updateStmt)) {
        echo "<div class='alert alert-success'>Produit mis à jour avec succès.</div>";
        header("Location: listProduit.php"); // Redirection après modification
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour du produit.</div>";
    }
}
?>

<div class="container bg-light w-75 p-5">
    <h2>Modifier le produit</h2>

    <form action="editProduit.php?id=<?php echo $idproduit; ?>" method="POST">
        <div class="mb-3">
            <label for="nouveauId" class="form-label">Nouvel ID du produit</label>
            <input type="number" name="nouveauId" id="nouveauId" class="form-control w-50" value="<?php echo $idproduit; ?>" required>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" name="nom" id="nom" class="form-control w-50" value="<?php echo htmlspecialchars($nom); ?>" required>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (Ar)</label>
            <input type="number" name="prix" id="prix" step="0.1" class="form-control w-50" value="<?php echo htmlspecialchars($prix); ?>" required>
        </div>

        <div class="mb-3">
            <label for="idfournisseur" class="form-label">Fournisseur</label>
            <select name="idfournisseur" id="idfournisseur" class="form-control" required>
                <option value="">Sélectionner un fournisseur</option>
                <?php
                // Récupérer tous les fournisseurs pour remplir la liste déroulante
                $fournSql = "SELECT * FROM fournisseurs";
                $fournResult = mysqli_query($conn, $fournSql);
                while ($four = mysqli_fetch_assoc($fournResult)) {
                    $selected = ($four['idfournisseur'] == $idfournisseur) ? "selected" : "";
                    echo "<option value='" . $four['idfournisseur'] . "' $selected>" . $four['nom'] . "</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="./listProduit.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<?php
include './template/footer.php';
?>
