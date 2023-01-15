<?php

namespace App\Drivers;

use SQLiteException;
use Exception;
use SQLite3;

class SqliteInstaller
{
    /**
     * @param $config
     * @return SQLite3
     * @throws Exception
     */
    public static function setup($config): SQLite3
    {
        $dbFile = $config['database'];

        try {
            $db = new SQLite3($dbFile);
            $db->exec('CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY,
                gender TEXT NOT NULL,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                country TEXT,
                postcode TEXT,
                birthdate DATE)'
            );

            return $db;
        } catch (SQLiteException $e) {
            throw new Exception($e->getMessage());
        }
    }
}