<?php
require_once("Models/Database.php");


    function CategoryProductCards ($catName){
        $dbConnection = new Database();

        $header = $catName;
            if($catName == ""){
             $header = "All Products";
            }  

            $catName = $_GET['catname'] ?? "";
            $sortColumn = $_GET['sortColumn'] ?? "";
            $sortOrder = $_GET['sortOrder'] ?? "";
    ?>
           <section class="py-5">
           <div class="text-center">
                <h2 class="top-heading"><?php echo $header ;?></h2>
            </div>
            <div class="container px-4 px-lg-5 mt-5">
            <a href="?sortColumn=title&sortOrder=asc&catname=<?php echo $catName;?>" class="btn btn-primary">A-Z</a>
                    <a href="?sortColumn=title&sortOrder=desc&catname=<?php echo $catName;?>" class="btn btn-primary">Z-A</a>
                    <a href="?sortColumn=price&sortOrder=asc&catname=<?php echo $catName;?>" class="btn btn-primary">Lowest Price</a>
                    <a href="?sortColumn=price&sortOrder=desc&catname=<?php echo $catName;?>" class="btn btn-primary">Highest Price</a>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 mt-5 justify-content-center">
                    <?php
                    foreach($dbConnection->getCategoryProducts($catName, $sortColumn, $sortOrder) as $prod) {
                    ?>
                        <div class="col mb-5">
                            <div class="card h-100"> 
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
    <?php
    }
?>