<?php 
require_once('Models/Product.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $id = $_GET['id'];

        $product = getProduct($id);
        if ($product == null){
            echo "<h1>Produkten finns inte<h1>";
        } else {
        }

        if($_SERVER ['REQUEST_METHOD'] == 'POST') {
            $product->title = $_POST['title'];
            $product->price = $_POST['price'];
            $product->stockLevel = $_POST['stockLevel'];
            $product->categoryName = $_POST['categoryName'];
            echo "<h1>The product has been updated</h1>";
        } else{

        }
    ?>
    <form method="POST">
        <lable for="title">Title</lable>
        <input type="text" name="title" value="<?php echo $product->title?>">
        <lable for="title">Price</lable>
        <input type="text" name="price" value="<?php echo $product->price?>">
        <lable for="title">Stock</lable>
        <input type="text" name="stockLevel" value="<?php echo $product->stockLevel?>">
        <lable for="title">Category name</lable>
        <input type="text" name="categoryName" value="<?php echo $product->categoryName?>">
        <input type="submit" value="Update">
    </form>
</body>
</html>