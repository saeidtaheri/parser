<?php

namespace App\Drivers;

use App\Contracts\DriverInstallerInterface;
use SQLiteException;
use SQLite3;

class SqliteInstaller implements DriverInstallerInterface
{
    /**
     * @param array $config
     * @return SQLite3
     */
    public function setup(array $config): SQLite3
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
            die($e->getMessage());
        }
    }
}
