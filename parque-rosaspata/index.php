<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; // Corregido
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parque Rosaspata - Venta de Tickets</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Parque Rosaspata">
            <h1>Parque Rosaspata</h1>
        </div>
        <nav id="user-nav">
            <ul>
                <li><a href="#" class="active">Inicio</a></li>
                <li><a href="#">Comprar Tickets</a></li>
                <li><a href="#">Eventos</a></li>
                <li><a href="#">Contacto</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="mis_tickets.php">Mis tickets</a></li>
                    <li><a href="php/logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><button id="login-btn">Iniciar Sesión</button></li>
                <?php endif; ?>
            </ul>
        </nav>
        <nav id="admin-nav" style="display:none;">
            <ul>
                <li><a href="admin/paneladmin.php" class="active">Panel</a></li> <!-- Corregido -->
                <li><a href="#">Administrar Tickets</a></li>
                <li><a href="#">Reportes</a></li>
                <li><a href="#">Usuarios</a></li>
                <li><button id="logout-btn">Cerrar Sesión</button></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="carousel">
                <div class="carousel-slide">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcROtT7_fTYXI0Ku5HMZVUz93lBKriMAVHk-5w&s" alt="Slide 1">
                </div>
                <div class="carousel-slide">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCeNw8QxZDoUBlW2v2X3aPAtZh_VNOOib0MQ&s" alt="Slide 2">
                </div>
                <div class="carousel-slide">
                    <img src="https://i.ytimg.com/vi/6b2AdjlUZac/maxresdefault.jpg" alt="Slide 3">
                </div>
            </div>
        </section>

        <section class="tickets">
            <h3>Tickets Disponibles</h3>
            <div class="ticket-cards">
                <?php
                require_once 'php/conexion.php';
                $stmt = $conn->query("SELECT * FROM entradas WHERE estado='disponible'");
                while ($ticket = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='ticket-card'>";
                    echo "<h4>{$ticket['descripcion']}</h4>";
                    echo "<p class='price'>S/ {$ticket['precio']}</p>";
                    echo "<p>Stock: {$ticket['stock']}</p>";
                    echo "<input type='number' min='1' max='{$ticket['stock']}' value='1' class='ticket-qty'>";
                    echo "<button class='add-to-cart' data-id='{$ticket['id']}' data-nombre='{$ticket['descripcion']}' data-precio='{$ticket['precio']}'>Añadir al carrito</button>";
                    echo "</div>";
                }
                ?>
            </div>
            <button id="go-to-cart" style="margin-top:2rem;display:none;">Ir al carrito</button>
        </section>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Carrito en localStorage
            const cartBtn = document.getElementById('go-to-cart');
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            // Mostrar el botón si ya hay productos en el carrito al cargar la página
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length > 0) {
                cartBtn.style.display = 'inline-block';
            }
            addToCartButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    const precio = this.dataset.precio;
                    const qty = this.parentElement.querySelector('.ticket-qty').value;
                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    cart.push({id, nombre, precio, qty});
                    localStorage.setItem('cart', JSON.stringify(cart));
                    cartBtn.style.display = 'inline-block';
                    alert('Ticket añadido al carrito');
                });
            });
            cartBtn.addEventListener('click', function() {
                <?php if ($isLoggedIn): ?>
                window.location.href = 'checkout.php';
                <?php else: ?>
                window.location.href = 'login.php';
                <?php endif; ?>
            });
        });
        </script>

        <section class="login-modal" id="login-modal">  
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Iniciar Sesión</h3>
                <form id="login-form" action="php/login.php" method="POST">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    
                    <button type="submit">Ingresar</button>
                    <div class="role-select">
                        <label>
                            <input type="radio" name="role" value="user" checked> Usuario
                        </label>
                        <label>
                            <input type="radio" name="role" value="admin"> Administrador
                        </label>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Parque Rosaspata. Todos los derechos reservados.</p>
    </footer>

    <script src="js/scrip.js"></script>
    <script src="js/carousel.js"></script>
    <script>
    const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false' ?>;
    const isAdmin = <?php echo $isAdmin ? 'true' : 'false' ?>;
    </script>
</body>
</html>