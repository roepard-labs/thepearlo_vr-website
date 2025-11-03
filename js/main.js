/**
 * Main.js - Inicialización Principal
 * HomeLab AR - Roepard Labs
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('%c🚀 HomeLab AR Iniciado', 'color: #0088ff; font-size: 16px; font-weight: bold');

    // ===================================
    // INICIALIZACIÓN DE AOS
    // ===================================
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
        console.log('✅ AOS inicializado');
    }

    // ===================================
    // BOOTSTRAP TOOLTIPS & POPOVERS
    // ===================================
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // ===================================
    // THEME TOGGLE
    // ===================================
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;

    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    updateThemeIcon(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);

            console.log(`🎨 Tema cambiado a: ${newTheme}`);
        });
    }

    function updateThemeIcon(theme) {
        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            if (theme === 'dark') {
                icon.classList.remove('bx-moon');
                icon.classList.add('bx-sun');
            } else {
                icon.classList.remove('bx-sun');
                icon.classList.add('bx-moon');
            }
        }
    }

    // ===================================
    // SMOOTH SCROLL
    // ===================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ===================================
    // LOGOUT
    // ===================================
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Cerrar sesión?',
                    text: '¿Estás seguro de que quieres salir?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        handleLogout();
                    }
                });
            } else {
                if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                    handleLogout();
                }
            }
        });
    }

    function handleLogout() {
        // Limpiar localStorage
        localStorage.removeItem('token');
        localStorage.removeItem('user');

        // Redirigir
        window.location.href = '/';
    }

    // ===================================
    // FORMULARIO DE CONTACTO
    // ===================================
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                subject: document.getElementById('subject').value,
                message: document.getElementById('message').value
            };

            console.log('📧 Formulario de contacto enviado:', formData);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Mensaje enviado!',
                    text: 'Te responderemos pronto',
                    confirmButtonText: 'Entendido'
                });
            } else {
                alert('¡Mensaje enviado! Te responderemos pronto.');
            }

            contactForm.reset();
        });
    }

    // ===================================
    // NEWSLETTER
    // ===================================
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const email = this.querySelector('input[type="email"]').value;
            console.log('📬 Suscripción newsletter:', email);

            if (typeof Notyf !== 'undefined') {
                const notyf = new Notyf({
                    duration: 3000,
                    position: { x: 'right', y: 'bottom' }
                });
                notyf.success('¡Suscripción exitosa!');
            } else {
                alert('¡Gracias por suscribirte!');
            }

            this.reset();
        });
    }

    // ===================================
    // ANIMACIÓN DE NÚMEROS (STATS)
    // ===================================
    const statNumbers = document.querySelectorAll('.stat-number[data-count]');

    if (statNumbers.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumber(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => observer.observe(stat));
    }

    function animateNumber(element) {
        const target = parseFloat(element.getAttribute('data-count'));
        const suffix = element.textContent.replace(/[0-9.]/g, '');
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target + suffix;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
        }, 16);
    }

    console.log('✅ Main.js cargado completamente');
});
