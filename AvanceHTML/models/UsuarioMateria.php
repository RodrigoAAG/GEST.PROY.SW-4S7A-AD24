<?php

namespace Models;

class UsuarioMateria
{
    private $noControl;
    private $idMateria;

    // Constructor con parámetros
    public function __construct($noControl = 0, $idMateria = 0)
    {
        $this->noControl = $noControl;
        $this->idMateria = $idMateria;
    }

    // Getters y Setters
    public function getNoControl()
    {
        return $this->noControl;
    }

    public function setNoControl($noControl)
    {
        $this->noControl = $noControl;
    }

    public function getIdMateria()
    {
        return $this->idMateria;
    }

    public function setIdMateria($idMateria)
    {
        $this->idMateria = $idMateria;
    }
}
