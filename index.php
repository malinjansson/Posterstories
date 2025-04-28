<?php 
require_once("vendor/autoload.php");
require_once(dirname(__FILE__) ."/Utils/router.php");

ob_start();
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ .'/pages/home.php';
});
$router->addRoute('/category', function () {
    require_once( __DIR__ .'/pages/category.php');
});
$router->addRoute('/product', function () {
    require_once( __DIR__ .'/pages/productDetailPage.php');
});
$router->addRoute('/admin', function () {
    require __DIR__ .'/pages/admin.php';
});
$router->addRoute('/admin/edit', function () {
    require __DIR__ .'/pages/edit.php';
});
$router->addRoute('/admin/new', function () {
    require __DIR__ .'/pages/new.php';
});
$router->addRoute('/admin/delete', function () {
    require_once( __DIR__ .'/pages/delete.php');
});
$router->addRoute('/user/login', function () {
    require_once( __DIR__ .'/pages/users/login.php');
});
$router->addRoute('/user/logout', function () {
    require_once( __DIR__ .'/pages/users/logout.php');
});
$router->addRoute('/user/register', function () {
    require_once( __DIR__ .'/pages/users/register.php');
});
$router->addRoute('/user/registerthanks', function () {
    require_once( __DIR__ .'/pages/users/registerThanks.php');
});
$router->addRoute('/search', function () {
    require_once( __DIR__ .'/pages/search.php');
});
$router->addRoute('/addToCart', function () {
    require_once( __DIR__ .'/pages/addToCart.php');
});
$router->dispatch();
?>