<?php

use App\Kernel;

const SOURCE_CLI = 'cli';
require_once __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() !== SOURCE_CLI) {
    die('only callable by Cli');
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$connection = $_ENV['CONNECTION'];
$config = include './config/database.php';

(new Kernel($config, $connection, $argv))->bootstrap();
