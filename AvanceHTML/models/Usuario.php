<?php

namespace Models;

class Usuario
{
    private $noControl;
    private $nombre;
    private $apellidos;
    private $tipoDeCuenta;
    private $semestre;
    private $especialidad;
    private $contraseña;

    // Constructor con parámetros
    public function __construct(
        $noControl = '',
        $nombre = '',
        $apellidos = '',
        $tipoDeCuenta = '',
        $semestre = 0,
        $especialidad = '',
        $contraseña = ''
    ) {
        $this->noControl = $noControl;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->tipoDeCuenta = $tipoDeCuenta;
        $this->semestre = $semestre;
        $this->especialidad = $especialidad;
        $this->contraseña = $contraseña;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getTipoDeCuenta()
    {
        return $this->tipoDeCuenta;
    }

    public function setTipoDeCuenta($tipoDeCuenta)
    {
        $this->tipoDeCuenta = $tipoDeCuenta;
    }

    public function getSemestre()
    {
        return $this->semestre;
    }

    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;
    }

    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    }

    public function getContraseña()
    {
        return $this->contraseña;
    }

    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;
    }
}
