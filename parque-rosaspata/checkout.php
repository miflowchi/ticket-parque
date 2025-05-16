<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Parque Rosaspata</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main style="max-width:600px;margin:2rem auto;background:#fff;padding:2rem;border-radius:10px;">
        <h2>Resumen de compra</h2>
        <div id="cart-summary"></div>
        <form id="buy-form" method="POST">
            <label>Método de pago:</label>
            <select name="metodo_pago" required>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
            <button type="submit">Confirmar compra</button>
        </form>
        <div id="buy-result"></div>
    </main>
    <script>
    // Mostrar carrito
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let resumen = '';
    let total = 0;
    cart.forEach(item => {
        let subt = item.precio * item.qty;
        resumen += `<div>${item.nombre} x${item.qty} - S/ ${subt.toFixed(2)}</div>`;
        total += subt;
    });
    resumen += `<hr><b>Total: S/ ${total.toFixed(2)}</b>`;
    document.getElementById('cart-summary').innerHTML = resumen;

    // Enviar compra
    document.getElementById('buy-form').onsubmit = function(e) {
        e.preventDefault();
        fetch('php/compra_ticket.php', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({
                cart: cart,
                metodo_pago: this.metodo_pago.value
            })
        })
        .then(r=>r.json())
        .then(data=>{
            if(data.success){
                localStorage.removeItem('cart');
                document.getElementById('buy-result').innerHTML = '<b>¡Compra exitosa!</b> <br> <a href="mis_tickets.php">Ver mis tickets</a>';
            }else{
                document.getElementById('buy-result').innerHTML = '<b>Error:</b> '+data.message;
            }
        });
    }
    </script>
</body>
</html>
