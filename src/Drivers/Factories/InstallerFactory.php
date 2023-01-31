<?php

namespace App\Drivers\Factories;

use Exception;

class InstallerFactory
{
    /**
     * @param string $connection
     * @return string
     */
    public static function make(string $connection): string
    {
        return "App\Drivers\\" .
            ucfirst($connection ?? fn() => throw new Exception('connection is invalid')) . "Installer";
    }
}