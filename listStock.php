<?php
include './template/header.php';
include './config/config.php';
echo '   <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.min.css">
';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}
?>

<div class="container p-2 bg-light w-75">
    <div class="row w-75">
        <div class="col-9">
            <h2><a href="./"><i class="fa-arrow-left fa-solid"></i></a> Stock <i class="fa-solid fa-box-open"></i></h2>
        </div>
        <div class="col">
            <a href="addStock.php" class="btn btn-primary">
                <i class="fa-plus-circle fa-solid"></i>
                Ajouter
            </a>
        </div>
    </div>

    <table class="table ">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Produits</th>
                <th scope="col">id produit</th>

                <th scope="col" class=" text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exécuter la requête pour récupérer les produits
            $sql = "SELECT * 
                    FROM stock
                    JOIN produits ON stock.idproduit = produits.idproduit;
                    ";
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
                            <th scope="row"><?php echo htmlspecialchars($row['idstock']); ?></th>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['nom']); ?></td>
                            <td><?php echo htmlspecialchars($row['idproduit']); ?></td>
                            <td class="text-center">
                                <a class="btn btn-outline-danger me-2" href="deleteStock.php?id=<?php echo $row['idstock']; ?>"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                                    <i class="fa-trash fa-solid"></i> Supprimer
                                </a>
                                <a class="btn btn-outline-success" href="editStock.php?id=<?php echo $row['idstock']; ?>">
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