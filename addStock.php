<?php
include './template/header.php';
include './config/config.php';
echo '<link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.min.css">';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Initialisation des variables
$message = "";

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idproduit = $_POST['idproduit'];
    $nombre = $_POST['nombre'];

    if (!empty($idproduit) && !empty($nombre) && is_numeric($nombre)) {
        // Requête pour insérer un nouveau stock
        $sql = "INSERT INTO stock (idproduit, nombre) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $idproduit, $nombre);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<div class='alert alert-success'>Stock ajouté avec succès.</div>";
            header("Location: listStock.php"); // Redirection vers la liste des stocks
            exit();
        } else {
            $message = "<div class='alert alert-danger w-50'>Erreur lors de l'ajout du stock.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning w-50'>Veuillez remplir tous les champs correctement.</div>";
    }
}
?>

<div class="container bg-light w-75">
    <div class="row pt-2">
        <div class="col-9">
            <h2><a href="listStock.php"><i class="fa-arrow-left fa-solid"></i></a> Ajouter un Stock</h2>
        </div>
    </div>

    <?php echo $message; ?>

    <form action="addStock.php" method="POST">
        <div class="mb-3">
            <label for="idproduit" class="form-label">Produit</label>
            <select name="idproduit" id="idproduit" class="form-control" required>
                <option value="">Sélectionner un produit</option>
                <?php
                // Récupérer tous les produits pour les afficher dans le menu déroulant
                $produitsSql = "SELECT * FROM produits";
                $produitsResult = mysqli_query($conn, $produitsSql);
                while ($produit = mysqli_fetch_assoc($produitsResult)) {
                    echo "<option value='" . $produit['idproduit'] . "'>" . $produit['nom'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Quantité</label>
            <input type="number" name="nombre" id="nombre" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>

<?php
include './template/footer.php';
?>
