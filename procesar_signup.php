<?php
header('Content-Type: application/json');
require_once 'config/UsuarioDataBase.php';

try {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validaciones
    $errores = [];
    
    if (strlen($nombre) < 3) {
        $errores[] = "El nombre debe tener al menos 3 caracteres";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Email inválido";
    }
    
    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    if (!preg_match("/[A-Z]/", $password) || 
        !preg_match("/[a-z]/", $password) || 
        !preg_match("/[0-9]/", $password)) {
        $errores[] = "La contraseña debe contener mayúsculas, minúsculas y números";
    }
    
    if (!empty($errores)) {
        echo json_encode(['success' => false, 'message' => implode(", ", $errores)]);
        exit;
    }
    
    $db = getUsuarioDB();
    if ($db->registrarUsuario($nombre, $email, $password)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>