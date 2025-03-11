<?php
session_start();
require_once 'config/CarritoDataBase.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $carritoDB = getCarritoDB();
    $items = $carritoDB->obtenerCarrito($_SESSION['usuario_id']);
    
    if (empty($items)) {
        throw new Exception("No hay items en el carrito");
    }

    // Procesar cada item del carrito
    foreach ($items as $item) {
        $carritoDB->realizarCompra($_SESSION['usuario_id'], $item['servicio_id']);
    }

    $_SESSION['success'] = "¡Compra realizada con éxito!";
    header('Location: mis-compras.php');
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Error al procesar la compra: " . $e->getMessage();
    header('Location: carrito.php');
    exit;
}
?>