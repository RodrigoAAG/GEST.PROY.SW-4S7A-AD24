<?php

namespace DAO;

use Database\Conexion;
use Models\Usuario;
use PDO;
use PDOException;

class UsuariosDAO
{
    public function getAllUsuarios()
    {
        $listaUsuarios = [];

        if (Conexion::conectar()) {
            try {
                $query = "
                    SELECT 
                        NoControl,
                        Nombre,
                        Apellidos,
                        TipoDeCuenta,
                        Semestre,
                        Especialidad,
                        Contraseña
                    FROM 
                        Usuarios;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->execute();

                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultados as $fila) {
                    $usuario = new Usuario(
                        $fila['NoControl'],
                        $fila['Nombre'],
                        $fila['Apellidos'],
                        $fila['TipoDeCuenta'],
                        intval($fila['Semestre']),
                        $fila['Especialidad'],
                        $fila['Contraseña']
                    );
                    $listaUsuarios[] = $usuario;
                }

                return $listaUsuarios;
            } catch (PDOException $e) {
                error_log("Error en getAllUsuarios: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function buscarUsuario($noControl)
    {
        if (Conexion::conectar()) {
            try {
                $query = "
                    SELECT 
                        NoControl,
                        Nombre,
                        Apellidos,
                        TipoDeCuenta,
                        Semestre,
                        Especialidad,
                        Contraseña
                    FROM 
                        Usuarios
                    WHERE 
                        NoControl = :noControl;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmt->execute();

                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    return new Usuario(
                        $usuario['NoControl'],
                        $usuario['Nombre'],
                        $usuario['Apellidos'],
                        $usuario['TipoDeCuenta'],
                        intval($usuario['Semestre']),
                        $usuario['Especialidad'],
                        $usuario['Contraseña']
                    );
                }
                return null;
            } catch (PDOException $e) {
                error_log("Error en buscarUsuario: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function verificarCredenciales($noControl, $contraseña)
    {
        if (Conexion::conectar()) {
            try {
                $query = "
                    SELECT 
                        NoControl,
                        Nombre,
                        Apellidos,
                        TipoDeCuenta,
                        Semestre,
                        Especialidad,
                        Contraseña
                    FROM 
                        Usuarios
                    WHERE 
                        NoControl = :noControl AND Contraseña = :contraseña;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmt->bindParam(':contraseña', $contraseña, PDO::PARAM_STR);
                $stmt->execute();

                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    return new Usuario(
                        $usuario['NoControl'],
                        $usuario['Nombre'],
                        $usuario['Apellidos'],
                        $usuario['TipoDeCuenta'],
                        intval($usuario['Semestre']),
                        $usuario['Especialidad'],
                        $usuario['Contraseña']
                    );
                }
                return null;
            } catch (PDOException $e) {
                error_log("Error en verificarCredenciales: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function agregarUsuario(Usuario $usuario)
    {
        if (Conexion::conectar()) {
            try {
                $queryVerificar = "
                    SELECT NoControl FROM Usuarios WHERE NoControl = :noControl;
                ";

                $conexion = Conexion::getConexion();
                $stmtVerificar = $conexion->prepare($queryVerificar);
                $stmtVerificar->bindParam(':noControl', $usuario->getNoControl(), PDO::PARAM_STR);
                $stmtVerificar->execute();

                if ($stmtVerificar->fetch()) {
                    return -1; // Usuario ya existe
                }

                $queryInsertar = "
                    INSERT INTO Usuarios (
                        NoControl, Nombre, Apellidos, TipoDeCuenta, Semestre, Especialidad, Contraseña
                    ) VALUES (
                        :noControl, :nombre, :apellidos, :tipoDeCuenta, :semestre, :especialidad, :contraseña
                    );
                ";

                $stmtInsertar = $conexion->prepare($queryInsertar);
                $stmtInsertar->bindParam(':noControl', $usuario->getNoControl(), PDO::PARAM_STR);
                $stmtInsertar->bindParam(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
                $stmtInsertar->bindParam(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
                $stmtInsertar->bindParam(':tipoDeCuenta', $usuario->getTipoDeCuenta(), PDO::PARAM_STR);
                $stmtInsertar->bindParam(':semestre', $usuario->getSemestre(), PDO::PARAM_INT);
                $stmtInsertar->bindParam(':especialidad', $usuario->getEspecialidad(), PDO::PARAM_STR);
                $stmtInsertar->bindParam(':contraseña', $usuario->getContraseña(), PDO::PARAM_STR);

                return $stmtInsertar->execute() ? 1 : 0;
            } catch (PDOException $e) {
                error_log("Error en agregarUsuario: " . $e->getMessage());
                return 0;
            } finally {
                Conexion::desconectar();
            }
        }
        return 0;
    }

    public function modificarUsuario(Usuario $usuario)
    {
        if (Conexion::conectar()) {
            try {
                $queryActualizar = "
                    UPDATE Usuarios SET
                        Nombre = :nombre,
                        Apellidos = :apellidos,
                        TipoDeCuenta = :tipoDeCuenta,
                        Semestre = :semestre,
                        Especialidad = :especialidad,
                        Contraseña = :contraseña
                    WHERE 
                        NoControl = :noControl;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($queryActualizar);
                $stmt->bindParam(':noControl', $usuario->getNoControl(), PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
                $stmt->bindParam(':apellidos', $usuario->getApellidos(), PDO::PARAM_STR);
                $stmt->bindParam(':tipoDeCuenta', $usuario->getTipoDeCuenta(), PDO::PARAM_STR);
                $stmt->bindParam(':semestre', $usuario->getSemestre(), PDO::PARAM_INT);
                $stmt->bindParam(':especialidad', $usuario->getEspecialidad(), PDO::PARAM_STR);
                $stmt->bindParam(':contraseña', $usuario->getContraseña(), PDO::PARAM_STR);

                return $stmt->execute() ? 1 : 0;
            } catch (PDOException $e) {
                error_log("Error en modificarUsuario: " . $e->getMessage());
                return 0;
            } finally {
                Conexion::desconectar();
            }
        }
        return 0;
    }
}
