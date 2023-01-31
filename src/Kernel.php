<?php

namespace App;

use App\Contracts\DbDriverInterface;
use App\Drivers\Factories\InstallerFactory;
use App\Providers\Csv;
use App\Providers\DataProvider;
use App\Providers\Url;
use DI\Container;
use Exception;

class Kernel
{
    const SETUPABLE_CONNECTIONS = ['sqlite', 'mysql'];
    private array $config;
    private string $connection;
    private readonly string $driver;
    private Container $container;

    /**
     * @param array $config
     * @param string $connection
     */
    public function __construct(array $config, string $connection)
    {
        $this->config = $config;
        $this->connection = $connection;

        $this->container = new Container();
    }

    /**
     * @return void
     */
    public function bootstrap(): void
    {
        $this->driver = "App\Drivers\\" . ucfirst($this->connection);
        if (!class_exists($this->driver)) {
            echo 'Connection driver is invalid!' . PHP_EOL;
            exit(4);
        }

        $this->bootServices();

        try {
            $parser = $this->container->get('App\Services\ParserService');
            echo $parser->run() . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit(5);
        }
    }

    /**
     * @return void
     */
    private function bootServices(): void
    {
        $driverConfig = include('./config/database.php');
        if (in_array($this->connection, self::SETUPABLE_CONNECTIONS)) {
            try {
                $driverInstaller = InstallerFactory::make($this->connection);
                $driverDb = new $driverInstaller($this->config['connections'][$this->connection]);
                $db = $driverDb->setup($driverConfig['connections'][$this->connection]);
            } catch (Exception $e) {
                echo 'Driver bootstrapping failed due to ' . $e->getMessage() . PHP_EOL;
                exit(3);
            }
            $this->container->set(DbDriverInterface::class, new $this->driver($db));
        } else {
            $this->container->set(DbDriverInterface::class, new $this->driver($driverConfig['connections'][$this->connection]));
        }
        $this->container->set(DataProvider::class, new DataProvider(new Csv(), new Url()));
    }
}