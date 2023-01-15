<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;

class mysql implements DbDriverInterface
{

    public function setup()
    {
        // TODO: Implement setup() method.
    }

    public function save(array $data)
    {
        return $data;
    }
}