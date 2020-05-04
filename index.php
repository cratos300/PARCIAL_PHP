<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once ("./entidades/clases.php");
include_once ("./entidades/usuario.php");
use \Firebase\JWT\JWT;
use NNV\RestCountries;
use Intervention\Image\ImageManager;
$contador = 0;
$restCountries = new RestCountries;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    switch ($_SERVER['PATH_INFO']) {
        case '/stock':
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
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
            $dni = isset($_POST['dni']) ? $_POST['dni'] : NULL;
            $obra_social = isset($_POST['obra_social']) ? $_POST['obra_social'] : NULL;
            $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
            $user1 = new usuario($nombre,$dni,$obra_social,$clave,$tipo,rand(0,300));
            $lista = clases::Guardar($user1,"archivos.json");
            if($lista>0)
            {
                echo "Se guardo correctamente";
            }
            //las regiones que funcionan son , ASIA OCEANIA Y AFRICA, el resto no funciona por problema del paquete.
            # code...
            break;
        case '/login':
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
            $user = clases::BuscarUsuario($id,$clave,"archivos.json");
            if($user!= null)
            {
                try {
                    $key = "example_key";
                    $payload = array(
                    "nombre" => $user->id,
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
        case '/stock':

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
            /*
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
                if($decode->tipo == "usuario")
                {
                    $id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : NULL;
                    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL;
                    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : NULL;
                    $resultado = clases::BuscarId($id_producto,"stock.json");
                    if($resultado != null)
                    {
                        if($resultado->stock >= $cantidad)
                        {
                            $unaVenta = new VentaUsuario($id_producto,$cantidad,$id_usuario,$resultado->precio,($cantidad*$resultado->precio));
                            var_dump($unaVenta);
                            clases::Serializarr($unaVenta,"ventas.txt");
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
             }*/
        break;
        default:
            # code...
            break;
    }
}