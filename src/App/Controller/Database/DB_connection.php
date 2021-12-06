<?php

namespace App\Controller\Database;

class DatabaseConnect
{
    private $host;
    private $user;
    private $pwd;
    private $database;

    function __construct()
    {
        $configs = require(__DIR__ . '../../../../../config/app.local.php');

        $this->host = $configs['DB_HOST'];
        $this->user = $configs['DB_USER'];
        $this->pw = $configs['DB_PASSWORD'];
        $this->database = $configs['DB_NAME'];
    }

    public function GetConnection()
    {
        try {
            $connection = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database . '', $this->user, $this->pwd);

            return $connection;
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
    }


    // public function db_connect()
    // {
    //     try {
    //         $configs = require(__DIR__ . '../../../../../config/app.local.php');
    //         $connection = new \PDO(
    //             "mysql:host={$configs['DB_HOST']};dbname={$configs['DB_NAME']};charset=utf8",
    //             $configs['DB_USER'],
    //             $configs['DB_PASSWORD'],
    //             [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
    //         );
    //         return $connection;
    //     } catch (\Exception $ex) {
    //         die($ex->getMessage());
    //     }
    // }

}
