<?php

namespace App\Drivers;

use App\Contracts\DbDriverInterface;
use Exception;
use SQLite3;

readonly class Sqlite implements DbDriverInterface
{
    /**
     * @param SQLite3 $db
     */
    public function __construct(private SQLite3 $db)
    {
    }

    /**
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function save(array $data): string
    {
        foreach ($data as $user) {
            $insertQuery = 'INSERT or REPLACE INTO users (
               id, gender, name, email, country, postcode, birthdate
               ) VALUES (:id, :gender, :name, :email, :country, :postcode, :birthdate)';

            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindValue(':id', $user['id']);
            $insertStmt->bindValue(':gender', $user['gender']);
            $insertStmt->bindValue(':name', $user['name']);
            $insertStmt->bindValue(':email', $user['email']);
            $insertStmt->bindValue(':country', $user['country']);
            $insertStmt->bindValue(':postcode', $user['postcode']);
            $insertStmt->bindValue(':birthdate', $user['birthdate']);

            try {
                $insertStmt->execute();
            } catch (Exception $e) {
                error_log('SQLiteException: ' . $e->getMessage());
                throw new Exception('Failed to insert user data: ' . $e->getMessage());
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
