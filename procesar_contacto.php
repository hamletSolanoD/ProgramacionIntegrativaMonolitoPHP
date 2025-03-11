<?php
require_once 'config/ContactoDataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validar datos
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $asunto = filter_input(INPUT_POST, 'asunto', FILTER_SANITIZE_STRING);
        $mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING);
        
        if (!$nombre || !$email || !$asunto || !$mensaje) {
            throw new Exception("Todos los campos son obligatorios");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo electrónico no es válido");
        }
        
        // Preparar datos para guardar
        $datos = [
            'nombre' => $nombre,
            'email' => $email,
            'asunto' => $asunto,
            'mensaje' => $mensaje,
            'ip' => $_SERVER['REMOTE_ADDR']
        ];
        
        // Guardar en la base de datos
        $db = getContactoDB();
        $resultado = $db->guardarContacto($datos);
        
        if ($resultado) {
            // Aquí podrías agregar el envío de correo de confirmación
            
            // Redirigir con mensaje de éxito
            header("Location: contacto.php?status=success");
            exit();
        } else {
            throw new Exception("Error al guardar el mensaje");
        }
        
    } catch (Exception $e) {
        header("Location: contacto.php?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: contacto.php");
    exit();
}
?>