<?php
require_once 'php/conexion.php';
$mensaje = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['username']);
    $password = $_POST['password'];
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    // Validación básica
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El usuario debe ser un correo válido.";
    } else {
        // Verificar si ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        if ($stmt->fetch()) {
            $mensaje = "El correo ya está registrado.";
        } else {
            // Insertar usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, SHA2(?, 256), 'cliente')");
            $nombreInsert = $nombre !== '' ? $nombre : $correo;
            if ($stmt->execute([$nombreInsert, $correo, $password])) {
                header("Location: login.php?registro=ok");
                exit();
            } else {
                $mensaje = "Error al registrar usuario.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registrarse</h2>
    <?php if ($mensaje): ?>
        <div style="color:red;"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <form method="post" action="register.php">
        <label>Nombre:</label><input type="text" name="nombre" required><br>
        <label>Correo:</label><input type="email" name="username" required><br>
        <label>Contraseña:</label><input type="password" name="password" required><br>
        <input type="submit" value="Registrarse">
    </form>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</body>
</html>