<?php

if (!function_exists('config')) {
    function config($value)
    {
        $config = include './config/database.php';

        return $config['connections'][$value];
    }
}

if (!function_exists('is_configurable')) {
    function is_configurable($connection): bool
    {
        $configurableConnections = [
            'mysql',
            'sqlite',
        ];

        return in_array($connection, $configurableConnections);
    }
}