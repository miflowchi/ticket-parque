CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

CREATE TABLE alquileres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    area VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    cliente VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

CREATE TABLE reclamaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    descripcion TEXT NOT NULL,
    estado ENUM('Pendiente', 'Resuelto') DEFAULT 'Pendiente'
);