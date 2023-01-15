<?php

namespace tests\Unit;

use App\Providers\DataProvider;
use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    public function test_provide_data_from_csv_provider()
    {
        $provider = new DataProvider();
        $data = $provider->fromCsv()->prepare();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertCount(7, $data);
    }

    public function test_provide_data_from_url_provider()
    {
        $provider = new DataProvider();
        $data = $provider->fromUrl()->prepare();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertCount(5, $data);
    }

    public function test_provide_data_from_csv_and_url_provider()
    {
        $provider = new DataProvider();
        $data = $provider->fromCsv()->fromUrl()->prepare();

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertCount(12, $data);
    }
}