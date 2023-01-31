<?php

namespace App\Contracts;

interface DriverInstallerInterface
{
    public function setup(array $config);
}