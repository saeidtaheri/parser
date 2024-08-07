<?php

namespace tests\Integration;

use App\Contracts\DbDriverInterface;
use App\Drivers\File;
use App\Drivers\Sqlite;
use App\Drivers\SqliteInstaller;
use App\Kernel;
use App\Providers\Csv;
use App\Providers\DataProvider;
use App\Providers\Url;
use App\Services\ParserService;
use DI\Container;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function test_check_app_flow_works()
    {
        $container = new Container();
        $kernel = new Kernel('sqlite', $container);
        $kernel->bootstrap();
        $this->expectOutputString("Users imported!" . "\n");

        unlink('./storage/users.dump');
    }

    public function test_check_container_works()
    {
        $config = [
            'connections' => [
                'sqlite' => [
                    'database' => './storage/sqlite_testing.dump',
                ],
            ]
        ];

        $container = new Container();
        $db = (new SqliteInstaller())->setup($config['connections']['sqlite']);
        $container->set(DbDriverInterface::class, new Sqlite($db));
        $container->set(DataProvider::class, new DataProvider(new Csv(), new Url()));

        $parser = $container->get(ParserService::class);
        echo $parser->run();
        $this->expectOutputString("Users imported!");

        unlink('./storage/sqlite_testing.dump');
    }

    public function test_save_data_to_sqlite_database()
    {
        $config = [
            'connections' => [
                'sqlite' => [
                    'database' => './storage/sqlite_testing.dump',
                ],
            ]
        ];

        $dbInstaller = new SqliteInstaller();
        $db = $dbInstaller->setup($config['connections']['sqlite']);
        $driver = new Sqlite($db);
        $provider = new DataProvider(new Url(), new Csv());

        $parser = new ParserService($provider, $driver);
        echo $parser->run();

        $this->expectOutputString("Users imported!");

        unlink('./storage/sqlite_testing.dump');
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
