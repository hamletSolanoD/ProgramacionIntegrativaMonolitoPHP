<?php
class UsuarioDataBase {
    private $host = "localhost";
    private $db_name = "monolitoEComerce";
    private $username = "root";
    private $password = "";
    private $conn = null;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
    }

    public function registrarUsuario($nombre, $email, $password, $tipo = 'comprador') {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO usuarios (nombre, email, password, tipo) 
                      VALUES (:nombre, :email, :password, :tipo)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch(PDOException $exception) {
            throw new Exception("Error al registrar usuario: " . $exception->getMessage());
        }
    }

    public function iniciarSesion($email, $password) {
        try {
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($password, $usuario['password'])) {
                return $usuario;
            }
            return null;
        } catch(PDOException $exception) {
            throw new Exception("Error al iniciar sesión: " . $exception->getMessage());
        }
    }

    public function obtenerUsuarioPorId($id) {
        try {
            $query = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener usuario: " . $exception->getMessage());
        }
    }
}

function getUsuarioDB() {
    static $db = null;
    if ($db === null) {
        $db = new UsuarioDataBase();
    }
    return $db;
}
?>