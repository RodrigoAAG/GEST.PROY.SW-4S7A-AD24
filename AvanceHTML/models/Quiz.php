<?php

namespace Models;

class Quiz
{
    private $idQuiz;
    private $idUnidad;
    private $nombreQuiz;
    private $activo;

    // Constructor con parámetros
    public function __construct($idQuiz = 0, $idUnidad = 0, $nombreQuiz = '', $activo = 1)
    {
        $this->idQuiz = $idQuiz;
        $this->idUnidad = $idUnidad;
        $this->nombreQuiz = $nombreQuiz;
        $this->activo = $activo;
    }

    // Getters y Setters
    public function getIdQuiz()
    {
        return $this->idQuiz;
    }

    public function setIdQuiz($idQuiz)
    {
        $this->idQuiz = $idQuiz;
    }

    public function getIdUnidad()
    {
        return $this->idUnidad;
    }

    public function setIdUnidad($idUnidad)
    {
        $this->idUnidad = $idUnidad;
    }

    public function getNombreQuiz()
    {
        return $this->nombreQuiz;
    }

    public function setNombreQuiz($nombreQuiz)
    {
        $this->nombreQuiz = $nombreQuiz;
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
