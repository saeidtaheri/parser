<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;
use PHPUnit\Util\Exception;

class File implements DbDriverInterface
{
    /**
     * @var string|mixed
     */
    private array $dbConfig;

    public function __construct($config)
    {
        if (empty($config))
            throw new Exception('driver config is invalid!');

        $this->dbConfig = $config;
    }

    /**
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function save(array $data): string
    {
        $destDir = $this->dbConfig['dest_path'];
        $fileName = $this->dbConfig['file_name'];
        if (!is_dir($destDir)) {
            throw new \Exception('file directory is invalid!');
        }

        file_put_contents($destDir . $fileName, var_export($data, true));

        return 'Users imported!';
    }
}