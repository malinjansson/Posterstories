<?php
require_once("vendor/autoload.php");

require_once("Models/Product.php");
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


\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET']);

$lineitems = [];
foreach($cart->getItems() as $cartitem ){
    array_push($lineitems, [
        "quantity" => $cartitem->quantity,
        "price_data" => [
            "currency" => "sek",
            "unit_amount" => $cartitem->productPrice*100,
            "product_data" => [
                "name" => $cartitem->productName
            ]
        ]

    ]);
}

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/checkoutsuccess",
    "cancel_url" => "http://localhost:8000",
    "locale" => "auto",
    "line_items" => $lineitems
]);

http_response_code(303);
header("Location: " . $checkout_session->url);