<?php
 require_once('Models/Product.php');
 require_once("components/HeadLinks.php");
 require_once("components/HeaderNav.php");
 require_once("components/Footer.php");
 require_once('Models/Database.php');
 
 $id = $_GET['id'];
 $confirmed = $_GET['confirmed'] ?? false;
 $dbConnection = new Database();
 // Hämta den produkt med detta ID
 $product = $dbConnection->getProduct($id);
 
 if($confirmed == true){
     $dbConnection->deleteProduct($id);
     header("Location: /admin");
     exit;
 }
 
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
 
     <h1><?php echo $product->title; ?></h1>
     <h2>Är du säker att du vill ta bort?</h2>
     <a href="/admin/delete?id=<?php echo $id; ?>&confirmed=true" class="btn btn-danger">Ja</a>                                 
     <a href="/admin" class="btn btn-primary">Nej</a>                                 
     </div>
    </section>
     <!-- Footer-->
    <?php Footer(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
 
 </body>
 </html>