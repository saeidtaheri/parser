<?php

namespace App\Services;

use App\Contracts\DbDriverInterface;
use App\Providers\DataProvider;

class ParserService
{
    public function __construct(
        private readonly DataProvider $dataProvider,
        private readonly DbDriverInterface $database
    )
    {}

    /**
     * @return mixed
     */
    public function run(): mixed
    {
        $data = $this->dataProvider->prepare();

        return $this->database->save($data);
    }
}