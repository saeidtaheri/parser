<?php

namespace App\Services;

use App\Contracts\DbDriverInterface;
use App\Providers\DataProvider;

readonly class ParserService
{
    public function __construct(
        private DataProvider      $dataProvider,
        private DbDriverInterface $database
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