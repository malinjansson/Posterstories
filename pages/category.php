<?php 
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <?php HeadLinks()?>
    </head>
    <body>
        <!-- Navigation-->
        <?php HeaderNav()?>
        <!-- Section-->
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
        <?php
            $name = $_GET['catname'] ?? "";
            echo"<h1>Du valde kategorin med $name</h1>"
        ?>
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