<?php

namespace DAO;

use Database\Conexion;
use Models\Materia;
use PDO;
use PDOException;

class MateriaDAO
{
    // Obtener todas las materias
    public function getAllMaterias()
    {
        $listaMaterias = [];

        if (Conexion::conectar()) {
            try {
                $query = "
                    SELECT 
                        IdMateria,
                        CodigoMateria,
                        Nombre
                    FROM 
                        Materias;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultados as $fila) {
                    $materia = new Materia(
                        $fila['IdMateria'],
                        $fila['CodigoMateria'],
                        $fila['Nombre']
                    );
                    $listaMaterias[] = $materia;
                }

                return $listaMaterias;
            } catch (PDOException $e) {
                error_log("Error en getAllMaterias: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        } else {
            return null; // Error de conexión
        }
    }

    // Obtener materias por número de control
    public function obtenerMateriasPorNoControl($noControl)
    {
        $materias = [];

        if (Conexion::conectar()) {
            try {
                $query = "
                    SELECT 
                        m.IdMateria,
                        m.CodigoMateria,
                        m.Nombre
                    FROM 
                        Materias m
                    JOIN 
                        UsuarioMaterias um ON m.IdMateria = um.IdMateria
                    WHERE 
                        um.NoControl = :noControl;
                ";

                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultados as $fila) {
                    $materia = new Materia(
                        $fila['IdMateria'],
                        $fila['CodigoMateria'],
                        $fila['Nombre']
                    );
                    $materias[] = $materia;
                }

                return $materias;
            } catch (PDOException $e) {
                error_log("Error en obtenerMateriasPorNoControl: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        } else {
            return null; // Error de conexión
        }
    }

    // Inscribir a una materia
    public function inscribirAMateria($noControl, $codigoMateria)
    {
        if (Conexion::conectar()) {
            try {
                $conexion = Conexion::getConexion();

                // Verificar si la materia existe
                $queryVerificarMateria = "
                    SELECT IdMateria FROM Materias WHERE CodigoMateria = :codigoMateria;
                ";
                $stmtVerificarMateria = $conexion->prepare($queryVerificarMateria);
                $stmtVerificarMateria->bindParam(':codigoMateria', $codigoMateria, PDO::PARAM_INT);
                $stmtVerificarMateria->execute();

                $idMateria = $stmtVerificarMateria->fetchColumn();

                if ($idMateria) {
                    // Insertar la relación en UsuarioMaterias
                    $queryInscribir = "
                        INSERT INTO UsuarioMaterias (NoControl, IdMateria)
                        VALUES (:noControl, :idMateria);
                    ";
                    $stmtInscribir = $conexion->prepare($queryInscribir);
                    $stmtInscribir->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                    $stmtInscribir->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
                    $stmtInscribir->execute();

                    return true; // Inscripción exitosa
                } else {
                    return false; // Materia no encontrada
                }
            } catch (PDOException $e) {
                error_log("Error en inscribirAMateria: " . $e->getMessage());
                return false; // Error durante la inscripción
            } finally {
                Conexion::desconectar();
            }
        } else {
            return false; // Error de conexión
        }
    }
}
