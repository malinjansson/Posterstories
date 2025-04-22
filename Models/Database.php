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
                teaser VARCHAR (300),
                price INT, 
                img VARCHAR (100),
                stockLevel INT, 
                categoryName VARCHAR(50),
                popularity INT DEFAULT 0
            )');
        }
       
        function insertProduct($title, $teaser, $price, $img, $stockLevel, $categoryName, $popularity){
            $sql = "INSERT INTO Products (title, teaser, price, img, stockLevel, categoryName, popularity) VALUES (:title, :teaser, :price, :img, :stockLevel, :categoryName, :popularity)";
            $query = $this->pdo->prepare($sql);;
            $query->execute([
                'title' => $title, 
                'teaser' => $teaser,
                'price' => $price,
                'img' => $img,
                'stockLevel' => $stockLevel,
                'categoryName' => $categoryName, 
                'popularity' => $popularity
                ]);

        }

        function addProductIfNotExists($title, $teaser, $price, $img, $stockLevel, $categoryName, $popularity){
             $query = $this->pdo->prepare("SELECT * FROM Products WHERE title = :title");
             $query->execute(['title' => $title]);
             if($query->rowCount() == 0){
                 $this->insertProduct($title, $teaser, $price, $img, $stockLevel, $categoryName, $popularity);
             }
         }
         function initData(){
            $this->addProductIfNotExists("Lago Limides", "Mountain and lake in daylight - calm landscape with natural colors", 299, "assets/lago_limides.jpg", 100, "landscape", 10);
            $this->addProductIfNotExists("Nature's Serenity", "Two brown deer peacefully grazing among trees. A perfect addition to bring a calming, nature-inspired atmosphere to your home or office.", 299, "assets/deers.jpg", 105, "landscape", 30);
            $this->addProductIfNotExists("Furry Friends ", "An illustration of squirrels in a tree. Bring a touch of woodland charm to your child's room with this adorable poster!", 119, "assets/furry_friends.jpg", 90, "animals", 42);
        }
        function getProduct($id){
            $query= $this->pdo->prepare("SELECT * FROM Products WHERE id = :id");
            $query->execute(["id" => $id]);
            $query ->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $query->fetch();
        }
        
        function updateProduct($product){
            $p = "UPDATE Products SET title = :title, teaser = :teaser, price = :price, img = :img, stockLevel = :stockLevel, categoryName = :categoryName, popularity = :popularity WHERE id = :id";
            $query = $this->pdo->prepare($p);
            $query->execute([
                'title' => $product->title, 
                'teaser' => $product->teaser,
                'price' => $product->price,
                'img' => $product->img,
                'stockLevel' => $product->stockLevel,
                'categoryName' => $product->categoryName, 
                'popularity' => $product->popularity,
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