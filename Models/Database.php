<?php 
require_once('Models/UserDatabase.php');
require_once('Models/CartItem.php');
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

            $this->pdo->query('CREATE TABLE IF NOT EXISTS CartItem (
                id INT AUTO_INCREMENT PRIMARY KEY,
                productId INT,
                quantity INT,
                addedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                sessionId VARCHAR(50), 
                userId INT NULL,
                FOREIGN KEY (productId) REFERENCES Products(id) ON DELETE CASCADE
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
            $this->addProductIfNotExists("Lago Limides", "Mountain and lake in daylight - calm landscape with natural colors", 299, "assets/lago_limides.jpg", 100, "landscape", 1);
            $this->addProductIfNotExists("Nature's Serenity", "Two brown deer peacefully grazing among trees. A perfect addition to bring a calming, nature-inspired atmosphere to your home or office.", 299, "assets/deers.jpg", 105, "landscape", 5);
            $this->addProductIfNotExists("Furry Friends ", "An illustration of squirrels in a tree. Bring a touch of woodland charm to your child's room with this adorable poster!", 119, "assets/furry_friends.jpg", 90, "animals", 8);
            $this->addProductIfNotExists("Hey Kitty Cat ", "Illustration of a brown and white cat sitting calmly on the ground, with a relaxed and peaceful expression, surrounded by soft lines and neutral tones.", 119, "assets/hey_kitty_cat.jpg", 80, "animals", 15);
            $this->addProductIfNotExists("Air ballons", "Air balloons in the sky. Imagine the dreamlike view from a hot air balloon", 179, "assets/airballons.jpg", 80, "landscape", 6);
            $this->addProductIfNotExists("Owl and Oak", "Illustration of an owl perched on a tree branch surrounded by smaller birds", 199, "assets/owl_and_oak.jpg", 80, "animals", 2);
            $this->addProductIfNotExists("Fresh Lemons", "A close-up of several fresh yellow lemons", 179, "assets/lemons.jpg", 120, "Kitchen posters", 18);
            $this->addProductIfNotExists("Summer Lemons", "Fresh yellow lemons resting on a sunlit rock near the seaA summery addition to your kitchen.", 179, "assets/summer_lemons.jpg", 150, "Kitchen posters", 4);
            $this->addProductIfNotExists("Summer drinks", "A variety of glasses and pitchers filled with colorful fruit-infused drinks.", 229, "assets/summer_drinks.jpg", 170, "Kitchen posters", 10);
            $this->addProductIfNotExists("Pink Cherry Blossoms", "Pink cherry blossoms in full bloom on tree. Bring the elegance of spring into your space", 229, "assets/pink_cherry_blossoms.jpg", 120, "Flowers", 3);
            $this->addProductIfNotExists("Poppy Peach", "Oeach and pink poppies with bright yellow centers. Bring the elegance of spring into your space", 199, "assets/poppy_peach_blossom.jpg", 280, "Flowers", 9);
            $this->addProductIfNotExists("Whisper Bloom", "A soft, dreamy print of blooming white spring flowers. Perfect for adding a fresh, calming touch to any space.", 279, "assets/whisper_bloom.jpg", 170, "Flowers", 20);
            $this->addProductIfNotExists("Blush Garden", "Vibrant pink flowers in soft focus. This dreamy floral print brings a romantic, whimsical feel to any room.", 179, "assets/blush_garden.jpg", 120, "Flowers", 10);
            $this->addProductIfNotExists("Coffee Art", "A striking overhead image of a latte with heart-shaped foam art, surrounded by rich, dark coffee beans. Perfect for coffee lovers, this print adds warmth and energy to any kitchen, café, or office space.", 179, "assets/coffee_art.jpg", 100, "Kitchen posters", 11);
            $this->addProductIfNotExists("Lake village", "A charming lakeside village nestled beneath dramatic mountain cliffs. This print captures the timeless beauty of coastal Italy—perfect for adding wanderlust and warmth to any space.", 199, "assets/lake_village.jpg", 110, "Landscape", 16);
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

        function getPopularProducts(){
            $query = $this->pdo->query("SELECT * FROM Products ORDER BY popularity ASC LIMIT 10"); 
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product'); 
        }

        function getCategoryProducts($catName, $sortColumn, $sortOrder) {
            if (!in_array($sortColumn, ["title", "price"])) {
                $sortColumn = "title";
            }
            if (!in_array($sortOrder, ["asc", "desc"])) {
                $sortOrder = "asc";
            }
        
            if ($catName == "") {
                $query = $this->pdo->query("SELECT * FROM Products ORDER BY $sortColumn $sortOrder");
                return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
            }
        
            $query = $this->pdo->prepare("SELECT * FROM Products WHERE categoryName = :categoryName ORDER BY $sortColumn $sortOrder");
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

            $query = $this->pdo->prepare("SELECT * FROM Products WHERE title LIKE :q or categoryName like :q ORDER BY $sortColumn $sortOrder");
            $query->execute(['q' => "%$q%"]);
            return $query->fetchAll(PDO::FETCH_CLASS, 'Product');
        }

        function getCartItems($userId, $sessionId){
            if($userId != null ){
                $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId WHERE userId IS NULL AND  sessionId = :sessionId");
                $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);
            }

            $query = $this->pdo->prepare("SELECT CartItem.Id as id, CartItem.productId, CartItem.quantity, Products.title as productName, Products.price as productPrice, Products.price * CartItem.quantity as rowPrice     FROM CartItem JOIN Products ON Products.id=CartItem.productId  WHERE userId=:userId or sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);


            return $query->fetchAll(PDO::FETCH_CLASS, 'CartItem');
        }

        function convertSessionToUser($session_id, $userId, $newSessionId){
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId, sessionId=:newSessionId WHERE sessionId = :sessionId");
            $query->execute(['sessionId' => $session_id, 'userId' => $userId, 'newSessionId' => $newSessionId]);
        }

        function updateCartItem($userId, $sessionId,$productId, $quantity){
            if($quantity <= 0){
                $query = $this->pdo->prepare("DELETE FROM CartItem WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
                return;
            }
            $query = $this->pdo->prepare("SELECT * FROM CartItem  WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
            if($query->rowCount() == 0){
                $query = $this->pdo->prepare("INSERT INTO CartItem (productId, quantity, sessionId, userId) VALUES (:productId, :quantity, :sessionId, :userId)");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
            }
            else{
                $query = $this->pdo->prepare("UPDATE CartItem SET quantity = :quantity WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
                $query->execute([ 'userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
            }
        }
 
    };
?>