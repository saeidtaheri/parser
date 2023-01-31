<?php

namespace tests\Integration;

use App\Drivers\File;
use App\Drivers\Sqlite;
use App\Drivers\SqliteInstaller;
use App\Providers\Csv;
use App\Providers\DataProvider;
use App\Providers\Url;
use App\Services\ParserService;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function test_save_data_to_sqlite_database()
    {
        $config = [
            'driver'    => 'sqlite',
            'database'  => './storage/sqlite_testing.dump',
        ];

        $dbInstaller = new SqliteInstaller();
        $db = $dbInstaller->setup($config);
        $driver = new Sqlite($db);
        $provider = new DataProvider(new Url(), new Csv());

        $parser = new ParserService($provider, $driver);
        echo $parser->run();

        $this->expectOutputString("Users imported!");

        unlink($config['database']);
    }

    public function test_save_data_to_file()
    {
        $config = [
            'file_name' => 'users_test.txt',
            'dest_path' => './storage/'
        ];

        $file = $config['dest_path'] . $config['file_name'];

        $driver = new File($config);
        $provider = new DataProvider(new Url(), new Csv());

        $parser = new ParserService($provider, $driver);
        echo $parser->run();

        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');
        $this->expectOutputString("Users imported!");

        unlink($file);
    }
}