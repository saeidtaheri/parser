<?php

use App\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() !== 'cli') {
    die('This App is only run in Cli!');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$connection = $_ENV['CONNECTION'];
$config = include './config/database.php';

(new Kernel($config, $connection))->bootstrap();
