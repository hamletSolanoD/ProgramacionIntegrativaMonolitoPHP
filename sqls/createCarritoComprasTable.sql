CREATE TABLE carrito_compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    servicio_id INT NOT NULL,
    estado ENUM('en_proceso', 'comprado', 'expirado') NOT NULL DEFAULT 'en_proceso',
    tipo_plan ENUM('mensual', 'trimestral', 'anual') NOT NULL,
    fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_compra DATETIME NULL,
    fecha_expiracion DATETIME NULL,
    precio_compra DECIMAL(10,2) NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id),
    UNIQUE KEY unique_usuario_servicio (usuario_id, servicio_id, estado)
);



ALTER TABLE carrito_compras
DROP INDEX unique_usuario_servicio,
ADD UNIQUE KEY unique_usuario_servicio_activo (usuario_id, servicio_id, estado);