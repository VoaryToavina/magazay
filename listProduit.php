<?php
include './template/header.php';
include './config/config.php';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}
?>

<div class="container bg-light p-2 w-75">
    <div class="row w-75">
        <div class="col-9">
            <h2><a href="./"><i class="fa-arrow-left fa-solid"></i></a> Produits <i class="fa-cart-shopping fa-solid fs-3"></i></h2>
        </div>
        <div class="col">
            <a href="addProduit.php" class="btn btn-primary">
            <i class="fa-solid fa-plus-circle"></i>
                Ajouter
            </a>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prix</th>
                <th scope="col ">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exécuter la requête pour récupérer les produits
            $sql = "SELECT * FROM `produits`";
            $result = mysqli_query($conn, $sql);

            // Vérifier si la requête est valide
            if (!$result) {
                echo "<tr><td colspan='4' class='text-center text-danger'>Erreur de requête</td></tr>";
            } else {
                // Vérifier s'il y a des produits à afficher
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($row['idproduit']); ?></th>
                            <td><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['prix']); ?> Ar</td>
                            <td>
                                <a class="btn btn-outline-danger me-2" href="deleteProduit.php?id=<?php echo $row['idproduit']; ?>"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                                    <i class="fa-trash fa-solid"></i> Supprimer
                                </a>
                                <a class="btn btn-outline-success" href="editProduit.php?id=<?php echo $row['idproduit']; ?>">
                                    <i class="fa-pen-fancy fa-solid"></i> Modifier
                                </a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Aucun produit trouvé</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include './template/footer.php';
?>