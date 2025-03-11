CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'comprador') DEFAULT 'comprador',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);