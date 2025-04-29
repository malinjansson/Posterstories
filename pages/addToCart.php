<?php
 
 require_once("Models/Database.php");
 require_once("Models/Cart.php");
 
 $dbConnection = new Database();
 
 $productId = $_GET['productId'] ?? "";
 $fromPage = $_GET['fromPage'] ?? "";
 
 $userId = null;
 $sessionId = null;
 
 if($dbConnection->getUsersDatabase()->getAuth()->isLoggedIn()){
     $userId = $dbContext->getUsersDatabase()->getAuth()->getUserId();
 }
   
 $session_id = session_id();
 
 $cart = new Cart($dbConnection, $session_id, $userId);
 $cart->addItem($productId, 1);
 
 header("Location: $fromPage");
 ?>