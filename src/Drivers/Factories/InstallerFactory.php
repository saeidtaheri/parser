<?php

namespace App\Drivers\Factories;

use Exception;

class InstallerFactory
{
    public static function make(string $connection): string
    {
        return "App\Drivers\\" .
            ucfirst($connection ?? fn() => throw new Exception('connection is invalid')) . "Installer";
    }
}