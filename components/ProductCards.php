<?php
require_once("Models/Database.php");
    function ProductCards (){
        $dbConnection = new Database();
    ?>
           <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    foreach($dbConnection->getPopularProducts() as $prod) {
                    ?>
                        <div class="col mb-5">
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
    <?php
    }
?>