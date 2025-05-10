<?php
require 'php/conexion.php';
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Acceso denegado. Debes iniciar sesión como administrador.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Parque Rosaspata</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Parque Rosaspata">
            <h1>Panel de Administración</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="#reports">Reportes</a></li>
                <li><a href="#services">Servicios</a></li>
                <li><a href="#rentals">Alquileres</a></li>
                <li><a href="#claims">Reclamaciones</a></li>
                <li><a href="php/logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-container">
        <h2>Consultas y Reportes</h2>
        <section id="reports">
            <form method="POST" action="">
                <label for="start-date">Fecha Inicio:</label>
                <input type="date" id="start-date" name="start-date" required>
                
                <label for="end-date">Fecha Fin:</label>
                <input type="date" id="end-date" name="end-date" required>
                
                <button type="submit" name="generate-report">Generar Reporte</button>
            </form>
            <?php
            if (isset($_POST['generate-report'])) {
                $startDate = $_POST['start-date'];
                $endDate = $_POST['end-date'];
                $stmt = $conn->prepare("SELECT * FROM ventas WHERE fecha BETWEEN :start AND :end");
                $stmt->bindParam(':start', $startDate);
                $stmt->bindParam(':end', $endDate);
                $stmt->execute();
                $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<table><thead><tr><th>ID</th><th>Fecha</th><th>Total</th></tr></thead><tbody>";
                foreach ($ventas as $venta) {
                    echo "<tr><td>{$venta['id']}</td><td>{$venta['fecha']}</td><td>S/ {$venta['total']}</td></tr>";
                }
                echo "</tbody></table>";
            }
            ?>
        </section>

        <h2>Gestión de Servicios</h2>
        <section id="services">
            <form method="POST" action="">
                <input type="text" name="service-name" placeholder="Nombre del Servicio" required>
                <textarea name="service-description" placeholder="Descripción" required></textarea>
                <input type="number" name="service-price" placeholder="Precio" step="0.01" required>
                <button type="submit" name="add-service">Añadir Servicio</button>
            </form>
            <?php
            if (isset($_POST['add-service'])) {
                $name = $_POST['service-name'];
                $description = $_POST['service-description'];
                $price = $_POST['service-price'];
                $stmt = $conn->prepare("INSERT INTO servicios (nombre, descripcion, precio) VALUES (:name, :description, :price)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->execute();
                echo "Servicio añadido correctamente.";
            }
            $stmt = $conn->query("SELECT * FROM servicios");
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<table><thead><tr><th>Nombre</th><th>Descripción</th><th>Precio</th></tr></thead><tbody>";
            foreach ($services as $service) {
                echo "<tr><td>{$service['nombre']}</td><td>{$service['descripcion']}</td><td>S/ {$service['precio']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>

        <h2>Alquileres de Áreas Deportivas</h2>
        <section id="rentals">
            <form method="POST" action="">
                <input type="text" name="rental-area" placeholder="Área" required>
                <input type="date" name="rental-date" required>
                <input type="text" name="rental-client" placeholder="Cliente" required>
                <input type="number" name="rental-price" placeholder="Precio" step="0.01" required>
                <button type="submit" name="add-rental">Añadir Alquiler</button>
            </form>
            <?php
            if (isset($_POST['add-rental'])) {
                $area = $_POST['rental-area'];
                $date = $_POST['rental-date'];
                $client = $_POST['rental-client'];
                $price = $_POST['rental-price'];
                $stmt = $conn->prepare("INSERT INTO alquileres (area, fecha, cliente, precio) VALUES (:area, :date, :client, :price)");
                $stmt->bindParam(':area', $area);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':client', $client);
                $stmt->bindParam(':price', $price);
                $stmt->execute();
                echo "Alquiler añadido correctamente.";
            }
            $stmt = $conn->query("SELECT * FROM alquileres");
            $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<table><thead><tr><th>Área</th><th>Fecha</th><th>Cliente</th><th>Precio</th></tr></thead><tbody>";
            foreach ($rentals as $rental) {
                echo "<tr><td>{$rental['area']}</td><td>{$rental['fecha']}</td><td>{$rental['cliente']}</td><td>S/ {$rental['precio']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>

        <h2>Reclamaciones</h2>
        <section id="claims">
            <?php
            $stmt = $conn->query("SELECT * FROM reclamaciones");
            $claims = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<table><thead><tr><th>ID</th><th>Cliente</th><th>Fecha</th><th>Descripción</th><th>Estado</th></tr></thead><tbody>";
            foreach ($claims as $claim) {
                echo "<tr><td>{$claim['id']}</td><td>{$claim['cliente']}</td><td>{$claim['fecha']}</td><td>{$claim['descripcion']}</td><td>{$claim['estado']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Parque Rosaspata. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
