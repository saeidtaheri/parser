<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;
use Exception;

readonly class File implements DbDriverInterface
{
    /**
     * @param array $config
     * @throws Exception
     */
    public function __construct(private array $config)
    {
        if (empty($config)) {
            throw new Exception('Config file should be provided!');
        }
    }

    /**
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function save(array $data): string
    {
        $destDir = $this->config['dest_path'];
        $fileName = $this->config['file_name'];

        if (!is_dir($destDir) || is_null($fileName)) {
            throw new Exception('File configs is invalid!');
        }

        file_put_contents($destDir . $fileName, var_export($data, true));

        return 'Users imported!';
    }
}
