<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;
use PHPUnit\Util\Exception;
use SQLite3;

class Sqlite implements DbDriverInterface
{
    /**
     * @var SQLite3
     */
    private SQLite3 $db;

    /**
     * @var array|mixed
     */
    private array $dbConf;

    public function __construct($config)
    {
        if (empty($config))
            throw new Exception('driver config is invalid!');

        $this->db = SqliteInstaller::setup($config);
    }

//    /**
//     * @return void
//     */
//    private function setup(): void
//    {
//        $dbFile = $this->dbConf['connections'][$_ENV['CONNECTION']]['database'];
//
//        try {
//            $this->db = new SQLite3($dbFile);
//            $this->db->exec('CREATE TABLE IF NOT EXISTS users (
//                id INTEGER PRIMARY KEY,
//                gender TEXT NOT NULL,
//                name TEXT NOT NULL,
//                email TEXT NOT NULL,
//                country TEXT,
//                postcode TEXT,
//                birthdate DATE)'
//            );
//        } catch (\SQLiteException $e) {
//            throw new \SQLiteException($e->getMessage());
//        }
//    }

    /**
     * @param array $data
     * @return string
     */
    public function save(array $data): string
    {
        foreach ($data as $user) {
            $result = $this->db->query('SELECT count(*) FROM users WHERE id = ' . $user['id']);
            $num = $result->fetchArray(SQLITE3_NUM);
            if ($num[0] === 0) {
                try {
                    $this->db->exec("INSERT INTO users VALUES(
                         '" . $user['id'] . "' ,'" . $user['gender'] . "','" . $user['name'] . "','" . $user['email'] . "',
                         '" . $user['country'] . "','" . $user['postcode'] . "','" . $user['birthdate'] . "')
                    ");
                } catch (\SQLiteException $e) {
                    die($e->getMessage());
                }
            }
        }

        return 'Users imported!';

//        $this->closeConnection();

//        return $res;
//        if ($res)
//            return  "Users imported!";
//
//        return 'something wrong, try again later!';
    }

    /**
     * @return void
     */
    private function closeConnection(): void
    {
        $this->db->close();
    }
}