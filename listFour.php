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
            <h2><a href="./"><i class="fa-arrow-left fa-solid"></i></a> Fournisseurs <i class="fa-truck fa-solid fs-3"></i></h2>
        </div>
        <div class="col">
            <a href="addFour.php" class="btn btn-primary">
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
                <th scope="col"><i class="fa-phone fa-solid"></i> Contact</th>
                <th scope="col "><i class="fa-toilet fa-solid"></i>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exécuter la requête pour récupérer les produits
            $sql = "SELECT * FROM `fournisseurs`";
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
                            <th scope="row"><?php echo htmlspecialchars($row['idfournisseur']); ?></th>
                            <td><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact']); ?></td>
                            <td>
                                <a class="btn btn-outline-danger me-2" href="deleteFour.php?id=<?php echo $row['idfournisseur']; ?>"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce four ?');">
                                    <i class="fa-trash fa-solid"></i> Supprimer
                                </a>
                                <a class="btn btn-outline-success" href="editFour.php?id=<?php echo $row['idfournisseur']; ?>">
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