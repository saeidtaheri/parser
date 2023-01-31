<?php

namespace App\Providers;

use App\Contracts\DataProviderInterface;

class Csv implements DataProviderInterface
{
    /**
     * @return array
     */
    public function provide(): array
    {
        $csv_provider = array_map('str_getcsv', file(getcwd() . '/data/users.csv'));
        array_walk($csv_provider, function (&$item) use ($csv_provider) {
            $item = array_combine($csv_provider[0], $item);
        });

        // Remove header column
        array_shift($csv_provider);

        return $csv_provider;
    }
}