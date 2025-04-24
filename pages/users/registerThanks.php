<?php
 require_once("Models/Product.php");
 require_once("components/HeadLinks.php");
 require_once("components/HeaderNav.php");
 require_once("components/Footer.php");
 require_once("Models/Database.php");
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
        <h1>Thanks!</h1>
        <p>Your account has been created!</p>
        <a href="/user/login" class="btn btn-primary">Log in</a>
    </div>
    </section>
 <?php Footer(); ?>
 <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Core theme JS-->
         <script src="js/scripts.js"></script>
 
 </body>
 </html>