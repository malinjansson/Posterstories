<?php 
require_once("vendor/autoload.php");
require_once(dirname(__FILE__) ."/Utils/router.php");

$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ .'/pages/home.php';
});
$router->addRoute('/category', function () {
    require_once( __DIR__ .'/pages/category.php');
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

$router->dispatch();
?>