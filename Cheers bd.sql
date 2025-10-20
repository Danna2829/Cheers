CREATE DATABASE Cheers;
USE Cheers;

-- Tipos de productos
CREATE TABLE tipos_productos (
    id_tipo INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo VARCHAR(100) NOT NULL
);

-- Productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    id_tipo INT,
    FOREIGN KEY (id_tipo) REFERENCES tipos_productos(id_tipo)
);

-- Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('admin','cliente') DEFAULT 'cliente'
);

-- Compras
CREATE TABLE compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_producto INT,
    cantidad INT,
    fecha DATETIME DEFAULT NOW(),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- Admin inicial (único creado manualmente)
INSERT INTO usuarios (nombre, email, password, rol)
VALUES ('Administrador', 'admin@licoreria.com', MD5('admin123'), 'admin');
