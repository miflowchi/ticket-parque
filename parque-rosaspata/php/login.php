<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rol = $_POST['role'];

    try {
        $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE correo = :username AND rol = :rol");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $rol);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['contraseña'])) {
            // Solo verificamos el rol para redirigir
            if ($rol === 'admin') {
                
                header('Location: |../admin/paneladmin.php');
                exit();
            } else {
                header('Location: ../index.html');
                exit();
            }
        } 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

