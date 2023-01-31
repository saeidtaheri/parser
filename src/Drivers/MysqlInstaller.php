<?php

namespace App\Drivers;

use mysqli;
use mysqli_sql_exception;

class MysqlInstaller
{
    /**
     * @param array $config
//     * @return void
     */
    public function setup(array $config): mysqli
    {
        $mysqli = self::getMysqli($config);
        if ($mysqli->connect_error) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        try {
            $mysqli->query("CREATE Database IF NOT EXISTS {$config['db']}");
            mysqli_select_db($mysqli, $config['db']);
            $mysqli->query('CREATE TABLE IF NOT EXISTS `users` (
                id INTEGER PRIMARY KEY,
                gender TEXT NOT NULL,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                country TEXT,
                postcode TEXT,
                birthdate DATE)'
            );
            return $mysqli;
        } catch (mysqli_sql_exception $e) {
            die($e->getMessage() . PHP_EOL);
        }

        $mysqli->close();
    }

    /**
     * @param array $config
     * @return mysqli
     */
    public static function getMysqli(array $config): mysqli
    {
        return new mysqli($config['host'], $config['username'], $config['password']);
    }
}