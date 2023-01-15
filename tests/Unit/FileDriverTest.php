<?php

namespace tests\Unit;

use App\Drivers\File;
use PHPUnit\Framework\TestCase;

class FileDriverTest extends TestCase
{
    public function test_throw_exception_if_provide_a_wrong_config()
    {
        $this->expectExceptionMessage('driver config is invalid!');

        $config = [];
        $fileDriver = new File($config);

        $fileDriver->save(['test']);
    }

    public function test_can_save_to_file()
    {
        $config = [
            'connections' => [
                'file' => [
                    'file_name' => 'users_test.txt',
                    'dest_path' => getcwd() . '/storage/'
                ]
            ]
        ];

        $fileDriver = new File($config);
        $file = './storage/' . $config['connections']['file']['file_name'];
        $fileDriver->save(['test']);

        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');
        $this->expectOutputString("Users imported!\n");

        unlink($file);
    }
}