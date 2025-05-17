<?php
require_once 'php/conexion.php';
session_start();
$mensaje = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, correo, contraseña, rol FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && hash('sha256', $password) === $user['contraseña']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['correo'];
        $_SESSION['role'] = $user['rol'];
        if ($user['rol'] === 'admin') {
            header('Location: admin/paneladmin.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $mensaje = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if ($mensaje): ?>
        <div style="color:red;"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label>Usuario:</label><input type="text" name="username" required><br>
        <label>Contraseña:</label><input type="password" name="password" required><br>
        <input type="submit" value="Ingresar">
    </form>
    <a href="register.php">¿No tienes cuenta? Regístrate</a>
</body>
</html>