<?php
session_start();
?>
<nav>
    <?php if (isset($_SESSION['user_id'])): ?>
        Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?> |
        <a href="mis_tickets.php">Mis tickets</a> |
        <a href="logout.php">Cerrar sesión</a> |
        <a href="compras.php">Mis compras</a>
    <?php else: ?>
        <a href="login.php">Iniciar sesión</a> |
        <a href="register.php">Registrarse</a>
    <?php endif; ?>
    <!-- ...otros enlaces... -->
</nav>
