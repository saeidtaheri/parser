<?php

namespace App\Providers;

use App\Contracts\DataProviderInterface;
use Generator;

class Csv implements DataProviderInterface
{
    /**
     * @return array
     */
    public function provide(): array
    {
        $csvPath = getcwd() . '/data/users.csv';
        $arrayData = $this->readFromFile($csvPath);

        return iterator_to_array($arrayData);
    }

    /**
     * @param $filePath
     * @return Generator
     */
    private function readFromFile($filePath): Generator
    {
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        while ($row = fgetcsv($file)) {
            yield array_combine($header, $row);
        }

        fclose($file);
    }
}