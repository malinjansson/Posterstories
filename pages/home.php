<?php
require_once("Models/Product.php");
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/TopBanner.php");
require_once("components/ProductCards.php");
require_once("components/Footer.php");
require_once("Models/Database.php");


$dbConnection = new Database();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Poster stories | trendy posters online</title>
        <?php HeadLinks()?>
    </head>
    <body>
        <!-- Navigation-->
        <?php HeaderNav()?>
        <!-- Header-->
        <?php TopBanner()?>
        <!-- Section-->
        <section class="py-5">
            <div class="text-center">
                <h2 class="top-heading">Bestsellers</h2>
            </div>
        </section>
        <?php ProductCards()?>
        <!-- Footer-->
        <?php Footer()?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
