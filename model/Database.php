<?php

namespace metaxiii\sudokuSolver;

class Database
{
    private static $pdo = null;

    public static function getPdo()
    {
        $hostname = "localhost";
        $dbname = "sudokusolver";
        $charset = "utf8";
        $username = "root";
        $password = "";

        if (self::$pdo === null) {
            try {
                self::$pdo = new \PDO("mysql:host=$hostname.;dbname=$dbname;charset=$charset",
                $username, $password);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\Exception $e) {
                die("Erreur" . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
