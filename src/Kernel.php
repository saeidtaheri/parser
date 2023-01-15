<?php

namespace App;

use App\Contracts\DbDriverInterface;
use App\Drivers\Factories\InstallerFactory;
use DI\Container;
use Exception;

class Kernel
{
    private array $config;
    private string $connection;
    private string $command;

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
    }

    /**
     * @return void
     */
    public function bootstrap(): void
    {
        $this->isValidCommand();

        if ($this->command === 'setup') {
            if (!in_array($this->connection, ['sqlite', 'mysql'])) {
                echo 'Setup does not required' . PHP_EOL;
                exit(7);
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
            echo $e->getMessage();
            exit(4);
        }
    }

    /**
     * @return void
     */
    private function execute(): void
    {
        $driver = "App\Drivers\\" . ucfirst($this->connection ?? 'sqlite');
        if (!class_exists($driver)) {
            echo 'Connection driver is invalid!' . PHP_EOL;
            exit(5);
        }

        $driverConfig = include('./config/database.php');

        $container = new Container();
        $container->set(DbDriverInterface::class, new $driver($driverConfig['connections'][$this->connection]));
        try {
            $parser = $container->get('App\Services\ParserService');
            echo $parser->run() . PHP_EOL;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit(6);
        }
    }

    /**
     * @return void
     */
    public function isValidCommand(): void
    {
        if (!in_array($this->command, ['run', 'setup'])) {
            echo 'command is invalid!' . PHP_EOL;
            exit(1);
        }
    }
}