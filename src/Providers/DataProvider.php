<?php

namespace App\Providers;

use App\Contracts\DataProviderInterface;

class DataProvider
{
    private array $providers;

    public function __construct(DataProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    public function prepare(): array
    {
        $data = [];
        foreach ($this->providers as $provider) {
            $data[] = $provider->provide();
        }

        return call_user_func_array('array_merge', $data);
    }
}