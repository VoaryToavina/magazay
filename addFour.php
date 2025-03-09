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
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Vérifier si les champs ne sont pas vides
    if (!empty($nom) && !empty($contact)) {
        // Insérer dans la base de données
        $sql = "INSERT INTO fournisseurs (nom, contact) VALUES ('$nom', '$contact')";
        if (mysqli_query($conn, $sql)) {
            // Rediriger vers listFour.php après l'ajout
            header("Location: listFour.php?message=Fournisseur ajouté avec succès");
            exit();
        } else {
            $error = "Erreur lors de l'ajout du fournisseur : " . mysqli_error($conn);
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="container   w-75 p-5">
    <h2>Ajouter un fournisseur</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="addFour.php">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du fournisseur</label>
            <input type="text" class="form-control w-50" id="nom" name="nom" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact (+261)</label>
            <input type="number" step="" class="form-control w-50" id="contact" name="contact" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="./listFour.php" class="btn btn-secondary">Retour</a>
    </form>
</div>

<?php
include './template/footer.php';
?>
