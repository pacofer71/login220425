<?php
namespace App\Utils;

use App\Bd\Usuario;

class Validaciones{
    public static function sanearCadenas(string $cad): string{
        return htmlspecialchars(trim($cad));
    }

    public static function isLoginValido(string $usu, string $pass): bool{
            if(!Usuario::loginValido($usu, $pass)){
                $_SESSION['err_login']="*** Usuario o contraseña incorrectos.";
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