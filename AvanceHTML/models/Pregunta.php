<?php

namespace Models;

class Pregunta
{
    private $idPregunta;
    private $idQuiz;
    private $textoPregunta;
    private $respuestaCorrecta;

    // Constructor con parámetros
    public function __construct($idPregunta = 0, $idQuiz = 0, $textoPregunta = '', $respuestaCorrecta = 0)
    {
        $this->idPregunta = $idPregunta;
        $this->idQuiz = $idQuiz;
        $this->textoPregunta = $textoPregunta;
        $this->respuestaCorrecta = $respuestaCorrecta;
    }

    // Getters y Setters
    public function getIdPregunta()
    {
        return $this->idPregunta;
    }

    public function setIdPregunta($idPregunta)
    {
        $this->idPregunta = $idPregunta;
    }

    public function getIdQuiz()
    {
        return $this->idQuiz;
    }

    public function setIdQuiz($idQuiz)
    {
        $this->idQuiz = $idQuiz;
    }

    public function getTextoPregunta()
    {
        return $this->textoPregunta;
    }

    public function setTextoPregunta($textoPregunta)
    {
        $this->textoPregunta = $textoPregunta;
    }

    public function getRespuestaCorrecta()
    {
        return $this->respuestaCorrecta;
    }

    public function setRespuestaCorrecta($respuestaCorrecta)
    {
        $this->respuestaCorrecta = $respuestaCorrecta;
    }
}
