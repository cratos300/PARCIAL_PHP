<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once ("./entidades/clases.php");
include_once ("./entidades/usuario.php");
include_once ("./entidades/pizza.php");

use \Firebase\JWT\JWT;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Intervention\Image\ImageManager;



if($_SERVER['REQUEST_METHOD'] == 'GET'){
    switch ($_SERVER['PATH_INFO']) {
        case '/pizzas':
            $flag = true;
            $header = getallheaders();
            $miToken = $header["token"] ?? '';
            try {
                $key = "example_key";
                //$payload = array(
                //"nombre" => $user->nombre,
                //"tipo" => $user->tipo
            //);
            
            if($miToken != null)
            {
                $decode = JWT::decode($miToken,$key,array('HS256'));

                if($decode->tipo == "encargado")
                {
                    clases::EsEncargado("pizzas.json");
                }
                else{
                    clases::EsCliente("pizzas.json");
                }     
            }
            else{
                print_r("debe ingresar un token ");
            }
        }
            catch (\Throwable $th) {
                print_r($th->getMessage());
            }
          
            break;
        case '/ventas':        
        break;
        case '/image':          
        break;
        default:
            # code...
            break;
    }
}
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    switch ($_SERVER['PATH_INFO']) {
        case '/usuario':
            $email = isset($_POST['email']) ? $_POST['email'] : NULL;
            $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
            $user1 = new usuario($email,$clave,$tipo);
            $lista = clases::Guardar($user1,"archivos.json");
            if($lista>0)
            {
                echo "Se guardo correctamente";
            }
            //las regiones que funcionan son , ASIA OCEANIA Y AFRICA, el resto no funciona por problema del paquete.
            # code...
            break;
        case '/login':
            $email = isset($_POST['email']) ? $_POST['email'] : NULL;
            $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
            $user = clases::BuscarUsuario($email,$clave,"archivos.json");
            if($user!= null)
            {
                try {
                    $key = "example_key";
                    $payload = array(
                    "nombre" => $user->email,
                    "tipo" => $user->tipo
                );
                $jwt = JWT::encode($payload, $key);
               //$decoded = JWT::decode($payload, $key, array('HS256'));
                print_r($jwt);
                } catch (\Throwable $th) {
                   print_r($th->getMessage());
                }
            }
            else{
                echo "Usuario incorrecto";
            }
        break;
        case '/pizza':
            $flag = true;
            $header = getallheaders();
            $miToken = $header["token"] ?? '';
            try {
                $key = "example_key";
                //$payload = array(
                //"nombre" => $user->nombre,
                //"tipo" => $user->tipo
            //);
            
            if($miToken != null)
            {
                $decode = JWT::decode($miToken,$key,array('HS256'));

                if($decode->tipo == "encargado")
                {
                    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
                    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
                    $stock = isset($_POST['stock']) ? $_POST['stock'] : NULL;
                    $sabor = isset($_POST['sabor']) ? $_POST['sabor'] : NULL;
                    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;
                    $user = new pizza($tipo,$precio,$stock,$sabor,$foto);
                    $lista = clases::AgregarDatos($user,$foto);
                }
                else{
                    echo "no es encargado";
                }     
            }
            else{
                print_r("debe ingresar un token ");
            }
        }
            catch (\Throwable $th) {
                print_r($th->getMessage());
            }
               
            /*$flag = true;
            $header = getallheaders();
            $miToken = $header["token"] ?? '';
            try {
                $key = "example_key";
                //$payload = array(
                //"nombre" => $user->nombre,
                //"tipo" => $user->tipo
            //);
            if($miToken != null)
            {     
                $decode = JWT::decode($miToken,$key,array('HS256'));
                   if($decode->tipo == "admin")
                   {
                    $producto = isset($_POST['producto']) ? $_POST['producto'] : NULL;
                    $marca = isset($_POST['marca']) ? $_POST['marca'] : NULL;
                    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
                    $stock = isset($_POST['stock']) ? $_POST['stock'] : NULL;
                    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : NULL;
                  
                    $user = new productos($producto,$marca,$precio,$stock,$foto,rand(300,1000));
                    clases::SubirStock($user,$foto);
                   }
                   else{
                       echo "no es admin";
                   }
            }
            else{
                print_r("debe ingresar un token");
            }

        } 
        catch (\Throwable $th) {
            print_r($th->getMessage());
         }
           */
        break;  
        case '/ventas':
            $fecha = date('Y/m/d');
            $flag = true;
            $header = getallheaders();
            $miToken = $header["token"] ?? '';
            try {
                $key = "example_key";
                //$payload = array(
                //"nombre" => $user->nombre,
                //"tipo" => $user->tipo
            //);
            
            if($miToken != null)
            {
                $decode = JWT::decode($miToken,$key,array('HS256'));
                if($decode->tipo == "cliente")
                {
                    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
                    $sabor = isset($_POST['sabor']) ? $_POST['sabor'] : NULL;
                   
                    $resultado = clases::BuscarTIPOSABORR($tipo,$sabor,"pizzas.json");
                    if($resultado != null)
                    {
                        if($resultado->stock >0)
                        {
                            $unaVenta = new ventass($email,$tipo,$sabor,$resultado->precio,$fecha);
                            var_dump($resultado->precio);
                            
                            $devuelta = clases::ModificarStock("stock.json",$id_producto,$cantidad);
                            if($devuelta >0)
                            {
                                echo "Se modifico correctamente";
                            }
                            else
                            {
                                echo "No se modifico correctamente";
                            }
                        }
                        else
                        {
                            echo "Error, no hay stock suficiente";
                        }
                    }
                }
                else{
                    echo "no es usuario";
                }     
            }
            else{
                print_r("debe ingresar un token ");
            }
        }
            catch (\Throwable $th) {
                print_r($th->getMessage());
             }
        break;
        default:
            # code...
            break;
    }
}