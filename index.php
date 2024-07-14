<?php

use App\Kernel;
use DI\Container;

require_once __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() !== 'cli') {
    die('This App is only run in Cli!');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connection = $_ENV['CONNECTION'];
$container = new Container();

(new Kernel($connection, $container))->bootstrap();
