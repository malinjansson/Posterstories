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
        <!-- Navigation-->
        <?php HeaderNav()?>
        <!-- Section-->
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
                            <a href="deleteFromCart?id=<?php echo $cartItem->id; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo $cart->getTotalPrice(); ?></td>
                    </tr>
                </tbody>
            </table>
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