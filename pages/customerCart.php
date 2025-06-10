<?php
require_once("Models/Product.php");
require_once("components/HeadLinks.php");
require_once("components/HeaderNav.php");
require_once("components/Footer.php");
require_once("Models/Database.php");
require_once("Models/Cart.php");

$dbConnection = new Database();

$userId = null;
$session_id = null;

if($dbConnection->getUsersDatabase()->getAuth()->isLoggedIn()){
    $userId = $dbConnection->getUsersDatabase()->getAuth()->getUserId();
}
$session_id = session_id();

$cart = new Cart($dbConnection, $session_id, $userId);

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
        <?php HeaderNav()?>
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <table class="table">
                <thead>
                        <th>Name
                        </th>
                        <th>Price
                        </th>
                        <th>Quantity
                        </th>
                        <th>Row price
                        </th>
                        <th>Action</th>
                </thead>
                <tbody>
                    <?php 
                    foreach($cart->getItems() as $cartItem) { ?>
                    <tr>
                        <td><?php echo $cartItem->productName; ?></td>
                        <td><?php echo $cartItem->productPrice; ?></td>
                        <td><?php echo $cartItem->quantity; ?></td>
                        <td><?php echo $cartItem->rowPrice; ?></td>
                        <td>
                            <a href="/addToCart?productId=<?php echo $cartItem->productId ?>&fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" class="btn btn-primary">+</a>                                            
                            <a href="/deleteFromCart?productId=<?php echo $cartItem->productId ?>&fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" class="btn btn-dark">-</a>                                            
                            <a href="/deleteFromCart?removeCount=<?php echo $cartItem->quantity ?>&productId=<?php echo $cartItem->productId ?>&fromPage=<?php echo urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" class="btn">DELETE ALL</a>  
                        </td>
                    </tr>
                <?php } ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo $cart->getTotalPrice(); ?></td>
                        <td>
                            <a href="/checkout" onclick="onCheckout()" class="btn btn-primary">Checkout</a>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </section>
        <?php Footer()?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>