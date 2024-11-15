<?php

namespace Models;

class Unidad
{
    private $idUnidad;
    private $idMateria;
    private $nombreUnidad;

    // Constructor con parámetros
    public function __construct($idUnidad = 0, $idMateria = 0, $nombreUnidad = '')
    {
        $this->idUnidad = $idUnidad;
        $this->idMateria = $idMateria;
        $this->nombreUnidad = $nombreUnidad;
    }

    // Getters y Setters
    public function getIdUnidad()
    {
        return $this->idUnidad;
    }

    public function setIdUnidad($idUnidad)
    {
        $this->idUnidad = $idUnidad;
    }

    public function getIdMateria()
    {
        return $this->idMateria;
    }

    public function setIdMateria($idMateria)
    {
        $this->idMateria = $idMateria;
    }

    public function getNombreUnidad()
    {
        return $this->nombreUnidad;
    }

    public function setNombreUnidad($nombreUnidad)
    {
        $this->nombreUnidad = $nombreUnidad;
    }
}
