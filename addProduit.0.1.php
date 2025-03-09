<?php
include './template/header.php';
include './config/config.php';

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix']);

    // Vérifier si les champs ne sont pas vides
    if (!empty($nom) && !empty($prix)) {
        // Insérer dans la base de données
        $sql = "INSERT INTO produits (nom, prix) VALUES ('$nom', '$prix')";
        if (mysqli_query($conn, $sql)) {
            // Rediriger vers listProduit.php après l'ajout
            header("Location: listProduit.php?message=Produit ajouté avec succès");
            exit();
        } else {
            $error = "Erreur lors de l'ajout du produit : " . mysqli_error($conn);
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="container   w-75 p-5">
    <h2>Ajouter un produit</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="addProduit.php">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" class="form-control w-50" id="nom" name="nom" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix (Ar)</label>
            <input type="number" step="0.1" class="form-control w-50" id="prix" name="prix" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="./listProduit.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<?php
include './template/footer.php';
?>
