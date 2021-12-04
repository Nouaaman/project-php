<?php

function db_connect()
{
    try {
        $configs = require(__DIR__ . '../../../../config/app.local.php');
        $connection = new PDO(
            "mysql:host={$configs['DB_HOST']};dbname={$configs['DB_NAME']};charset=utf8",
            $configs['DB_USER'],
            $configs['DB_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $connection;
    } catch (Exception $ex) {
        die($ex->getMessage());
    }
}
