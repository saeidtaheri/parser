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
        return $this->database->save($this->getData());
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return $this->dataProvider
            ->fromCsv()
            ->fromUrl()
            ->prepare();
    }
}