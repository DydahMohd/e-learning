<?php
declare(strict_types=1);

/*
 * EAC Statistics e-Learning Platform
 * MariaDB Database Layer
 */

class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {

            $dsn =
                'mysql:host=' . DB_HOST .
                ';port=' . DB_PORT .
                ';dbname=' . DB_NAME .
                ';charset=utf8mb4';

            self::$pdo = new PDO(
                $dsn,
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC,

                    PDO::ATTR_EMULATE_PREPARES =>
                        false,
                ]
            );
            // Keep MariaDB NOW() and PHP date/time values in the same EAC time zone.
            self::$pdo->exec('SET time_zone = ' . self::$pdo->quote(DB_TIME_ZONE));
        }

        return self::$pdo;
    }
}
function db(): PDO { return Database::connect(); }
