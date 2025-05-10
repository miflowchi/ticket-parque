document.addEventListener('DOMContentLoaded', function() {
    // Verificar si el usuario es admin
    if (localStorage.getItem('userRole') !== 'admin') {
        alert('Acceso denegado. Debes iniciar sesión como administrador.');
        window.location.href = '../index.html';
    }
    
    // Manejar logout
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('userRole');
            window.location.href = '../index.html';
        });
    }
    
    // Aquí puedes añadir más lógica específica del panel de admin
    console.log('Panel de administración cargado');
    
    // Ejemplo: Confirmar antes de eliminar una venta
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas eliminar esta venta?')) {
                const row = this.closest('tr');
                row.remove();
                // En una aplicación real, harías una petición al servidor para eliminar el registro
                alert('Venta eliminada correctamente');
            }
        });
    });

    // Manejar generación de reportes
    document.getElementById('report-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;

        // Simulación de generación de reporte
        alert(`Generando reporte desde ${startDate} hasta ${endDate}`);
        // Aquí podrías hacer una petición al servidor para obtener los datos
    });

    // Manejar servicios
    document.getElementById('add-service-btn').addEventListener('click', function () {
        alert('Funcionalidad para añadir un nuevo servicio.');
        // Aquí podrías abrir un modal para añadir servicios
    });

    // Manejar alquileres
    document.getElementById('add-rental-btn').addEventListener('click', function () {
        alert('Funcionalidad para añadir un nuevo alquiler.');
        // Aquí podrías abrir un modal para añadir alquileres
    });
});