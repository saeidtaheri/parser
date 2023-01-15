<?php

namespace App\Contracts;

interface DbDriverInterface
{
    public function save(array $data);
}