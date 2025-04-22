<?php

use App\Utils\Validaciones;

    session_start();
    require_once __DIR__."/../vendor/autoload.php";

    if(isset($_POST['username'])){
        $usuario=Validaciones::sanearCadenas($_POST['username']);
        $pass=Validaciones::sanearCadenas($_POST['password']);

        if(!Validaciones::isLoginValido($usuario, $pass)){
            header("location:login.php");
            exit;
        }
        //Login correcto
        $_SESSION['username']=$usuario;
        header("Location:./productos/");
        exit;
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
    <title>Login</title>
</head>

<body>
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-600 py-4 px-6">
                    <h1 class="text-2xl font-bold text-white text-center">
                        <i class="fas fa-user-circle mr-2"></i> Iniciar Sesión
                    </h1>
                </div>

                <!-- Form -->
                <form class="p-6 space-y-6" action="login.php" method="POST">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-user mr-2 text-blue-500"></i> Usuario
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingrese su usuario">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-lock mr-2 text-blue-500"></i> Contraseña
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ingrese su contraseña">
                    </div>
                    <?php
                        Validaciones::pintarError('err_login');
                    ?>
                    <!-- Buttons Container -->
                    <div class="flex space-x-4">
                        <!-- Login Button -->
                        <button
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </button>

                        <!-- Cancel Button -->
                        <a
                            href="index.php"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md text-center transition duration-300">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                    </div>
                </form>

                <!-- Footer Links -->
                <div class="bg-gray-50 px-6 py-4 text-center">

                    <p class="mt-2 text-sm text-gray-600">
                        ¿No tienes cuenta? <a href="register.php" class="text-blue-600 hover:underline">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>

</html>