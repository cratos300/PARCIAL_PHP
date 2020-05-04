<?php

class usuario
{   
    public $email;
    public $clave;
    public $tipo;
    function __construct($email,$clave,$tipo)
    {   
        $this->email = $email;
        $this->clave = $clave;
        $this->tipo = $tipo;
    }
}