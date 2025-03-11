<?php
session_start();
require_once 'config/CarritoDataBase.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $carritoDB = new CarritoDataBase();
        
        // Verificar si ya tiene el servicio
        $servicioActivo = $carritoDB->verificarServicioActivo(
            $_SESSION['usuario_id'], 
            $_POST['servicio_id']
        );
        
        if ($servicioActivo) {
            if ($servicioActivo['estado'] === 'comprado') {
                throw new Exception("Ya tienes este servicio activo");
            } else {
                throw new Exception("Este servicio ya está en tu carrito");
            }
        }
        
        // Si no tiene el servicio, proceder a agregarlo al carrito
        $carritoDB->agregarAlCarrito(
            $_SESSION['usuario_id'],
            $_POST['servicio_id'],
            $_POST['tipo_plan']
        );
        
        header('Location: carrito.php?success=1');
        exit;
    } catch (Exception $e) {
        header('Location: servicios.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}

header('Location: servicios.php');
exit;
?>