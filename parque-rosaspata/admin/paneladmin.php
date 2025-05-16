<?php
require_once '../php/conexion.php';
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Parque Rosaspata</title>
    <link rel="stylesheet" href="../css/styleadmin.css">
  
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="../images/logo.png" alt="Parque Rosaspata">
            <h1>Panel de Administración</h1>
        </div>
    </header>
    <nav class="admin-nav">
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="#reports" class="active">Reportes</a></li>
            <li><a href="#services">Servicios</a></li>
            <li><a href="#rentals">Alquileres</a></li>
            <li><a href="#claims">Reclamaciones</a></li>
            <li><a href="../php/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
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
                $stmt = $conn->prepare("SELECT t.id, t.fecha, t.hora, u.nombre as cliente, e.descripcion as entrada, t.estado, t.metodo_pago FROM tickets t JOIN usuarios u ON t.usuario_id = u.id JOIN entradas e ON t.entrada_id = e.id WHERE t.fecha BETWEEN :start AND :end");
                $stmt->bindParam(':start', $startDate);
                $stmt->bindParam(':end', $endDate);
                $stmt->execute();
                $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<div class='table-title'>Tickets vendidos del $startDate al $endDate</div>";
                echo "<table><thead><tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Entrada</th><th>Estado</th><th>Pago</th></tr></thead><tbody>";
                foreach ($tickets as $ticket) {
                    echo "<tr><td>{$ticket['id']}</td><td>{$ticket['fecha']}</td><td>{$ticket['hora']}</td><td>{$ticket['cliente']}</td><td>{$ticket['entrada']}</td><td>{$ticket['estado']}</td><td>{$ticket['metodo_pago']}</td></tr>";
                }
                echo "</tbody></table>";
            }
            ?>
        </section>

        <h2>Gestión de Servicios</h2>
        <section id="services">
            <?php
            $stmt = $conn->query("SELECT * FROM servicios");
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div class='table-title'>Servicios disponibles</div>";
            echo "<table><thead><tr><th>Nombre</th><th>Descripción</th><th>Estado</th></tr></thead><tbody>";
            foreach ($services as $service) {
                echo "<tr><td>{$service['nombre']}</td><td>{$service['descripcion']}</td><td>{$service['estado']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>

        <h2>Alquileres de Áreas Deportivas</h2>
        <section id="rentals">
            <?php
            // Alquileres de canchas
            $stmt = $conn->query("SELECT ac.id, c.nombre as area, ac.turno, ac.precio, ac.duracion_horas FROM alquileres_cancha ac JOIN canchas c ON ac.cancha_id = c.id");
            $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div class='table-title'>Canchas</div>";
            echo "<table><thead><tr><th>Área</th><th>Turno</th><th>Precio</th><th>Duración (h)</th></tr></thead><tbody>";
            foreach ($rentals as $rental) {
                echo "<tr><td>{$rental['area']}</td><td>{$rental['turno']}</td><td>S/ {$rental['precio']}</td><td>{$rental['duracion_horas']}</td></tr>";
            }
            echo "</tbody></table>";

            // Alquileres de servicios
            $stmt = $conn->query("SELECT als.id, s.nombre as servicio, als.precio, als.duracion_horas FROM alquileres_servicios als JOIN servicios s ON als.servicio_id = s.id");
            $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div class='table-title'>Servicios</div>";
            echo "<table><thead><tr><th>Servicio</th><th>Precio</th><th>Duración (h)</th></tr></thead><tbody>";
            foreach ($rentals as $rental) {
                echo "<tr><td>{$rental['servicio']}</td><td>S/ {$rental['precio']}</td><td>{$rental['duracion_horas']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>

        <h2>Reclamaciones</h2>
        <section id="claims">
            <?php
            $stmt = $conn->query("SELECT r.id, u.nombre as cliente, r.fecha, r.descripcion, r.estado FROM reportes r JOIN usuarios u ON r.usuario_id = u.id");
            $claims = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div class='table-title'>Reportes y reclamaciones</div>";
            echo "<table><thead><tr><th>ID</th><th>Cliente</th><th>Fecha</th><th>Descripción</th><th>Estado</th></tr></thead><tbody>";
            foreach ($claims as $claim) {
                echo "<tr><td>{$claim['id']}</td><td>{$claim['cliente']}</td><td>{$claim['fecha']}</td><td>{$claim['descripcion']}</td><td>{$claim['estado']}</td></tr>";
            }
            echo "</tbody></table>";
            ?>
        </section>
    </main>
    <footer>
        <p style="background:#388e3c;color:#fff;padding:1rem 0;margin:0;border-radius:0 0 14px 14px;">&copy; 2023 Parque Rosaspata. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
