<?php
/**
 * @author Voary Ndrina <voarytoavina.ndrina@gmail.com>
 * @version 0.3.0
 * @date 2025-02-03
 * @since 2025-03-039
 */


include './template/header.php';
include './config/config.php';
?>
<main class="container  w-75   ">
    <div class="row border border-light pb-5">
        <div class="col">
            <h2 > <i class="fa-arrow-pointer fa-solid"></i> <span class="bg-dark text-white px-2 pb-1 rounded">Naviguer entre les tables</span></h2>
            <div class="row row-cols-2 w-75">
                
                <!-- button grand -->
                <div class="col">
                <a href="./listFour.php" class="text-decoration-none"> <!-- page des fournisseurs-->
                        <div class="card btn btn-outline-dark m-2" style="width: 12rem; border: 2px solid black;">
                            <div class="card-body">
                                <h5>Fournisseurs</h5>
                                <h5><i class="fa-solid fa-truck"></i> </h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="./listStock.php" class="text-decoration-none">
                        <div class="card btn btn-outline-dark m-2" style="width: 12rem; border: 2px solid black;">
                            <div class="card-body">
                                <h5>Stock</h5>
                                <h5><i class="fa-solid fa-box-open"></i> </h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                <a href="./listProduit.php" class="text-decoration-none">
                        <div class="card btn btn-outline-dark m-2" style="width: 12rem; border: 2px solid black;">
                            <div class="card-body">
                                <h5 class="card-title">Produits</h5>
                                <!-- <h6 class="card-subtitle mb-2 text-muted">Liste</h6> -->
                                <h5><i class="fa-solid fa-cart-shopping "></i> </h5>
                            </div>
                        </div>
                    </a>

                    
                </div>
            </div>
            
        </div>

        <div class="col">
        <h2 class="pb-2"> <i class="fa-bell fa-solid "></i>
            <span class="bg-dark px-2 rounded text-white">État des stock</span>
        </h2>
            <div class="me-5">
            <?php
            include './ruptureStock.php';
            ?>
            </div>
            
        </div>
    </div>
    <div class="mt-2 mb-3">
        <?php require './view.php' ?>
    </div>

    <!-- fin boutton grand -->


</main>
<?php 
include './template/footer.php'
?>