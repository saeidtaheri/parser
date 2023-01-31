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
    private array $config;
    private string $connection;
    private string $command;
    private readonly string $driver;
    private Container $container;
    private mixed $driverDb;

    /**
     * @param array $config
     * @param string $connection
     * @param array $arg
     */
    public function __construct(array $config, string $connection, array $arg)
    {
        $this->config = $config;
        $this->connection = $connection;
        $this->command = $arg[1] ?? 'run';

        $this->container = new Container();
    }

    /**
     * @return void
     */
    public function bootstrap(): void
    {
        $this->isValidCommand();

        if ($this->command === 'setup') {
            if (!in_array($this->connection, ['sqlite', 'mysql'])) {
                echo 'Setup does not required!' . PHP_EOL;
                exit(2);
            }

            $this->setup();
        } else {
            $this->execute();
        }
    }

    /**
     * @return void
     */
    private function setup(): void
    {
        try {
            $driverInstaller = InstallerFactory::make($this->connection);
            call_user_func($driverInstaller . '::setup', $this->config['connections'][$this->connection]);
            echo 'Driver has been bootstrapped' . PHP_EOL;
        } catch (Exception $e) {
            echo 'Driver bootstrapping failed due to ' . $e->getMessage() . PHP_EOL;
            exit(3);
        }
    }

    /**
     * @return void
     */
    private function execute(): void
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

    private function bootServices(): void
    {
        $driverConfig = include('./config/database.php');

        $this->container->set(DbDriverInterface::class, new $this->driver($driverConfig['connections'][$this->connection]));
        $this->container->set(DataProvider::class, new DataProvider(new Csv(), new Url()));
    }

    /**
     * @return void
     */
    private function isValidCommand(): void
    {
        if (!in_array($this->command, ['run', 'setup'])) {
            echo 'Command is invalid!' . PHP_EOL;
            exit(1);
        }
    }
}