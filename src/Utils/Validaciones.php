<?php
namespace App\Utils;

use App\Bd\Producto;
use App\Bd\Usuario;

class Validaciones{
    public static function sanearCadenas(string $cad): string{
        return htmlspecialchars(trim($cad));
    }

    public static function longitudCampoValido(string $nomCampo, string $valorCampo, int $minTam, int $maxTam): bool{
        if(strlen($valorCampo)<$minTam || strlen($valorCampo)>$maxTam){
            $_SESSION["err_$nomCampo"]="*** Error el tamaño de $nomCampo debe estar entre $minTam y $maxTam";
            return false;
        }
        return true;
    }

    public static function isPrecioValido(float $valor): bool{
        if($valor<1 || $valor>9999.99){
            $_SESSION['err_precio']="*** Error el precio debe estar entre 1 y 9999.99";
            return false;
        }
        return true;
    }

    public static function isLoginValido(string $usu, string $pass): bool{
            if(!Usuario::loginValido($usu, $pass)){
                $_SESSION['err_login']="*** Usuario o contraseña incorrectos.";
                return false;
            }
            return true;
    }

    public static function existeUsuario(string $nombre): bool{
        if(Usuario::existeUsuario($nombre)){
            $_SESSION['err_username']="*** Error, ya existe un usuario con este nombre.";
            return true;
        }
        return false;
    }
    public static function existeProducto(string $nombre): bool{
        if(Producto::existeProducto($nombre)){
            $_SESSION['err_nombre']="*** Error el nombre de producto YA existe";
            return true;
        }
        return false;
    }

    public static function imageValida(string $tipo, int $size): bool{
        $imageMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
            'image/x-windows-bmp',
            'image/tiff',
            'image/x-icon',  // Íconos .ico
            'image/svg+xml', // SVG
            'image/heic',    // Alta eficiencia, usado en dispositivos Apple
            'image/heif'     // Formato similar a HEIC
        ];
        if(!in_array($tipo, $imageMimeTypes) || $size>2_097_152){
            $_SESSION['err_imagen']="*** Error se esperaba un archivo de imagen que no exceda los 2 MB";
            return false;
        }
        return true;

    }

    public static function pintarError(string $nomError){
        if(isset($_SESSION[$nomError])){
            echo "<p class='mt-1 italic text-red-600 text-sm'>$_SESSION[$nomError]</p>";
            unset($_SESSION[$nomError]);
        }
    }
}