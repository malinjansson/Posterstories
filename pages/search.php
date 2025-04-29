<?php 
require_once("Models/Product.php");
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
require_once("Models/Database.php");

$dbConnection = new Database();

$q = $_GET['q'] ?? "";
$sortColumn = $_GET['sortColumn'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
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
        <section class="py-5">
             <div class="container px-4 px-lg-5 mt-5">
                    <a href="?sortColumn=title&sortOrder=asc&q=<?php echo $q;?>" class="btn btn-secondary">Title asc</>
                    <a href="?sortColumn=title&sortOrder=desc&q=<?php echo $q;?>" class="btn btn-secondary">Title desc</a>
                    <a href="?sortColumn=price&sortOrder=asc&q=<?php echo $q;?>" class="btn btn-secondary">Price asc</a>
                    <a href="?sortColumn=price&sortOrder=desc&q=<?php echo $q;?>" class="btn btn-secondary">Price desc</a>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                 <?php 
                 foreach($dbConnection->searchProducts($q,$sortColumn, $sortOrder) as $prod){
                 ?>                     
                   <div class="col mb-5 mt-5">
                            <div class="card h-100">
                                <?php if($prod->price < 10) { ?>
                                    <!-- Sale badge-->
                                     <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <?php } ?>
                                <!-- Product image-->
                                <img class="card-img-top" src="<?php echo $prod->img; ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $prod->title;?></h5>
                                    </div>
                                    <div class="text-center">
                                        <!-- Product price-->
                                        <?php echo $prod->price?> kr
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                     <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/product?id=<?php echo $prod->id; ?>">Shop now</a></div>
                                </div>
                            </div>
                        </div>   
                     <?php } ?>  
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