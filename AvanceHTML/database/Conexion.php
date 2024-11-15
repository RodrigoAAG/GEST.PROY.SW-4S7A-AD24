<?php

namespace Database;

use PDO;
use PDOException;

class Conexion
{
    private static $server = 'localhost';
    private static $user = 'root';
    private static $password = '';
    private static $database = 'TESTSUR';
    private static $conexion = null;

    // Método para conectar a la base de datos
    public static function conectar()
    {
        if (self::$conexion === null) {
            try {
                $dsn = "mysql:host=" . self::$server . ";dbname=" . self::$database . ";charset=utf8mb4";
                self::$conexion = new PDO($dsn, self::$user, self::$password);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return true;
            } catch (PDOException $e) {
                // Manejar error de conexión
                error_log("Error de conexión: " . $e->getMessage());
                return false;
            }
        }
        return true;
    }

    // Obtener la conexión actual
    public static function getConexion()
    {
        if (self::$conexion === null) {
            self::conectar();
        }
        return self::$conexion;
    }

    // Asignar nuevos datos de conexión
    public static function asignarDatosConexion($servidor, $usuario, $password)
    {
        self::$server = $servidor;
        self::$user = $usuario;
        self::$password = $password;
    }

    // Desconectar la conexión
    public static function desconectar()
    {
        if (self::$conexion !== null) {
            self::$conexion = null;
        }
    }
}
