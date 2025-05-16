<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT id, correo, contraseña, rol FROM usuarios WHERE correo = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && hash('sha256', $password) === $user['contraseña']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['correo'];
            $_SESSION['role'] = $user['rol'];

            if ($user['rol'] === 'admin') {
                echo json_encode(['success' => true, 'redirect' => 'admin/paneladmin.php']);
            } else {
                echo json_encode(['success' => true, 'redirect' => 'index.php']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
    }
    exit();
}

