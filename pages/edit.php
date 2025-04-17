<?php 
require_once('Models/Product.php');
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
require_once("Models/Database.php");

    $id = $_GET['id'];
    $dbConnection = new Database();
    $product = $dbConnection->getProduct($id);

    if($_SERVER ['REQUEST_METHOD'] == 'POST') {
        $product->title = $_POST['title'];
        $product->teaser = $_POST['teaser'];
        $product->price = $_POST['price'];
        $product->img = $_POST ['img'];
        $product->stockLevel = $_POST['stockLevel'];
        $product->categoryName = $_POST['categoryName'];
        $product->popularity = $_POST['popularity'];
        $dbConnection->updateProduct($product);
        echo "<h1>The product has been updated</h1>";
    } else{

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php HeadLinks()?>
</head>
<body>
    <!-- Navigation-->
    <?php HeaderNav()?>
     <!-- Section-->
     <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <form method="POST">
                <div class="form-group">
                    <lable for="title">Title</lable>
                    <input type="text" class="form-control" name="title" value="<?php echo $product->title?>">
                </div>
                <div class="form-group">
                    <lable for="title">Price</lable>
                    <input type="text" class="form-control" name="price" value="<?php echo $product->price?>">
                </div>
                <div class="form-group">
                    <lable for="title">Stock</lable>
                    <input type="text" class="form-control" name="stockLevel" value="<?php echo $product->stockLevel?>">
                </div>
                <div class="form-group">
                    <lable for="title">Category name</lable>
                    <input type="text" class="form-control" name="categoryName" value="<?php echo $product->categoryName?>">
                </div>
                <input type="submit" value="Update">
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