<?php
session_start();
require_once 'config/CarritoDataBase.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar si se recibió el ID del servicio
if (!isset($_POST['servicio_id'])) {
    $_SESSION['error'] = "ID de servicio no especificado";
    header('Location: carrito.php');
    exit;
}

try {
    $carritoDB = getCarritoDB();
    $carritoDB->eliminarDelCarrito(
        $_SESSION['usuario_id'],
        $_POST['servicio_id']
    );
    
    $_SESSION['success'] = "Servicio eliminado del carrito exitosamente";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: carrito.php');
exit;
?>