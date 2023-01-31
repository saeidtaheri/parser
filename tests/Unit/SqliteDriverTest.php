<?php

namespace tests\Unit;

use App\Drivers\Sqlite;
use App\Drivers\SqliteInstaller;
use PHPUnit\Framework\TestCase;

class SqliteDriverTest extends TestCase
{
    public function test_can_save_to_db()
    {
        $config = [
            'driver' => 'sqlite',
            'database'  => './storage/sqlite_testing.dump',
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

        $dbInstaller = new SqliteInstaller();
        $db = $dbInstaller->setup($config);
        $db = new Sqlite($db);

        $this->assertSame("Users imported!", $db->save($data));

        unlink('./storage/sqlite_testing.dump');
    }
}