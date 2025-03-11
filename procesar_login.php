<?php
require_once 'config/UsuarioDataBase.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (!$email || !$password) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        $db = getUsuarioDB();
        $usuario = $db->iniciarSesion($email, $password);

        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Credenciales incorrectas.");
        }
    } catch (Exception $e) {
        header("Location: login.php?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>