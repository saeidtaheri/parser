<?php

namespace App\Drivers\Factories;

use App\Contracts\DriverInstallerInterface;
use App\Drivers\MysqlInstaller;
use App\Drivers\SqliteInstaller;
use Exception;

class InstallerFactory
{
    /**
     * @param string $connection
     * @return DriverInstallerInterface
     * @throws Exception
     */
    public static function make(string $connection): DriverInstallerInterface
    {
        return match ($connection) {
            'mysql' => new MysqlInstaller(),
            'sqlite' => new SqliteInstaller(),
            default => throw new Exception('Invalid connection: ' . $connection)
        };
    }
}