<?php
namespace App\Utils;

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

    public static function pintarError(string $nomError){
        if(isset($_SESSION[$nomError])){
            echo "<p class='mt-1 italic text-red-600 text-sm'>$_SESSION[$nomError]</p>";
            unset($_SESSION[$nomError]);
        }
    }
}