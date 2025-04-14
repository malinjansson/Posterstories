<?php 
require_once('Models/UserDatabase.php');
    class Database {
        public $pdo;

        private $usersDatabase;
        function getUsersDatabase(){
            return $this->usersDatabase;
        }     
        function __construct(){
            $host = $_ENV["HOST"];
            $db = $_ENV["DB"];
            $user = $_ENV["USER"];
            $password = $_ENV["PASSWORD"];
            $port = $_ENV["PORT"];

            $dsn = "mysql:host=$host:$port;dbname=$db";
            $this->pdo = new PDO($dsn, $user, $password);
            $this->initDatabase();
            $this->initData();
            $this->usersDatabase = new UserDatabase($this->pdo);
            $this->usersDatabase->setupUsers();
            $this->usersDatabase->seedUsers();
        }
        function initDatabase(){
            $this->pdo->query('CREATE TABLE IF NOT EXISTS Products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                price INT, 
                stockLevel INT, 
                categoryName VARCHAR(50)
            )');
        }

        function insertProduct($title, $price, $stockLevel, $categoryName){
            $sql = "INSERT INTO Products (title, price, stockLevel, categoryName) VALUES (:title, :price, :stockLevel, :categoryName)";
            $query = $this->pdo->prepare($sql);;
            $query->execute([
                'title' => $title, 
                'price' => $price,
                'stockLevel' => $stockLevel,
                'categoryName' => $categoryName, 
                ]);

        }

        function addProductIfNotExists($title, $price, $stockLevel, $categoryName){
             $query = $this->pdo->prepare("SELECT * FROM Products WHERE title = :title");
             $query->execute(['title' => $title]);
             if($query->rowCount() == 0){
                 $this->insertProduct($title, $stockLevel, $price, $categoryName);
             }
         }
         function initData(){
            $this->addProductIfNotExists("Banana", 10, 100, "Fruit");
            $this->addProductIfNotExists("Apple", 5, 50, "Fruit");
            $this->addProductIfNotExists("Pear", 7, 70, "Fruit");
            $this->addProductIfNotExists("Cucumber", 15, 30, "Vegetable");
            $this->addProductIfNotExists("Tomato", 20, 40, "Vegetable");
            $this->addProductIfNotExists("Carrot", 10, 20, "Vegetable");
            $this->addProductIfNotExists("Potato", 5, 50, "Vegetable");
            $this->addProductIfNotExists("Onion", 7, 70, "Vegetable");
            $this->addProductIfNotExists("Lettuce", 15, 30, "Vegetable");
            $this->addProductIfNotExists("Broccoli", 20, 40, "Vegetable");
            $this->addProductIfNotExists("Spinach", 10, 20, "Vegetable");
            $this->addProductIfNotExists("Zucchini", 5, 50, "Vegetable");
            $this->addProductIfNotExists("Eggplant", 7, 70, "Vegetable");
            $this->addProductIfNotExists("Bell Pepper", 15, 30, "Vegetable");
        }
        function getProduct($id){
            $query= $this->pdo->prepare("SELECT * FROM Products WHERE id = :id");
            $query->execute(["id" => $id]);
            $query ->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $query->fetch();
        }
        
        function updateProduct($product){
            $p = "UPDATE Products SET title = :title, price = :price, stockLevel = :stockLevel, categoryName = :categoryName WHERE id = :id";
            $query = $this->pdo->prepare($p);
            $query->execute([
                'title' => $product->title, 
                'price' => $product->price,
                'stockLevel' => $product->stockLevel,
                'categoryName' => $product->categoryName, 
                'id' => $product->id
                ]);
        }
        function deleteProduct($id){
            $query = $this->pdo->prepare("DELETE FROM Products WHERE id = :id");
            $query->execute(['id' => $id]);
        }

        function getAllProducts ($sortColumn="id", $sortOrder="asc"){
            if(!in_array($sortColumn,["id", "title", "price", "stockLevel", "categoryName"])){
                $sortColumn = "id";
            } 
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }

            $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortColumn $sortOrder");
            return $query->fetchAll(PDO::FETCH_CLASS,'Product');
        }

        function getCategoryProducts($catName){
            if($catName == ""){
                $query = $this->pdo->query("SELECT * FROM Products");
                return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
            }
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE categoryName = :categoryName");
            $query->execute(['categoryName' => $catName]);
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }

        function getAllCategories(){
            $data = $this->pdo->query('SELECT DISTINCT categoryName FROM Products')->fetchAll(PDO::FETCH_COLUMN);
            return $data;
        }

        function searchProducts($q,$sortColumn, $sortOrder){
            if(!in_array($sortColumn,[ "title","price"])){
                $sortColumn = "title";
            }
            if(!in_array($sortOrder,["asc", "desc"])){
                $sortOrder = "asc";
            }

            $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q or categoryName like :q ORDER BY $sortColumn $sortOrder"); // Products är TABELL
            $query->execute(['q' => "%$q%"]);
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }
    };
?>