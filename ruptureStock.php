<?php 
include './config/config.php';

// Requête SQL pour récupérer les produits en rupture de stock
$query = "SELECT produits.nom FROM stock 
          JOIN produits ON stock.idproduit = produits.idproduit
          WHERE stock.nombre = 0";

$result = mysqli_query($conn, $query);

// Vérifier s'il y a des résultats
if (mysqli_num_rows($result) > 0): ?>
    <div class="message">
        <h4>! Rupture</h4>
    <div class="alert alert-danger">
        <h6><i class="fa-solid fa-triangle-exclamation"></i> Produits en rupture de stock</h6>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li><strong><?= htmlspecialchars($row['nom']) ?></strong> - Indisponible</li>
            <?php endwhile; ?>
        </ul>
    </div>
    </div>
<?php else: ?>
    <div class="alert alert-success">
        <h6><i class="fa-solid fa-check-circle"></i> Aucun produit en rupture de stock</h6>
    </div>
<?php endif; ?>


 <?php 
 $sql = "SELECT produits.nom , stock.nombre FROM stock 
          JOIN produits ON stock.idproduit = produits.idproduit
          WHERE stock.nombre <10 AND stock.nombre > 0";
 $result1 = mysqli_query($conn, $sql);
 if (mysqli_num_rows($result1) > 0): ?>
 <div class="message">
 <h4><i class="fa-solid fa-magnifying-glass"></i> A Verifier</h4>
 <div class="alert alert-warning">
     <h6><i class="fa-solid fa-triangle-exclamation"></i> Produits presque fini</h6>
     <ul>
         <?php while ($row = mysqli_fetch_assoc($result1)): ?>
             <li><strong><?= htmlspecialchars($row['nom']) ?></strong> - Quantité : <strong><?= htmlspecialchars($row['nombre'])?></strong></li>
         <?php endwhile; ?>
     </ul>
 </div>
 </div>
<?php else: ?>
 <div class="alert alert-success">
     <h6><i class="fa-solid fa-check-circle"></i> Aucun produit en danger</h6>
 </div>
<?php endif;
?>

<?php
// Libérer la mémoire et fermer la connexion
mysqli_free_result($result);
mysqli_close($conn);
?>
