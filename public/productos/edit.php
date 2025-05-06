<?php
function salir(){
    header("Location:index.php");
    exit;
}
use App\Bd\Producto;
use App\Bd\Usuario;
use App\Utils\Validaciones;

session_start();
require_once __DIR__ . "/../../vendor/autoload.php";

$id=filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if(!$id || !isset($_SESSION['username'])){
    salir();
}

//estoy logeado y he mandado un id seguimos comprobando que el usuario sea el 
//propietario del producto a actualizar 
$user_id=Usuario::getAuthUserId($_SESSION['username']);
if(!Producto::authorize($user_id, $id)){
    $_SESSION['error']="Error NO autorizado";
    salir();
}

//Todo esta bien recupero los datos del producto a actualizar
$producto=Producto::show($id)[0];

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
        if(Validaciones::existeProducto($nombre, $id)) $errores=true;
    }
    if (!Validaciones::isPrecioValido($precio)) {
        $errores = true;
    }
    //Procesamos la simpática imagen del producto
    $imagen = $producto->imagen;
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
        header("Location:edit.php?id=$id");
        exit;    
    }
    //todo ha ido bien actualizamos el producto
    Producto::update($id, $nombre, $precio, $imagen);
    //Borro la imagten anterior siempre y cuando se haya cambiado y la vieja no fuera la default
    if($imagen!=$producto->imagen){
        //he subido una imagen comrpueba que no sea la default
        if(basename($producto->imagen)!='default.png'){
            unlink("./..".$producto->imagen);
        }
    }

    $_SESSION['mensaje']="Producto editado";
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
    <title>Editar</title>
</head>

<body>
    <?php
    include __DIR__ . "/../../layouts/nav1.php";
    ?>
    <!-- Formulario prodctos -->
    <div class="w-1/2 p-8 rounded-xl shadow-xl border-2 border-slate-300 mx-auto bg-gray-100 mt-4">
        <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <!-- Nombre -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-user text-gray-500"></i>
                <input type="text" name="nombre" value="<?= $producto->nombre ?>" 
                placeholder="Nombre" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            </div>
            <?php
            Validaciones::pintarError('err_nombre');
            ?>


            <!-- Precio -->
            <div class="flex items-center space-x-2 mt-4">
                <i class="fas fa-align-left text-gray-500"></i>
                <input type="number" step="0.01" name="precio" value="<?= $producto->precio ?>" 
                 placeholder="Precio" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" />
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
                <img id="preview" class="w-20 h-20 object-cover object-center rounded-md ml-4" src="<?= "./..".$producto->imagen ?>" />
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