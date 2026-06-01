<?php
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: '3306';
        $name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: '';
        $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root';
        $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '';

        $hosts = array_values(array_unique([$host, 'localhost']));
        $lastException = null;

        foreach ($hosts as $currentHost) {
            $dsn = "mysql:host={$currentHost};port={$port};dbname={$name};charset=utf8mb4";

            try {
                self::$connection = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
                return self::$connection;
            } catch (PDOException $e) {
                $lastException = $e;
            }
        }

        $mensagem = 'Falha na ligacao a base de dados. Verifica se o MySQL/MariaDB esta a correr, e se as credenciais em .env estao corretas.';
        if ($lastException instanceof PDOException) {
            $mensagem .= ' Detalhe: ' . $lastException->getMessage();
        }
        throw new PDOException($mensagem, (int) ($lastException?->getCode() ?? 0), $lastException);
    }
}
