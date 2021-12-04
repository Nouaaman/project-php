<?php
require_once __DIR__ . '';

//db setings 
define("DB_HOST", "localhost");
define("DB_NAME", "test");
define("DB_USER", "root");
define("DB_PASSWORD", "");

class DB
{
    //connect to db
    public $error = "";
    private $pdo = null;
    private $stmt = null;
    function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASSWORD,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (Exception $ex) {
            exit($ex->getMessage());
        }
    }

    //close connection
    function __destruct()
    {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    // run a query
    function query(string $sql, string $param)
    {
        $result = false;
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $result = $this->stmt->fetchAll();
            return $result;
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
    }
}
