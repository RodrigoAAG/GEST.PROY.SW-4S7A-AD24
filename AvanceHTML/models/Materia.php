<?php

namespace Models;

class Materia
{
    private $idMateria;
    private $codigoMateria;
    private $nombre;

    // Constructor con parámetros
    public function __construct($idMateria = 0, $codigoMateria = 0, $nombre = '')
    {
        $this->idMateria = $idMateria;
        $this->codigoMateria = $codigoMateria;
        $this->nombre = $nombre;
    }

    // Getters y Setters
    public function getIdMateria()
    {
        return $this->idMateria;
    }

    public function setIdMateria($idMateria)
    {
        $this->idMateria = $idMateria;
    }

    public function getCodigoMateria()
    {
        return $this->codigoMateria;
    }

    public function setCodigoMateria($codigoMateria)
    {
        $this->codigoMateria = $codigoMateria;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
