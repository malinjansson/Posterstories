<?php 
require_once("Models/Product.php");
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/CategoryProductCards.php");
require_once("components/Footer.php");
require_once("Models/Database.php");

$id = $_GET['id'];
$dbConnection = new Database();
$product = $dbConnection->getProduct($id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Poster stories</title>
        <?php HeadLinks()?>
    </head>
    <body>
        <!-- Navigation-->
        <?php HeaderNav()?>
        <!-- Section-->
        <section class="py-1">
            <div class="container my-5">
                <div class="row">
                    <!-- Produktbild -->
                    <div class="col-md-6">
                    <img src="<?php echo $product->img?>" class="img-fluid rounded" alt="Produktbild">
                    </div>

                    <!-- Produktinfo -->
                    <div class="col-md-6 mt-4">
                    <h2 class="top-heading"><?php echo $product->title?></h2>
                    <h3 class="text-black"><?php echo $product->price?> kr</h3>

                    <div class="d-grid gap-2 my-4">
                        <button class="btn btn-primary btn-lg" type="button">Add to cart</button>
                    </div>

                    <div class="row g-2 pb-3">
                    <div class="col-12 col-md-6">
                        <?php if ($product->stockLevel >= 1) { ?>
                                <i class="bi bi-check-circle" style="font-size: 1rem; color: green;"></i> In Stock
                        <?php } else { ?>
                                <i class="bi bi-x-circle" style="font-size: 1rem; color: red;"></i> Out of Stock
                        <?php } ?>
                    </div>
                        <div class="col-12 col-md-6">
                            <i class="bi bi-check-circle" style="font-size: 1rem; color: black;"></i> Delivery 2-4 working days
                        </div>
                        <div class="col-12 col-md-6">
                            <i class="bi bi-check-circle" style="font-size: 1rem; color: black;"></i> Free shipping over 399 SEK
                        </div>
                        <div class="col-12 col-md-6">
                            <i class="bi bi-check-circle" style="font-size: 1rem; color: black;"></i> Open purchase for 30 days
                        </div>
                    </div>
                    <p class="mt-4 fs-5 fw-bold">Description</p>
                    <p class="mt-1"><?php echo $product->teaser?></p>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <?php Footer()?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>