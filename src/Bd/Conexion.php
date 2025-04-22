<?php

namespace App\Bd;

use \PDO;
use \PDOException;

class Conexion
{
    private static ?PDO $conexion = null;

    protected static function getConexion(): PDO
    {
        if (self::$conexion === null) {
            self::setConexion();
        }
        return self::$conexion;
    }

    private static function setConexion()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->safeLoad();

        $usuario = $_ENV['USUARIO'];
        $pass = $_ENV['PASSWORD'];
        $dbname = $_ENV["DBNAME"];
        $host = $_ENV['HOST'];
        $port = $_ENV['PORT'] ?? 3306;

        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true,
        ];
        try {
            self::$conexion = new PDO($dsn, $usuario, $pass, $options);
        } catch (PDOException $ex) {
            throw new PDOException("Error en la conexion: " . $ex->getMessage());
        }
    }

    protected static function cerrarConexion()
    {
        self::$conexion = null;
    }
}
