CREATE DATABASE IF NOT EXISTS rosaspata;
USE rosaspata;

-- Tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    telefono VARCHAR(15),
    dni VARCHAR(8) UNIQUE,
    rol ENUM('admin', 'cliente') DEFAULT 'cliente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

-- Tabla entradas
CREATE TABLE entradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('general', 'media', 'adulto_piscina', 'niño_piscina', 'acompañante_piscina') NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    precio DECIMAL(5,2) NOT NULL,
    stock INT DEFAULT 0,
    estado ENUM('disponible', 'agotado') DEFAULT 'disponible'
);

-- Tabla horarios_piscina
CREATE TABLE horarios_piscina (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dia_semana ENUM('martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    capacidad_maxima INT DEFAULT 50,
    estado ENUM('disponible', 'completo', 'mantenimiento') DEFAULT 'disponible'
);

-- Tabla canchas
CREATE TABLE canchas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    tipo ENUM('grass1', 'grass2', 'losa1', 'losa2') NOT NULL,
    descripcion TEXT,
    estado ENUM('disponible', 'mantenimiento', 'ocupada') DEFAULT 'disponible'
);

-- Tabla alquileres_cancha
CREATE TABLE alquileres_cancha (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cancha_id INT NOT NULL,
    turno ENUM('día', 'noche') NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    duracion_horas INT DEFAULT 1,
    FOREIGN KEY (cancha_id) REFERENCES canchas(id)
);

-- Tabla servicios
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre ENUM('futbol_voley', 'ping_pong', 'salon_multiuso', 'concha_acustica') NOT NULL,
    descripcion TEXT,
    estado ENUM('disponible', 'mantenimiento', 'ocupado') DEFAULT 'disponible'
);

-- Tabla alquileres_servicios
CREATE TABLE alquileres_servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    servicio_id INT NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    duracion_horas INT DEFAULT 1,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);

-- Tabla tickets
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    entrada_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    codigo_qr VARCHAR(255) UNIQUE,
    estado ENUM('pendiente', 'usado', 'cancelado') DEFAULT 'pendiente',
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (entrada_id) REFERENCES entradas(id)
);

-- Tabla reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cancha_id INT,
    servicio_id INT,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    tipo_servicio ENUM('cancha', 'servicio') NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada') DEFAULT 'pendiente',
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia'),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (cancha_id) REFERENCES canchas(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id),
    CHECK ((tipo_servicio = 'cancha' AND cancha_id IS NOT NULL) OR 
           (tipo_servicio = 'servicio' AND servicio_id IS NOT NULL))
);

-- Tabla reportes
CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    area ENUM('piscina', 'cancha', 'servicio', 'otro') NOT NULL,
    tipo ENUM('mantenimiento', 'limpieza', 'seguridad', 'otro') NOT NULL,
    descripcion TEXT NOT NULL,
    urgencia ENUM('baja', 'media', 'alta') DEFAULT 'media',
    estado ENUM('pendiente', 'en_proceso', 'resuelto') DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla soluciones
CREATE TABLE soluciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporte_id INT NOT NULL,
    usuario_id INT NOT NULL, -- Responsable de la solución
    fecha_solucion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    descripcion TEXT NOT NULL,
    materiales_usados TEXT,
    costo DECIMAL(8,2) DEFAULT 0,
    FOREIGN KEY (reporte_id) REFERENCES reportes(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla promociones
CREATE TABLE promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    descuento DECIMAL(5,2) NOT NULL, -- Porcentaje o monto fijo
    tipo_descuento ENUM('porcentaje', 'monto_fijo') NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado ENUM('activa', 'inactiva') DEFAULT 'activa',
    aplica_a ENUM('entradas', 'canchas', 'servicios', 'todos') NOT NULL
);

-- Tabla pagos
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    monto DECIMAL(8,2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metodo ENUM('efectivo', 'tarjeta', 'transferencia') NOT NULL,
    estado ENUM('pendiente', 'completado', 'fallido') DEFAULT 'pendiente',
    transaccion_id VARCHAR(100),
    tipo ENUM('ticket', 'reserva') NOT NULL,
    item_id INT NOT NULL, -- ID del ticket o reserva
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES 
('Admin', 'admin@rosaspata.com', SHA2('admin123', 256), 'admin'),
('Juan Perez', 'juan@example.com', SHA2('cliente123', 256), 'cliente');

-- Entradas
INSERT INTO entradas (tipo, descripcion, precio, stock) VALUES
('general', 'Entrada general para acceso al parque', 15.00, 100),
('media', 'Entrada con descuento para estudiantes y niños', 8.00, 50),
('adulto_piscina', 'Entrada para adulto a la piscina', 25.00, 30),
('niño_piscina', 'Entrada para niño a la piscina', 15.00, 30),
('acompañante_piscina', 'Entrada para acompañante a la piscina', 10.00, 20);

-- Horarios piscina
INSERT INTO horarios_piscina (dia_semana, hora_inicio, hora_fin) VALUES
('martes', '09:00:00', '17:00:00'),
('miércoles', '09:00:00', '17:00:00'),
('jueves', '09:00:00', '17:00:00'),
('viernes', '09:00:00', '17:00:00'),
('sábado', '08:00:00', '18:00:00'),
('domingo', '08:00:00', '18:00:00');

-- Canchas
INSERT INTO canchas (nombre, tipo, descripcion) VALUES
('Cancha Grass 1', 'grass1', 'Cancha de grass sintético tamaño completo'),
('Cancha Grass 2', 'grass2', 'Cancha de grass sintético tamaño completo'),
('Cancha Losa 1', 'losa1', 'Cancha de losa para múltiples deportes'),
('Cancha Losa 2', 'losa2', 'Cancha de losa para múltiples deportes');

-- Precios canchas
INSERT INTO alquileres_cancha (cancha_id, turno, precio) VALUES
(1, 'día', 80.00), (1, 'noche', 100.00),
(2, 'día', 80.00), (2, 'noche', 100.00),
(3, 'día', 70.00), (3, 'noche', 90.00),
(4, 'día', 70.00), (4, 'noche', 90.00);

-- Servicios
INSERT INTO servicios (nombre, descripcion) VALUES
('futbol_voley', 'Equipo completo de fútbol/vóley para préstamo'),
('ping_pong', 'Mesa de ping pong con raquetas y pelotas'),
('salon_multiuso', 'Salón para eventos o reuniones'),
('concha_acustica', 'Espacio para presentaciones con equipo de sonido');

-- Precios servicios
INSERT INTO alquileres_servicios (servicio_id, precio) VALUES
(1, 20.00), (2, 15.00), (3, 150.00), (4, 200.00);

-- Promociones
INSERT INTO promociones (nombre, descripcion, descuento, tipo_descuento, fecha_inicio, fecha_fin, aplica_a) VALUES
('Verano 2023', 'Descuento especial de verano en entradas', 10.00, 'porcentaje', '2023-01-01', '2023-03-31', 'entradas'),
('Fines de semana', 'Descuento en canchas los fines de semana', 15.00, 'porcentaje', '2023-01-01', '2023-12-31', 'canchas');