<?php
class Database {
    private $host = "localhost";
    private $db_name = "monolitoEComerce";
    private $username = "root";
    private $password = "";
    private $conn = null;
    
    // Constructor que establece la conexión al instanciar la clase
    public function __construct() {
        $this->connect();
    }
    
    // Método privado para establecer la conexión
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
    
    // Método público para obtener la conexión
    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }
    
    public function getServiciosActivos() {
        try {
            if ($this->conn === null) {
                $this->connect();
            }
            
            $query = "SELECT * FROM servicios 
                     WHERE activo = 1 
                     AND (fecha_disponibilidad_inicio IS NULL OR fecha_disponibilidad_inicio <= CURDATE())
                     AND (fecha_disponibilidad_fin IS NULL OR fecha_disponibilidad_fin >= CURDATE())
                     ORDER BY nombre ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener servicios: " . $exception->getMessage());
        }
    }
    
    public function getServiciosDestacados($limit = 3) {
        try {
            if ($this->conn === null) {
                $this->connect();
            }
            
            $query = "SELECT * FROM servicios 
                     WHERE activo = 1 
                     AND (fecha_disponibilidad_inicio IS NULL OR fecha_disponibilidad_inicio <= CURDATE())
                     AND (fecha_disponibilidad_fin IS NULL OR fecha_disponibilidad_fin >= CURDATE())
                     ORDER BY RAND() 
                     LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener servicios destacados: " . $exception->getMessage());
        }
    }
    
    public function getServicioPorId($id) {
        try {
            if ($this->conn === null) {
                $this->connect();
            }
            
            $query = "SELECT * FROM servicios WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $servicio = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($servicio) {
                $hoy = date('Y-m-d');
                $inicio = $servicio['fecha_disponibilidad_inicio'];
                $fin = $servicio['fecha_disponibilidad_fin'];
                
                $servicio['fuera_de_servicio'] = ($inicio && $inicio > $hoy) || ($fin && $fin < $hoy);
            }
            
            return $servicio;
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener servicio: " . $exception->getMessage());
        }
    }
    
    public function getServiciosPorCategoria($categoria) {
        try {
            if ($this->conn === null) {
                $this->connect();
            }
            
            $query = "SELECT * FROM servicios 
                     WHERE categoria = :categoria 
                     AND activo = 1 
                     AND (fecha_disponibilidad_inicio IS NULL OR fecha_disponibilidad_inicio <= CURDATE())
                     AND (fecha_disponibilidad_fin IS NULL OR fecha_disponibilidad_fin >= CURDATE())
                     ORDER BY nombre ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener servicios por categoría: " . $exception->getMessage());
        }
    }
    
    public function getCategorias() {
        try {
            if ($this->conn === null) {
                $this->connect();
            }
            
            $query = "SELECT DISTINCT categoria FROM servicios WHERE activo = 1 ORDER BY categoria ASC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $categorias = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorias[] = $row['categoria'];
            }
            
            return $categorias;
        } catch(PDOException $exception) {
            throw new Exception("Error al obtener categorías: " . $exception->getMessage());
        }
    }
}

function getDatabase() {
    try {
        static $db = null;
        if ($db === null) {
            $db = new Database();
        }
        return $db;
    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
?>