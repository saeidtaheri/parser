<?php

namespace App\Drivers;

use App\Contracts\DriverInstallerInterface;

use Exception;
use SQLite3;

class SqliteInstaller implements DriverInstallerInterface
{
    /**
     * @param array $config
     * @return SQLite3
     * @throws Exception
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
        } catch (Exception $e) {
            throw new Exception('Failed to initialize database: ' . $e->getMessage());
        }
    }
}
