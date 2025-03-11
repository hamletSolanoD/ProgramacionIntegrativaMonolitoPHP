<?php
require_once 'config/UsuarioDataBase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (!$nombre || !$email || !$password) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        $db = getUsuarioDB();
        $db->registrarUsuario($nombre, $email, $password);

        header("Location: login.php?status=registered");
        exit();
    } catch (Exception $e) {
        header("Location: signup.php?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>