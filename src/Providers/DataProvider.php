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
        $data = array_map(fn($provider) => $provider->provide(), $this->providers);

        return array_merge(...$data);
    }
}