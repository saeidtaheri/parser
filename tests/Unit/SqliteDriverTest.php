<?php

namespace tests\Unit;

use App\Drivers\Sqlite;
use PHPUnit\Framework\TestCase;

class SqliteDriverTest extends TestCase
{
    public function test_throw_exception_if_provide_a_wrong_config()
    {
        $this->expectExceptionMessage('driver config is invalid!');

        $config = [];
        $fileDriver = new Sqlite($config);

        $fileDriver->save(['test']);
    }

    public function test_can_save_to_db()
    {
        $config = [
            'connections' => [
                'sqlite' => [
                    'driver'    => 'sqlite',
                    'database'  => $_ENV['SQLITE_DATABASE'],
                ],
            ]
        ];
        $data = [
                0 => [
                    'id' => 2353246436,
                    'gender' => 'female',
                    'name' => 'jane doe',
                    'country' => 'Germany',
                    'postcode' => '235346',
                    'email' => 'sdgsdg@test.com',
                    'birthdate' => '1997-02-19T04:10:00.000Z',

                ],
                1 => [
                    'id' => 2356436,
                    'gender' => 'male',
                    'name' => 'john doe',
                    'country' => 'Germany',
                    'postcode' => '235346',
                    'email' => 'john@test.com',
                    'birthdate' => '1992-02-19T04:10:00.000Z',
                ],
        ];

        $db = new Sqlite($config);
        $db->save($data);

//        $dbMock = $this->createStub(Sqlite::class);
//
//        $dbMock->method('save')
//            ->willReturn("Users imported!" . PHP_EOL);
        $this->expectOutputString("Users imported!\n");
//        $this->assertSame("Users imported!" . PHP_EOL, $db->save($data));
    }
}