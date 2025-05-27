<?php

require_once ('vendor/autoload.php');

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use GuzzleHttp\Client;

$dotenv = Dotenv::createImmutable(".");
$dotenv->load();

$logger = new Logger('php-app');

$logger->pushProcessor(new IntrospectionProcessor());
$logger->pushProcessor(new WebProcessor());
$logger->pushProcessor(function ($record) {
    $record->extra['request_id'] = $_SERVER['HTTP_X_REQUEST_ID'] ?? uniqid();
    return $record;
});


$fileHandler = new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG);
$logger->pushHandler($fileHandler);


return $logger;
?>