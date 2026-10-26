<?php
namespace App;

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $data = 'stefanoshood';
        $user = 'root';
        $pass = 'allblack***8';
        $chrs = 'utf8mb4';
        $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
        $opts = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new \PDO($attr, $user, $pass, $opts);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}