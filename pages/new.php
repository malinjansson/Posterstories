<?php 
require_once('Models/Product.php');
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
require_once("Models/Database.php");

    $dbConnection = new Database();

    if($_SERVER ['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $teaser = $_POST['teaser'];
        $price = $_POST['price'];
        $product->img = $_POST ['img'];
        $stockLevel = $_POST['stockLevel'];
        $categoryName = $_POST['categoryName'];
        $popularity = $_POST['popularity'];
        $dbConnection->insertProduct($title, $teaser, $price, $img, $stockLevel, $categoryName, $popularity);
        header("Location: /admin");
        exit;
    } else{

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster stories</title>
    <?php HeadLinks()?>
</head>
<body>
    <!-- Navigation-->
    <?php HeaderNav()?>
     <!-- Section-->
     <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2>Create new product</h2>
            <form method="POST">
                <div class="form-group">
                    <lable for="title">Title</lable>
                    <input type="text" class="form-control" name="title" value="">
                </div>
                <div class="form-group">
                    <lable for="title">Teaser</lable>
                    <input type="text" class="form-control" name="teaser" value="">
                </div>
                <div class="form-group">
                    <lable for="title">Price</lable>
                    <input type="text" class="form-control" name="price" value="">
                </div>
                <div class="form-group">
                    <lable for="title">Product image</lable>
                    <input type="text" class="form-control" name="img" value="">
                </div>
                <div class="form-group">
                    <lable for="title">Stock</lable>
                    <input type="text" class="form-control" name="stockLevel" value="">
                </div>
                <div class="form-group">
                    <lable for="title">Category name</lable>
                    <input type="text" class="form-control" name="categoryName" value="">
                </div>
                <input type="submit" value="Create">
            </form>
        </div>
    </section>
    <!-- Footer-->
    <?php Footer()?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>