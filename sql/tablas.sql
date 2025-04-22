-- Crear la tabla usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(256) NOT NULL
);

-- Crear la tabla productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL UNIQUE,
    imagen VARCHAR(250),
    precio DECIMAL(6,2) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) on delete cascade
);

INSERT INTO usuarios (username, password) VALUES
('juan_perez', '$2y$12$i5Ha447F/6uQh1UA0AL6NuN/tuLPxSUiff/QDq8KBGSaL9r/7hque'),
('maria_garcia', '$2y$12$i5Ha447F/6uQh1UA0AL6NuN/tuLPxSUiff/QDq8KBGSaL9r/7hque'),
('carlos_rodriguez', '$2y$12$i5Ha447F/6uQh1UA0AL6NuN/tuLPxSUiff/QDq8KBGSaL9r/7hque'),
('laura_martinez', '$2y$12$i5Ha447F/6uQh1UA0AL6NuN/tuLPxSUiff/QDq8KBGSaL9r/7hque'),
('pedro_lopez', '$2y$12$i5Ha447F/6uQh1UA0AL6NuN/tuLPxSUiff/QDq8KBGSaL9r/7hque');

-- Insertar 10 productos con imagen por defecto
INSERT INTO productos (nombre, imagen, precio, user_id) VALUES
('Laptop HP Pavilion', '/img/default.png', 899.99, 1),
('Smartphone Samsung Galaxy S21', '/img/default.png', 749.50, 2),
('Teclado Mecánico RGB', '/img/default.png', 89.99, 3),
('Monitor LG 24" Full HD', '/img/default.png', 199.00, 1),
('Auriculares Sony WH-1000XM4', '/img/default.png', 349.99, 4),
('Impresora Epson EcoTank', '/img/default.png', 299.95, 5),
('Disco Duro Externo 1TB', '/img/default.png', 59.99, 2),
('Ratón Inalámbrico Logitech', '/img/default.png', 29.99, 3),
('Altavoz Bluetooth JBL', '/img/default.png', 129.50, 4),
('Tablet Amazon Fire HD 10', '/img/default.png', 149.99, 5);