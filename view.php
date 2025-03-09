<?php
include './config/config.php';

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Requête SQL 
$sql =
    " SELECT 
    produits.idproduit,
    produits.nom AS produit_nom, 
    produits.prix, 
    stock.nombre, 
    fournisseurs.nom AS fournisseur_nom
FROM stock
JOIN produits ON stock.idproduit = produits.idproduit
JOIN fournisseurs ON fournisseurs.idfournisseur = produits.idfournisseur
";
$result = mysqli_query($conn, $sql);

// Vérifier si la requête a réussi
if (!$result) {
    die("Erreur SQL : " . mysqli_error($conn));
}
?>

<h2><i class="fa-list-ul fa-solid"></i> Liste des <span class="bg-warning rounded px-2">Produits</span> <i class="fa-handshake-simple fs-4 fa-solid"></i> <span class="bg-info rounded px-2">Stock</span></h2>
<table class="table table-hover w-75 mx-2 rounded-top">
    <thead class=" table-dark">
        <tr class="fs-5 align-middle text-center">
            <th>ID</th>
            <th><a href="./listProduit.php" title="Produits"><i class="fa-shopping-cart fa-solid text-warning"></i></a></th>
            <th><a href="./listStock.php" title="Stock"><i class="fa-box-open fa-solid text-info"></i></a></th>
            <th class="">Prix unitaire</th>
            <th class="col"><i class="fa-truck-fast fa-solid"></i></th>
            <th class="table-active  ">Valeur</th>

            <!-- <th>Fournisseur</th> -->
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>

            <?php
            $nombre = $row['nombre'];
            $prix = $row['prix'];
            $valeur = $nombre * $prix;
            ?>

            <tr class="table-dark text-center">


                <td><?= htmlspecialchars($row['idproduit']) ?></td>
                <td><?= htmlspecialchars($row['produit_nom']) ?></td>
                <td><?= $nombre ?></td>
                <td><?= htmlspecialchars($prix) ?> Ar</td>
                <td><?= htmlspecialchars($row['fournisseur_nom']) ?></td>
                <td class="table-active"><i><?= $valeur ?> Ar</i></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>