<?php

return [
    'connections' => [

        'mysql' => [
            'host' => $_ENV['DB_HOST'] ?? 'test',
            'username' => $_ENV['DB_USERNAME'] ?? 'test',
            'password' => $_ENV['DB_PASSWORD'] ?? 'test',
            'db' => $_ENV['DB_DATABASE'] ?? 'test',
        ],

        'sqlite' => [
            'database'  => './storage/users.dump',
        ],

        'file' => [
            'file_name' => 'users.txt',
            'dest_path' => './storage/'
        ]
    ],
];