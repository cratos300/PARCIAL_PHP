<?php

class usuario
{   
    public $nombre;
    public $dni;
    public $obra_social;
    public $clave;
    public $tipo;
    public $id;

    function __construct($nombre,$dni,$obra_social,$clave,$tipo,$id)
    {   
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->obra_social = $obra_social;
        $this->clave = $clave;
        $this->tipo = $tipo;
        $this->id = $id;
    }
}