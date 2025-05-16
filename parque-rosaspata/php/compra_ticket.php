<?php
session_start();
require_once 'conexion.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false, 'message'=>'No autenticado']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'];
$metodo = $data['metodo_pago'];
$usuario_id = $_SESSION['user_id'];

try {
    foreach ($cart as $item) {
        $entrada_id = $item['id'];
        $qty = intval($item['qty']);
        // Verificar stock
        $stmt = $conn->prepare("SELECT stock FROM entradas WHERE id=?");
        $stmt->execute([$entrada_id]);
        $stock = $stmt->fetchColumn();
        if ($stock < $qty) {
            echo json_encode(['success'=>false, 'message'=>'Stock insuficiente para '.$item['nombre']]);
            exit;
        }
        // Insertar tickets
        for ($i=0; $i<$qty; $i++) {
            $stmt = $conn->prepare("INSERT INTO tickets (usuario_id, entrada_id, fecha, hora, metodo_pago) VALUES (?, ?, CURDATE(), CURTIME(), ?)");
            $stmt->execute([$usuario_id, $entrada_id, $metodo]);
        }
        // Actualizar stock
        $stmt = $conn->prepare("UPDATE entradas SET stock=stock-? WHERE id=?");
        $stmt->execute([$qty, $entrada_id]);
    }
    echo json_encode(['success'=>true]);
} catch(Exception $e) {
    echo json_encode(['success'=>false, 'message'=>'Error en la compra']);
}
