<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;
use SQLite3;
use SQLiteException;

class Sqlite implements DbDriverInterface
{
    /**
     * @var SQLite3
     */
    private SQLite3 $db;

    /**
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

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
                } catch (SQLiteException $e) {
                    die($e->getMessage());
                }
            }
        }

        $this->closeConnection();

        return 'Users imported!';
    }

    /**
     * @return void
     */
    private function closeConnection(): void
    {
        $this->db->close();
    }
}