<?php
 require_once("Models/Product.php");
 require_once("components/HeadLinks.php");
 require_once("components/HeaderNav.php");
 require_once("components/Footer.php");
 require_once("Models/Database.php");
 
 $dbConnection = new Database();
 
 $errorMessage = "";
 $username = "";
 if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     $username = $_POST['username'];
     $password = $_POST['password'];
 
     try{  
        $cart = new Cart($dbConnection, session_id(), null);
        $cart->convertSessionToUser($dbConnection->getUsersDatabase()->getAuth()->getUserId(), session_id());
        $dbConnection->getUsersDatabase()->getAuth()->login($username, $password);
        
        header('Location: /');
        exit;
     }
     catch(Exception $e){
         $errorMessage = "Couldn't log in";
         die($e->getMessage());
     }
 }else{
    
 }
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
     <div class="container px-4 px-lg-5 mt-2 mb-5">
     <h1>Log in</h1>
     <?php
     if($errorMessage != ""){
         echo "<div class='alert alert-danger' role='alert'>".$errorMessage."</div>";
     }
     ?>
     <p class="mt-1 mb-5">Log in with you email and password</p>
     <form method="POST" > 
             <div class="form-group">
                 <label for="username">Email</label>
                 <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
             </div>
             <div class="form-group">
                 <label for="password" class="mt-3">Password</label>
                 <input type="password" class="form-control" name="password" value="">
             </div>
             <div class="mt-5">
                <input type="submit" class="btn btn-primary" value="Login">
                <a href="/user/register" class="btn btn-primary">Register</a>
                <a href="/forgot" class="btn btn-primary">Forgot password</a>
             </div>
         </form>
 </div>
 </section>
 <?php Footer(); ?>
 <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Core theme JS-->
         <script src="js/scripts.js"></script>
 
 </body>
 </html>