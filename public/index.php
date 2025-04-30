<?php
session_start();
use App\Bd\Producto;

    require_once __DIR__."/../vendor/autoload.php";
    $productos=Producto::readAll();

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
    <title>Inicio</title>
</head>

<body>
    <?php
    include __DIR__ . "/../layouts/nav.php";
    ?>
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Nuestros Productos</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($productos as $item): ?>
            <!-- Product Card 1 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative h-48 overflow-hidden">
                    <img src="<?= ".$item->imagen" ?>"
                        alt="<?= $item->nombre ?>"
                        class="w-full h-full object-cover object-center">
                 
                </div>

                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= $item->nombre ?></h3>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-lg font-bold text-indigo-600"><?= $item->precio ?></span>

                    </div>

                    <div class="flex items-center justify-between border-t pt-3">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                            <span class="text-sm text-gray-600"><?= $item->username ?></span>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>