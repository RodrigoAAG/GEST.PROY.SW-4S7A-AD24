<?php

namespace Models;

class Opcion
{
    private $idOpcion;
    private $idPregunta;
    private $textoOpcion;

    // Constructor con parámetros
    public function __construct($idOpcion = 0, $idPregunta = 0, $textoOpcion = '')
    {
        $this->idOpcion = $idOpcion;
        $this->idPregunta = $idPregunta;
        $this->textoOpcion = $textoOpcion;
    }

    // Getters y Setters
    public function getIdOpcion()
    {
        return $this->idOpcion;
    }

    public function setIdOpcion($idOpcion)
    {
        $this->idOpcion = $idOpcion;
    }

    public function getIdPregunta()
    {
        return $this->idPregunta;
    }

    public function setIdPregunta($idPregunta)
    {
        $this->idPregunta = $idPregunta;
    }

    public function getTextoOpcion()
    {
        return $this->textoOpcion;
    }

    public function setTextoOpcion($textoOpcion)
    {
        $this->textoOpcion = $textoOpcion;
    }
}
