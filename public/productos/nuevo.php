<?php

use App\Bd\Producto;
use App\Bd\Usuario;
use App\Utils\Validaciones;

session_start();
$username = $_SESSION['username'] ?? null;

if (!$username) {
    header("Location:../");
    exit;
}
require_once __DIR__ . "/../../vendor/autoload.php";
//si estamos aqui es pq estamos logeado, recupero el id de usuario logeado
$user_id = Usuario::getAuthUserId($username);

//Procesamos el form
if (isset($_POST['nombre'])) {
    //1.- Recojo y limpio cadenas
    $nombre = Validaciones::sanearCadenas($_POST['nombre']);
    $precio = (float) Validaciones::sanearCadenas($_POST['precio']);

    //2.- Validamos
    $errores = false;
    if (!Validaciones::longitudCampoValido('nombre', $nombre, 3, 55)) {
        $errores = true;
    }else{
        if(Validaciones::existeProducto($nombre)) $errores=true;
    }
    if (!Validaciones::isPrecioValido($precio)) {
        $errores = true;
    }
    //Procesamos la simpática imagen del producto
    $imagen = '/img/default.png';
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
        //se ha subido un archivo, comprobaremos que sea una imagen y que no exceda de un tamaño
        if (!Validaciones::imageValida($_FILES['imagen']['type'], $_FILES['imagen']['size'])) {
            $errores = true;
        } else {
            //el archivo que emps pasado es correcto, procedemos a guardarlo
            $imagen = "/img/" . uniqid() . "_" . $_FILES['imagen']['name']; // "/img/1234923_nombre.jpg"
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], "..$imagen")) {
                //no se ha podido mover el archivo de la carpeta temporal
                // a la ruta deseada, normalmente por problemas o de permisos o ruta mal
                $errores = true;
                $_SESSION['err_imagen'] = "*** La imagen se subio pero NO se ha podido guardar";
            }
        }
    }

    if ($errores) {
        header("Location:nuevo.php");
        exit;
    }
    //todo ha ido bien gardamos el producto
    (new Producto)
        ->setNombre($nombre)
        ->setPrecio($precio)
        ->setImagen($imagen)
        ->setUserId($user_id)
        ->create();
    $_SESSION['mensaje']="Nuevo producto guardado";
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwind css-->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- CDN Sweet alert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--CDN Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Nuevo</title>
</head>

<body>
    <?php
    include __DIR__ . "/../../layouts/nav1.php";
    ?>
    <!-- Formulario prodctos -->
    <div class="w-1/2 p-8 rounded-xl shadow-xl border-2 border-slate-300 mx-auto bg-gray-100 mt-4">
        <form action="nuevo.php" method="POST" enctype="multipart/form-data">
            <!-- Nombre -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-user text-gray-500"></i>
                <input type="text" name="nombre" placeholder="Nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            </div>
            <?php
            Validaciones::pintarError('err_nombre');
            ?>


            <!-- Precio -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-align-left text-gray-500"></i>
                <input type="number" step="0.01" name="precio" placeholder="Precio" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" />
            </div>
            <?php
            Validaciones::pintarError('err_precio');
            ?>


            <!-- Imagen -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-image text-gray-500"></i>
                <input
                    type="file"
                    name="imagen"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                    oninput="preview.src=window.URL.createObjectURL(this.files[0])">
                <img id="preview" class="w-20 h-20 object-cover object-center rounded-md ml-4" />
            </div>
            <?php
            Validaciones::pintarError('err_imagen');
            ?>


            <!-- Botones -->
            <div class="flex space-x-4 mt-4">
                <a href="index.php" class="px-4 py-2 bg-gray-500 text-white rounded-md text-center hover:bg-gray-600">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-center hover:bg-blue-600">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</body>

</html>