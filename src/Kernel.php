<?php

namespace App;

use App\Contracts\DbDriverInterface;
use App\Drivers\Factories\InstallerFactory;
use App\Drivers\File;
use App\Drivers\Sqlite;
use App\Providers\Csv;
use App\Providers\DataProvider;
use App\Providers\Url;
use App\Services\ParserService;
use DI\Container;
use Exception;

class Kernel
{
    private readonly string $driver;

    /**
     * @param string $connection
     * @param Container $container
     */
    public function __construct(
        private readonly string    $connection,
        private readonly Container $container
    )
    {
    }

    /**
     * @return void
     * @throws Exception
     */
    public function bootstrap(): void
    {
        $this->setDriver();
        $this->bootServices();

        try {
            $parser = $this->container->get(ParserService::class);
            echo $parser->run() . PHP_EOL;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function bootServices(): void
    {
        $dbConnectionConfig = config($this->connection);
        if (is_configurable($this->connection)) {
            try {
                $dbDriver = InstallerFactory::make($this->connection);
                $db = $dbDriver->setup($dbConnectionConfig);
            } catch (Exception $e) {
                throw new Exception(
                    'Driver bootstrapping failed due to ' . $e->getMessage()
                );
            }
            $this->container->set(DbDriverInterface::class, new $this->driver($db));
        } else {
            $this->container->set(
                DbDriverInterface::class,
                new $this->driver($dbConnectionConfig)
            );
        }
        $this->container->set(
            DataProvider::class,
            new DataProvider(new Csv(), new Url())
        );
    }

    private function setDriver(): void
    {
        $this->driver = match ($this->connection) {
            'file' => File::class,
            'sqlite' => Sqlite::class,
            default => throw new Exception(
                "Connection driver `$this->connection` is invalid!"
            )
        };
    }
}
