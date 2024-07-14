<?php

namespace tests\Unit;

use App\Drivers\File;
use PHPUnit\Framework\TestCase;

class FileDriverTest extends TestCase
{
    public function test_throw_exception_if_provide_a_wrong_config()
    {
        $this->expectExceptionMessage('Config file should be provided!');

        $config = [];

        $fileDriver = new File($config);

        $fileDriver->save(['test']);
    }

    public function test_throw_exception_if_file_directory_is_not_valid()
    {
        $this->expectExceptionMessage('File configs is invalid!');

        $config = [
            'file_name' => 'users_test.txt',
            'dest_path' => './storaged/'
        ];

        $fileDriver = new File($config);
        $file = './storage/' . $config['file_name'];

        $this->assertSame("Users imported!", $fileDriver->save(['test']));
        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');

        unlink($file);
    }

    public function test_can_save_to_file()
    {
        $config = [
            'file_name' => 'users_test.txt',
            'dest_path' => './storage/'
        ];

        $fileDriver = new File($config);
        $file = './storage/' . $config['file_name'];

        $this->assertSame("Users imported!", $fileDriver->save(['test']));
        $this->assertFileExists($file);
        $this->assertStringNotEqualsFile($file, '');

        unlink($file);
    }
}