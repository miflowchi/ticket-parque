<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Parque Rosaspata</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .admin-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            width: 22%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            margin-top: 0;
            color: #2E7D32;
        }
        
        .stat-card p {
            font-size: 2rem;
            font-weight: bold;
            margin: 1rem 0;
            color: #4CAF50;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            font-size: 0.8rem;
        }
        
        .edit-btn {
            background-color: #2196F3;
        }
        
        .delete-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Parque Rosaspata">
            <h1>Panel de Administración</h1>
        </div>
        <nav id="admin-nav">
            <ul>
                <li><a href="../index.html">Inicio</a></li>
                <li><a href="../paneladmin.php">Panel</a></li> <!-- Fixed link -->
                <li><a href="#">Administrar Tickets</a></li>
                <li><a href="#">Reportes</a></li>
                <li><a href="#">Usuarios</a></li>
                <li><button id="logout-btn">Cerrar Sesión</button></li>
            </ul>
        </nav>
    </header>

    <main class="admin-container">
        <h2>Resumen del Parque Rosaspata</h2>
        
        <div class="admin-stats">
            <div class="stat-card">
                <h3>Ventas Hoy</h3>
                <p>124</p>
                <small>+12% que ayer</small>
            </div>
            <div class="stat-card">
                <h3>Visitantes</h3>
                <p>356</p>
                <small>Actualizado hace 1 hora</small>
            </div>
            <div class="stat-card">
                <h3>Ingresos</h3>
                <p>S/ 6,540</p>
                <small>+18% que ayer</small>
            </div>
            <div class="stat-card">
                <h3>Eventos</h3>
                <p>3</p>
                <small>Activos hoy</small>
            </div>
        </div>
        
        <h2>Últimas Ventas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#10025</td>
                    <td>15/10/2023</td>
                    <td>Juan Pérez</td>
                    <td>General</td>
                    <td>4</td>
                    <td>S/ 80.00</td>
                    <td>
                        <button class="action-btn edit-btn">Editar</button>
                        <button class="action-btn delete-btn">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>#10024</td>
                    <td>15/10/2023</td>
                    <td>María Gómez</td>
                    <td>Niño</td>
                    <td>2</td>
                    <td>S/ 30.00</td>
                    <td>
                        <button class="action-btn edit-btn">Editar</button>
                        <button class="action-btn delete-btn">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>#10023</td>
                    <td>14/10/2023</td>
                    <td>Carlos Ruiz</td>
                    <td>Adulto Mayor</td>
                    <td>1</td>
                    <td>S/ 10.00</td>
                    <td>
                        <button class="action-btn edit-btn">Editar</button>
                        <button class="action-btn delete-btn">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>#10022</td>
                    <td>14/10/2023</td>
                    <td>Ana Torres</td>
                    <td>General</td>
                    <td>2</td>
                    <td>S/ 40.00</td>
                    <td>
                        <button class="action-btn edit-btn">Editar</button>
                        <button class="action-btn delete-btn">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Catálogo de Servicios</h2>
        <section id="service-catalog">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Guía Turística</td>
                        <td>Servicio de guía personalizada por el parque.</td>
                        <td>S/ 50.00</td>
                    </tr>
                    <tr>
                        <td>Alquiler de Bicicletas</td>
                        <td>Bicicletas disponibles para recorrer el parque.</td>
                        <td>S/ 20.00</td>
                    </tr>
                    <tr>
                        <td>Zona de Picnic</td>
                        <td>Espacio reservado para picnics familiares.</td>
                        <td>S/ 30.00</td>
                    </tr>
                    <tr>
                        <td>Cancha de Fútbol</td>
                        <td>Alquiler de cancha para partidos de fútbol.</td>
                        <td>S/ 100.00</td>
                    </tr>
                    <tr>
                        <td>Piscina</td>
                        <td>Acceso a la piscina del parque.</td>
                        <td>S/ 40.00</td>
                    </tr>
                    <tr>
                        <td>Cancha de Tenis</td>
                        <td>Alquiler de cancha para jugar tenis.</td>
                        <td>S/ 80.00</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Parque Rosaspata. Todos los derechos reservados.</p>
    </footer>

    <script src="../js/admin.js"></script>
</body>
</html>