<?php

use App\Bd\Producto;

session_start();
$username = $_SESSION['username'] ?? null;

if (!$username) {
    header("Location:../");
    exit;
}
require_once __DIR__ . "/../../vendor/autoload.php";
$productos = Producto::read($username);


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
    <title>Productos</title>
</head>

<body>
    <?php
    include __DIR__ . "/../../layouts/nav1.php";
    ?>
    <h1 class="text-xl py-2 text-center"><?= "Productos de: $username" ?></h1>
    <div class="w-1/2 p2 mx-auto flex flex-row-reverse">
        <a href="nuevo.php" class="p-2 bg-blue-400 hover:bg-blue-600 rounded-lg text-white font-bold">
            <i class="fas fa-add mr-1"></i>Nuevo
        </a>
    </div>
    <?php if (count($productos)): ?>
        <!-- Pinto los prudctoas del usuario en una tabla -->
        <div class="w-1/2 p2 mx-auto mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            PRECIO (€)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $item): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <img src="<?= "..$item->imagen" ?>" class="w-16 md:w-32 max-w-full max-h-full" alt="<?= $item->nombre ?>">
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?= $item->nombre ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?= $item->precio ?>
                            </td>
                            <td class="px-6 py-4">
                                <form action="borrar.php" method="POST">
                                    
                                    <input type="hidden" name="id" value="<?= $item->id ?>" />
                                    <a href="edit.php?id=<?= $item->id ?>">
                                        <i class="fas fa-edit text-green-500 text-lg mr-2"></i>
                                    </a>
                                    <button type="submit">
                                        <i class="fas fa-trash text-lg text-red-600"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <!-- El usuario NO tiene productos, le digo que cree alguno -->
        <div class="mt-10 p-8 rounded-xl shadow-xl text-white bg-black w-1/2 mx-auto">
            No tiene nigún producto, aprovecha para crear alguno.
        </div>
    <?php endif; ?>
    <?php
    if (isset($_SESSION['error'])) {
        echo <<<TXT
            <script>
                Swal.fire({
                icon: "error",
                title: "No autorizado!!!",
                showConfirmButton: true
                });
            </script>
            TXT;
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
            <script>
                Swal.fire({
                icon: "success",
                title: "{$_SESSION['mensaje']}",
                showConfirmButton: true
                });
            </script>
            TXT;
        unset($_SESSION['mensaje']);
    }
    ?>
</body>

</html>