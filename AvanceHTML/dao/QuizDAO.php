<?php

namespace DAO;

use Database\Conexion;
use Models\Quiz;
use Models\Pregunta;
use Models\Opcion;
use PDO;
use PDOException;

class QuizDAO
{
    public function obtenerIdUnidadPorNombreYIdMateria($idMateria, $nombreUnidad)
    {
        if (Conexion::conectar()) {
            try {
                $query = "SELECT IdUnidad FROM Unidades WHERE IdMateria = :idMateria AND NombreUnidad = :nombreUnidad";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
                $stmt->bindParam(':nombreUnidad', $nombreUnidad, PDO::PARAM_STR);
                $stmt->execute();

                $idUnidad = $stmt->fetchColumn();
                return $idUnidad ? intval($idUnidad) : -1;
            } catch (PDOException $e) {
                error_log("Error en obtenerIdUnidadPorNombreYIdMateria: " . $e->getMessage());
                return -1;
            } finally {
                Conexion::desconectar();
            }
        }
        return -1;
    }

    public function obtenerQuizPorIdUnidad($idUnidad)
    {
        if (Conexion::conectar()) {
            try {
                $query = "SELECT IdQuiz, IdUnidad, NombreQuiz, Activo FROM Quizzes WHERE IdUnidad = :idUnidad";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idUnidad', $idUnidad, PDO::PARAM_INT);
                $stmt->execute();

                $quiz = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($quiz) {
                    return new Quiz($quiz['IdQuiz'], $quiz['IdUnidad'], $quiz['NombreQuiz'], $quiz['Activo']);
                }
                return null;
            } catch (PDOException $e) {
                error_log("Error en obtenerQuizPorIdUnidad: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function modificarActivoEnQuiz($idQuiz, $activo)
    {
        if (Conexion::conectar()) {
            try {
                $query = "UPDATE Quizzes SET Activo = :activo WHERE IdQuiz = :idQuiz";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idQuiz', $idQuiz, PDO::PARAM_INT);
                $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
                return $stmt->execute();
            } catch (PDOException $e) {
                error_log("Error en modificarActivoEnQuiz: " . $e->getMessage());
                return false;
            } finally {
                Conexion::desconectar();
            }
        }
        return false;
    }

    public function obtenerPreguntasPorIdQuiz($idQuiz)
    {
        $preguntas = [];
        if (Conexion::conectar()) {
            try {
                $query = "SELECT IdPregunta, IdQuiz, TextoPregunta, RespuestaCorrecta FROM Preguntas WHERE IdQuiz = :idQuiz ORDER BY IdPregunta ASC";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idQuiz', $idQuiz, PDO::PARAM_INT);
                $stmt->execute();

                while ($pregunta = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $preguntas[] = new Pregunta(
                        $pregunta['IdPregunta'],
                        $pregunta['IdQuiz'],
                        $pregunta['TextoPregunta'],
                        $pregunta['RespuestaCorrecta']
                    );
                }
                return $preguntas;
            } catch (PDOException $e) {
                error_log("Error en obtenerPreguntasPorIdQuiz: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function obtenerOpcionesPorIdPregunta($idPregunta)
    {
        $opciones = [];
        if (Conexion::conectar()) {
            try {
                $query = "SELECT IdOpcion, IdPregunta, TextoOpcion FROM Opciones WHERE IdPregunta = :idPregunta ORDER BY IdOpcion ASC";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idPregunta', $idPregunta, PDO::PARAM_INT);
                $stmt->execute();

                while ($opcion = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $opciones[] = new Opcion(
                        $opcion['IdOpcion'],
                        $opcion['IdPregunta'],
                        $opcion['TextoOpcion']
                    );
                }
                return $opciones;
            } catch (PDOException $e) {
                error_log("Error en obtenerOpcionesPorIdPregunta: " . $e->getMessage());
                return null;
            } finally {
                Conexion::desconectar();
            }
        }
        return null;
    }

    public function obtenerCalificacion($idMateria, $idUnidad, $noControl)
    {
        if (Conexion::conectar()) {
            try {
                $query = "SELECT Calificacion FROM Calificaciones WHERE IdMateria = :idMateria AND IdUnidad = :idUnidad AND NoControl = :noControl";
                $conexion = Conexion::getConexion();
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
                $stmt->bindParam(':idUnidad', $idUnidad, PDO::PARAM_INT);
                $stmt->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmt->execute();

                $calificacion = $stmt->fetchColumn();
                return $calificacion ? intval($calificacion) : -1;
            } catch (PDOException $e) {
                error_log("Error en obtenerCalificacion: " . $e->getMessage());
                return -1;
            } finally {
                Conexion::desconectar();
            }
        }
        return -1;
    }

    public function subirCalificacion($idMateria, $idUnidad, $noControl, $calificacion)
    {
        if (Conexion::conectar()) {
            try {
                $conexion = Conexion::getConexion();

                $queryVerificar = "SELECT COUNT(*) FROM Calificaciones WHERE IdMateria = :idMateria AND IdUnidad = :idUnidad AND NoControl = :noControl";
                $stmtVerificar = $conexion->prepare($queryVerificar);
                $stmtVerificar->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
                $stmtVerificar->bindParam(':idUnidad', $idUnidad, PDO::PARAM_INT);
                $stmtVerificar->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmtVerificar->execute();

                $count = intval($stmtVerificar->fetchColumn());

                if ($count > 0) {
                    $queryActualizar = "UPDATE Calificaciones SET Calificacion = :calificacion WHERE IdMateria = :idMateria AND IdUnidad = :idUnidad AND NoControl = :noControl";
                    $stmtActualizar = $conexion->prepare($queryActualizar);
                    $stmtActualizar->bindParam(':calificacion', $calificacion, PDO::PARAM_INT);
                } else {
                    $queryInsertar = "INSERT INTO Calificaciones (IdMateria, IdUnidad, NoControl, Calificacion) VALUES (:idMateria, :idUnidad, :noControl, :calificacion)";
                    $stmtActualizar = $conexion->prepare($queryInsertar);
                }

                $stmtActualizar->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
                $stmtActualizar->bindParam(':idUnidad', $idUnidad, PDO::PARAM_INT);
                $stmtActualizar->bindParam(':noControl', $noControl, PDO::PARAM_STR);
                $stmtActualizar->execute();
                return true;
            } catch (PDOException $e) {
                error_log("Error en subirCalificacion: " . $e->getMessage());
                return false;
            } finally {
                Conexion::desconectar();
            }
        }
        return false;
    }
}
