<?php
require_once('Models/Product.php');
require_once("components/Footer.php");
require_once('Models/Database.php');
require_once("Models/Cart.php");

$dbConnection = new Database();

$userId = null;
$session_id = null;

if($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()){
    $userId = $dbConnection->getUsersDatabase()->getAuth()->getUserId();
}

$session_id = session_id();

$cart = new Cart($dbConnection, $session_id, $userId);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5NXP0GE5CV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5NXP0GE5CV',{ 'debug_mode':true });
</script>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Checkout</title>
        <?php HeadLinks()?>
    </head>
<body>
    <?php 
    
    $googleItems = [];
    foreach($cart->getItems() as $cartitem){
        array_push($googleItems, [
            
            "quantity" => $cartitem->quantity,
            "price" =>$cartitem->price,
            "item_id"=>$cartitem->id,
            "item_name"=>$cartitem->productName,
        ]);
    }
    
    ?>

<script>
gtag("event", "purchase", {
    transaction_id:Math.floor(Math.random() * 99999999),
  currency: "SEK",
  value: <?php echo $cart->getTotalPrice(); ?>,
  items: [
    <?php echo json_encode($googleItems); ?>
  ]
});
</script>

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
