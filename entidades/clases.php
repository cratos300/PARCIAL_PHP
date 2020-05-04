<?php

class clases  
{   
    public static function Guardar($obj,$donde)
    {
        $bandera = false;
        $array = clases::listarTodos($donde);
        $archivo = fopen("./entidades/".$donde,"w");
        array_push($array,$obj);
        $json_string = json_encode($array);
        //$cant = fwrite($archivo,$nombre. "-". $apellido. "-" .$legajo. PHP_EOL);
         $cant = fwrite($archivo,$json_string);
        if($cant>0)
        {
            $bandera = true;
        }
        fclose($archivo);

        return $bandera;
    }
    public static function listarTodos($donde)
    {
        $archivo = fopen("./entidades/".$donde,"r");
        $dato = fread($archivo,filesize("./entidades/".$donde));
        fclose($archivo);
        return json_decode($dato);
    }
    
    public static function BuscarUsuario($email,$clave,$path){
        $Nuevo_Usuario = null;
        $lista = clases::listarTodos($path);
        foreach ($lista as $key => $value) {
            if($value->email ==  $email &&  $value->clave == $clave){
                $Nuevo_Usuario = new usuario($value->email,$value->clave,$value->tipo);
            }
        }
        return $Nuevo_Usuario;
    }
    
    public static function AgregarDatos($obj,$foto)
    {
        $devolver = clases::ValidarTipoSabor($obj);
        if($devolver == false)
        {
            $azar = rand(0,200);
            $origen = $_FILES['foto']['tmp_name'];
            $explode = explode('.',$_FILES['foto']['name']);
            $destino = "./entidades/img/".$explode[0].$azar.".".$explode[1];
            clases::Guardar($obj,"pizzas.json");
            move_uploaded_file($origen,$destino);
        }
        else
        {
            echo "Error no se pudo cargar los datos, tipo y sabor existintes";
        }

    }
    public static function ValidarTipoSabor($obj)
    {
        $flag = false;
        $lista = clases::listarTodos("pizzas.json");
        var_dump($obj);
        for($i=0;$i<count($lista);$i++)
        {
            if($lista[$i]->tipo == $obj->tipo && $lista[$i]->sabor == $obj->sabor)
            {
                $flag = true;
                 break;
            }
        }
        return $flag;
    }
    public static function EsEncargado($donde)
    {
        $array = clases::listarTodos($donde);
        for($i=0;$i<count($array);$i++)
        {
            echo "tipo:".$array[$i]->tipo ."<br>" ."precio:".$array[$i]->precio. "<br>"."stock:".$array[$i]->stock ."<br>". "sabor:".$array[$i]->sabor ."<br>". "foto:".$array[$i]->foto;
        }
    }
    public static function EsCliente($donde)
    {
        $array = clases::listarTodos($donde);
        for($i=0;$i<count($array);$i++)
        {
            echo "tipo:".$array[$i]->tipo ."<br>" . "precio:".$array[$i]->precio. "<br>". "sabor:".$array[$i]->sabor ."<br>"."foto:".$array[$i]->foto;
        }
    }
    public static function BuscarTIPOSABORR($tipo,$sabor,$donde)
    {
        $array = clases::listarTodos($donde);
        $flag = false;
        for($i=0;$i<count($array);$i++)
        {
            if($array->tipo == $tipo && $array->sabor == $sabor)
            {
                $flag = true;
            }
        }
        return $flag;
    }
    /*
    public static function BuscarID($id,$path)
    {
        $productos = clases::listarTodos($path);
        $encontrado = null;
        for($i=0;$i<count($productos);$i++)
        {
            if($productos[$i]->id == $id)
            {
                $encontrado = $productos[$i];
                break;
            }
        }
        return $encontrado;
    }

    public static function ModificarStock($path,$id,$cantidad)
    {
        $flag = -1;
        $objetos = clases::listarTodos($path);
     for($i=0;$i<count($objetos);$i++)
     {
        if($objetos[$i]->id == $id)
        {
            $objetos[$i]->stock = $objetos[$i]->stock - $cantidad;
        break;
        }
     }
    
     $archivo = fopen("./entidades/".$path,"w");
     $json_string = json_encode($objetos);
        //$cant = fwrite($archivo,$nombre. "-". $apellido. "-" .$legajo. PHP_EOL);
         $cant = fwrite($archivo,$json_string);
         if($cant > 0)
         {
             $flag = 1;
         }
        return $flag;
    }
    public static function MostrarSoloId($id)
    {
        $datas = clases::Deserializarr("ventas.txt");
        foreach ($datas as $key => $value) {
            if($value->idusuario == $id)
            {
                var_dump($value);
            }
        }
    }*/

}
