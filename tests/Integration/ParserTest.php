<?php

namespace tests\Integration;

use App\Drivers\File;
use App\Drivers\Sqlite;
use App\Providers\DataProvider;
use App\Services\ParserService;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function test_save_data_to_sqlite_database()
    {
        $config = [
            'connections' => [
                'sqlite' => [
                    'driver'    => 'sqlite',
                    'database'  => $_ENV['SQLITE_DATABASE'],
                ],
            ]
        ];

        $driver = new Sqlite($config);
        $provider = new DataProvider();

        $parser = new ParserService($provider, $driver);
        $parser->run();

//        $this->assertSame(true, $parser->run());
        $this->expectOutputString("Users imported!\n");
    }

    public function test_save_data_to_file()
    {
        $config = [
            'connections' => [
                'file' => [
                    'file_name' => 'users_test.txt',
                    'dest_path' => getcwd() . '/storage/'
                ]
            ]
        ];

        $file = getcwd() . '/storage/' . $config['connections']['file']['file_name'];

        $driver = new File($config);
        $provider = new DataProvider();

        $parser = new ParserService($provider, $driver);
        $parser->run();

        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');
        $this->expectOutputString("Users imported!\n");

        unlink($file);
    }
}