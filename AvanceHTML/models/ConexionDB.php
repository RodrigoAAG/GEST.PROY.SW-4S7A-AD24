<?php

namespace Models;

class ConexionDB
{
    private $server;
    private $usuario;
    private $password;

    // Constructor con parámetros
    public function __construct($server = '', $usuario = '', $password = '')
    {
        $this->server = $server;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    // Getters y Setters
    public function getServer()
    {
        return $this->server;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
