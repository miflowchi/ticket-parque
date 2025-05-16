<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require_once 'php/conexion.php';
$usuario_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT t.id, t.fecha, t.hora, e.descripcion, t.estado, t.metodo_pago FROM tickets t JOIN entradas e ON t.entrada_id = e.id WHERE t.usuario_id=? ORDER BY t.fecha DESC, t.hora DESC");
$stmt->execute([$usuario_id]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tickets</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main style="max-width:700px;margin:2rem auto;background:#fff;padding:2rem;border-radius:10px;">
        <h2>Mis Tickets</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Fecha</th><th>Hora</th><th>Entrada</th><th>Estado</th><th>Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tickets as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= $t['fecha'] ?></td>
                    <td><?= $t['hora'] ?></td>
                    <td><?= $t['descripcion'] ?></td>
                    <td><?= $t['estado'] ?></td>
                    <td><?= $t['metodo_pago'] ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
</body>
</html>
