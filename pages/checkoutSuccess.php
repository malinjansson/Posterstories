<?php
require_once('Models/Product.php');
require_once('Models/Database.php');
require_once("Models/Cart.php");
require_once("components/Footer.php");
require_once("components/HeaderNav.php");
require_once("components/HeadLinks.php");

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
        <title>Checkout</title>
        <?php HeadLinks()?>
    </head>
<body>
<?php HeaderNav()?>
    <section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
    <h1>Thank you for your order!</h1>
    <p>Your purchase has been confirmed.</p>
</div>
</section>

<?php Footer(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
</body>
</html>
