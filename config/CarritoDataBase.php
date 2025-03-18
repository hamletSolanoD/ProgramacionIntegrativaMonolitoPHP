<?php
class CarritoDataBase
{
    private $host = "localhost";
    private $db_name = "monolitoEComerce";
    private $username = "root";
    private $password = "root123";
    private $conn = null;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new Exception("Error de conexión: " . $exception->getMessage());
        }
    }

    public function agregarAlCarrito($usuario_id, $servicio_id, $tipo_plan)
    {
        try {
            // Verificar si ya existe en el carrito
            $query = "SELECT * FROM carrito_compras 
                     WHERE usuario_id = :usuario_id 
                     AND servicio_id = :servicio_id 
                     AND estado = 'en_proceso'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                throw new Exception("Este servicio ya está en tu carrito");
            }

            // Agregar al carrito
            $query = "INSERT INTO carrito_compras (usuario_id, servicio_id, tipo_plan) 
                     VALUES (:usuario_id, :servicio_id, :tipo_plan)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->bindParam(":tipo_plan", $tipo_plan, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $exception) {
            throw new Exception("Error al agregar al carrito: " . $exception->getMessage());
        }
    }

    public function obtenerCarrito($usuario_id)
    {
        try {
            $query = "SELECT c.*, s.nombre, s.descripcion, 
                     CASE c.tipo_plan 
                        WHEN 'mensual' THEN s.precio_por_mes
                        WHEN 'trimestral' THEN s.precio_por_trimestre
                        WHEN 'anual' THEN s.precio_por_anio
                     END as precio
                     FROM carrito_compras c
                     JOIN servicios s ON c.servicio_id = s.id
                     WHERE c.usuario_id = :usuario_id 
                     AND c.estado = 'en_proceso'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new Exception("Error al obtener carrito: " . $exception->getMessage());
        }
    }

    public function eliminarDelCarrito($usuario_id, $servicio_id)
    {
        try {
            $query = "DELETE FROM carrito_compras 
                     WHERE usuario_id = :usuario_id 
                     AND servicio_id = :servicio_id 
                     AND estado = 'en_proceso'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $exception) {
            throw new Exception("Error al eliminar del carrito: " . $exception->getMessage());
        }
    }
    public function obtenerCompras($usuario_id)
    {
        try {
            $query = "SELECT c.*, s.nombre, s.descripcion 
                      FROM carrito_compras c
                      JOIN servicios s ON c.servicio_id = s.id
                      WHERE c.usuario_id = :usuario_id 
                      AND c.estado = 'comprado'
                      ORDER BY c.fecha_compra DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new Exception("Error al obtener compras: " . $exception->getMessage());
        }
    }

    public function verificarServicioActivo($usuario_id, $servicio_id)
    {
        try {
            $query = "SELECT * FROM carrito_compras 
                      WHERE usuario_id = :usuario_id 
                      AND servicio_id = :servicio_id 
                      AND (estado = 'comprado' OR estado = 'en_proceso')
                      AND (fecha_expiracion IS NULL OR fecha_expiracion > CURRENT_TIMESTAMP)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new Exception("Error al verificar servicio: " . $exception->getMessage());
        }
    }


    public function realizarCompra($usuario_id, $servicio_id)
    {
        try {
            $this->conn->beginTransaction();

            // Obtener información del servicio y el carrito
            $query = "SELECT c.*, s.precio_por_mes, s.precio_por_trimestre, s.precio_por_anio 
                     FROM carrito_compras c
                     JOIN servicios s ON c.servicio_id = s.id
                     WHERE c.usuario_id = :usuario_id 
                     AND c.servicio_id = :servicio_id 
                     AND c.estado = 'en_proceso'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);
            $stmt->execute();

            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$item) {
                throw new Exception("Servicio no encontrado en el carrito");
            }

            // Calcular precio y fecha de expiración
            $precio = 0;
            $meses = 0;
            switch ($item['tipo_plan']) {
                case 'mensual':
                    $precio = $item['precio_por_mes'];
                    $meses = 1;
                    break;
                case 'trimestral':
                    $precio = $item['precio_por_trimestre'];
                    $meses = 3;
                    break;
                case 'anual':
                    $precio = $item['precio_por_anio'];
                    $meses = 12;
                    break;
            }

            $fecha_expiracion = date('Y-m-d H:i:s', strtotime("+$meses months"));

            // Actualizar el estado a comprado
            $query = "UPDATE carrito_compras 
                     SET estado = 'comprado',
                         fecha_compra = CURRENT_TIMESTAMP,
                         fecha_expiracion = :fecha_expiracion,
                         precio_compra = :precio
                     WHERE usuario_id = :usuario_id 
                     AND servicio_id = :servicio_id 
                     AND estado = 'en_proceso'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":fecha_expiracion", $fecha_expiracion);
            $stmt->bindParam(":precio", $precio);
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(":servicio_id", $servicio_id, PDO::PARAM_INT);

            $stmt->execute();
            $this->conn->commit();

            return true;
        } catch (Exception $exception) {
            $this->conn->rollBack();
            throw new Exception("Error al realizar la compra: " . $exception->getMessage());
        }
    }
}

function getCarritoDB()
{
    try {
        static $db = null;
        if ($db === null) {
            $db = new CarritoDataBase();
        }
        return $db;
    } catch (Exception $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
