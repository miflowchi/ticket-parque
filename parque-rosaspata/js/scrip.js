document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const loginBtn = document.getElementById('login-btn');
    const logoutBtn = document.getElementById('logout-btn');
    const loginModal = document.getElementById('login-modal');
    const closeBtn = document.querySelector('.close');
    const loginForm = document.getElementById('login-form');
    const userNav = document.getElementById('user-nav');
    const adminNav = document.getElementById('admin-nav');
    
    // Mostrar modal de login
    loginBtn.addEventListener('click', function() {
        loginModal.style.display = 'block';
    });
    
    // Cerrar modal
    closeBtn.addEventListener('click', function() {
        loginModal.style.display = 'none';
    });
    
    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === loginModal) {
            loginModal.style.display = 'none';
        }
    });
    
    // Manejar el login
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('php/login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    });
    
    // Manejar logout
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            // Eliminar datos de sesión
            localStorage.removeItem('userRole');
            
            // Mostrar nav de usuario y ocultar nav de admin
            userNav.style.display = 'block';
            adminNav.style.display = 'none';
        });
    }
    
    // Verificar si ya está logueado como admin al cargar la página
    if (localStorage.getItem('userRole') === 'admin') {
        userNav.style.display = 'none';
        adminNav.style.display = 'block';
    }
    
    // Lógica para añadir tickets al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const ticketCard = this.closest('.ticket-card');
            const ticketName = ticketCard.querySelector('h4').textContent;
            const ticketPrice = ticketCard.querySelector('.price').textContent;
            
            alert(`Añadido al carrito: ${ticketName} - ${ticketPrice}`);
            // Aquí podrías añadir lógica para guardar en un carrito de compras
        });
    });
    
    // Botón de comprar tickets
    const buyTicketsBtn = document.getElementById('buy-tickets');
    if (buyTicketsBtn) {
        buyTicketsBtn.addEventListener('click', function() {
            document.querySelector('.tickets').scrollIntoView({ 
                behavior: 'smooth' 
            });
        });
    }
});