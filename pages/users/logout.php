<?php
 
 require 'vendor/autoload.php';
 require_once('Models/Database.php');
 require_once('Models/UserDatabase.php');
 
 
 $dbConnection = new Database();
 
 $dbConnection->getUsersDatabase()->getAuth()->logOut();
 header('Location: /');
 ?>