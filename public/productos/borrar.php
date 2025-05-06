<?php

use App\Bd\Producto;
use App\Bd\Usuario;

session_start();
require_once __DIR__."/../../vendor/autoload.php";
//comprobaremos que para estar aqui estemos logeados
//y hayamos mandado por post un id con el producto a borrar
function salir(){
    header("Location:index.php");
    exit;
}
$id=filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if(!$id || !isset($_SESSION['username'])){
    salir();
}

//estoy logeado y he mandado un id seguimos
$user_id=Usuario::getAuthUserId($_SESSION['username']);
if(!Producto::authorize($user_id, $id)){
    $_SESSION['error']="Error NO autorizado";
    salir();
}
//si estoy aqui podemos borrar el producto sin miedo
$imagen=Producto::show($id)[0]->imagen;
Producto::delete($id);
//Una vez borrado el producto sin problema borro la imagen si no es la default
if(basename($imagen)!='default.png'){ //$imagen ='/img/nombre.jpg'
    unlink(__DIR__."/..".$imagen);
}
$_SESSION['mensaje']="Producto Borrado.";
salir();

