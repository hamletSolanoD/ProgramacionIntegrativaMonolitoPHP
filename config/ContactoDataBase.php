<?php
class ContactoDataBase {
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

    public function guardarContacto($datos) {
        try {
            $query = "INSERT INTO contactos (nombre, email, asunto, mensaje, ip_remitente) 
                     VALUES (:nombre, :email, :asunto, :mensaje, :ip)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
            $stmt->bindParam(":asunto", $datos['asunto'], PDO::PARAM_STR);
            $stmt->bindParam(":mensaje", $datos['mensaje'], PDO::PARAM_STR);
            $stmt->bindParam(":ip", $datos['ip'], PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch(PDOException $exception) {
            throw new Exception("Error al guardar contacto: " . $exception->getMessage());
        }
    }

    public function obtenerContactos($estado = null, $limit = 10, $offset = 0) {
        try {
            $query = "SELECT * FROM contactos ";
            if ($estado) {
                $query .= "WHERE estado = :estado ";
            }
            $query .= "ORDER BY fecha_creacion DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->conn->prepare($query);
            
            if ($estado) {
                $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            }
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener contactos: " . $exception->getMessage());
        }
    }

    public function obtenerContactoPorId($id) {
        try {
            $query = "SELECT * FROM contactos WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener contacto: " . $exception->getMessage());
        }
    }

    public function actualizarEstadoContacto($id, $estado, $notas = null) {
        try {
            $query = "UPDATE contactos 
                     SET estado = :estado, 
                         notas_internas = CASE 
                             WHEN :notas IS NOT NULL THEN :notas 
                             ELSE notas_internas 
                         END,
                         fecha_respuesta = CASE 
                             WHEN :estado = 'respondido' THEN CURRENT_TIMESTAMP 
                             ELSE fecha_respuesta 
                         END
                     WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            $stmt->bindParam(":notas", $notas, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch(PDOException $exception) {
            throw new Exception("Error al actualizar estado: " . $exception->getMessage());
        }
    }

    public function contarContactos($estado = null) {
        try {
            $query = "SELECT COUNT(*) FROM contactos";
            if ($estado) {
                $query .= " WHERE estado = :estado";
            }
            
            $stmt = $this->conn->prepare($query);
            if ($estado) {
                $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch(PDOException $exception) {
            throw new Exception("Error al contar contactos: " . $exception->getMessage());
        }
    }

    public function marcarComoLeido($id) {
        try {
            $query = "UPDATE contactos SET leido = TRUE WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch(PDOException $exception) {
            throw new Exception("Error al marcar como leído: " . $exception->getMessage());
        }
    }
}

/**
 * Función auxiliar para obtener una instancia de la base de datos de contactos
 * @return ContactoDataBase Instancia de la clase ContactoDataBase
 */
function getContactoDB() {
    try {
        static $db = null;
        if ($db === null) {
            $db = new ContactoDataBase();
        }
        return $db;
    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>