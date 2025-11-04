<?php
/**
 * Componente: Header
 * Header con navegación y autenticación
 * HomeLab AR - Roepard Labs
 */

// Verificar si el usuario está autenticado (usando estructura del backend)
$isAuthenticated = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userName = $isAuthenticated ? ($_SESSION['user_name'] ?? 'Usuario') : '';
$userRole = $isAuthenticated ? ($_SESSION['role_id'] ?? 1) : 1;
?>

<header class="navbar navbar-expand-lg shadow-sm sticky-top" data-bs-theme="auto">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            <i class="bx bx-cube-alt text-primary fs-3 me-2"></i>
            <span class="text-primary">HomeLab</span>
            <span class="text-secondary">AR</span>
        </a>

        <!-- Toggler para móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/features">Características</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/homelab">VR/AR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contacto</a>
                </li>
            </ul>

            <!-- Acciones del usuario -->
            <div class="d-flex align-items-center gap-2">
                <!-- Theme Toggle -->
                <button class="btn btn-outline-secondary btn-sm" id="themeToggle" title="Cambiar tema">
                    <i class="bx bx-moon"></i>
                </button>

                <?php if ($isAuthenticated): ?>
                <!-- Usuario autenticado -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user-circle me-1"></i>
                        <?php echo htmlspecialchars($userName); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <!-- Header del dropdown con info del usuario -->
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;">
                                    <i class="bx bx-user text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small"><?php echo htmlspecialchars($userName); ?></div>
                                    <small
                                        class="text-muted"><?php echo $userRole == 2 ? 'Administrador' : 'Usuario'; ?></small>
                                </div>
                            </div>
                        </li>

                        <!-- Opciones del menú -->
                        <?php if ($userRole == 2): ?>
                        <li><a class="dropdown-item py-2" href="/admin"><i
                                    class="bx bx-dashboard me-2 text-primary"></i>Dashboard Admin</a></li>
                        <?php else: ?>
                        <li><a class="dropdown-item py-2" href="/user"><i
                                    class="bx bx-dashboard me-2 text-primary"></i>Mi Dashboard</a></li>
                        <?php endif; ?>

                        <li><a class="dropdown-item py-2" href="/homelab"><i
                                    class="bx bx-cube me-2 text-primary"></i>HomeLab VR</a></li>
                        <li><a class="dropdown-item py-2" href="/profile"><i class="bx bx-user me-2 text-primary"></i>Mi
                                Perfil</a></li>
                        <li><a class="dropdown-item py-2" href="/settings"><i
                                    class="bx bx-cog me-2 text-primary"></i>Configuración</a></li>

                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>

                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" id="logoutBtn">
                                <i class="bx bx-log-out me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
                <?php else: ?>
                <!-- Usuario no autenticado - UN SOLO BOTÓN -->
                <button class="btn btn-primary px-4" id="authModalTrigger" type="button">
                    <i class="bx bx-user-circle me-2"></i>
                    Identifícate
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<style>
.navbar {
    transition: all 0.3s ease;
    background-color: var(--bs-body-bg) !important;
    border-bottom: 1px solid var(--bs-border-color);
}

.navbar-brand {
    font-size: 1.5rem;
}

.nav-link {
    font-weight: 500;
    transition: color 0.3s ease;
    color: var(--bs-body-color) !important;
}

.nav-link:hover {
    color: var(--bs-primary) !important;
}

/* Asegurar visibilidad del toggler en ambos temas */
.navbar-toggler {
    border-color: var(--bs-border-color);
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

[data-bs-theme="dark"] .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Dropdown menu adaptable al tema */
.dropdown-menu {
    background-color: var(--bs-body-bg);
    border-color: var(--bs-border-color);
    border-radius: 12px;
    padding: 0.5rem;
    min-width: 260px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    color: var(--bs-body-color);
    border-radius: 8px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: var(--bs-tertiary-bg);
    color: var(--bs-body-color);
    transform: translateX(5px);
}

.dropdown-item.text-danger:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: var(--bs-danger) !important;
}

/* Botón del dropdown con animación */
.dropdown button {
    transition: all 0.3s ease;
}

.dropdown button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--bs-primary-rgb), 0.4);
}
</style>

<!-- Script para inicializar el modal manualmente -->
<script>
(function() {
    'use strict';

    console.log('🎬 Script de modal trigger cargado');

    function initModalTrigger() {
        console.log('🔍 Buscando elementos del modal...');
        const triggerBtn = document.getElementById('authModalTrigger');
        const modalElement = document.getElementById('authModal');

        console.log('🔘 Botón trigger:', triggerBtn ? '✅ Encontrado' : '❌ No encontrado');
        console.log('📦 Modal element:', modalElement ? '✅ Encontrado' : '❌ No encontrado');

        if (!triggerBtn || !modalElement) {
            console.log('⏳ Elementos del modal no encontrados, reintentando en 200ms...');
            setTimeout(initModalTrigger, 200);
            return;
        }

        // Verificar que Bootstrap esté disponible
        if (typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {
            console.warn('⚠️ Bootstrap Modal no disponible, reintentando en 100ms...');
            setTimeout(initModalTrigger, 100);
            return;
        }

        console.log('✅ Inicializando trigger del modal de autenticación');

        // Agregar event listener al botón
        triggerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🔐 Click detectado en botón Identifícate');
            console.log('🔐 Bootstrap disponible:', typeof bootstrap !== 'undefined');
            console.log('🔐 Bootstrap.Modal disponible:', typeof bootstrap?.Modal !== 'undefined');

            try {
                // Obtener o crear instancia del modal
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                console.log('📦 Instancia existente:', modalInstance ? 'Sí' : 'No, creando nueva...');

                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalElement, {
                        backdrop: true,
                        keyboard: true,
                        focus: true
                    });
                    console.log('✅ Nueva instancia creada');
                }

                console.log('🚀 Intentando mostrar modal...');
                modalInstance.show();
                console.log('✅ Modal.show() ejecutado');
            } catch (error) {
                console.error('❌ Error al abrir modal:', error);
                console.error('Stack:', error.stack);
            }
        });

        console.log('✅ Event listener agregado al botón');
    }

    // Inicializar cuando esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModalTrigger);
    } else {
        initModalTrigger();
    }
})();

// ==========================================
// HEADER UI - INTEGRACIÓN CON SERVICIOS DE AUTENTICACIÓN
// ==========================================
(function() {
    'use strict';

    console.log('🔐 Header UI: Inicializando');

    // Estado inicial del header según PHP
    const initialAuth = <?php echo $isAuthenticated ? 'true' : 'false'; ?>;
    const initialUser =
        <?php echo $isAuthenticated ? json_encode(['first_name' => $userName, 'role_id' => $userRole]) : 'null'; ?>;

    console.log('📊 Estado inicial PHP (frontend):', {
        initialAuth,
        initialUser
    });
    console.log('⚠️ NOTA: PHP del frontend NO puede leer sesiones del backend (puertos diferentes)');

    // VERIFICAR SESIÓN DEL BACKEND AL CARGAR LA PÁGINA
    function checkBackendSession() {
        // Esperar a que AppRouter esté disponible (tiene la configuración correcta)
        if (!window.AppRouter || !window.AppRouter.axiosInstance) {
            console.log('⏳ Esperando a AppRouter para verificar sesión...');
            setTimeout(checkBackendSession, 500);
            return;
        }

        const apiUrl = window.AppRouter.baseURL || window.ENV_CONFIG?.API_URL || 'http://localhost:3000';
        console.log('🔍 Verificando sesión del backend:', apiUrl);

        // Usar AppRouter que tiene CORS configurado correctamente
        window.AppRouter.get('/routes/user/check_session.php')
            .then(data => {
                console.log('📥 Respuesta del backend:', data);

                if (data.logged === true && data.user_data) {
                    console.log('✅ Sesión válida en backend');
                    console.log('👤 Usuario:', data.user_data.first_name);

                    // Verificar si el frontend no muestra usuario pero el backend sí tiene sesión
                    const authBtn = document.getElementById('authModalTrigger');
                    if (authBtn) {
                        console.log('🔄 Frontend sin sesión, pero backend SÍ tiene sesión');
                        console.log('🔄 Sincronizando header con datos del backend...');
                        window.updateHeaderAfterLogin(data.user_data);
                    } else {
                        console.log('✅ Header ya muestra usuario correctamente');
                    }
                } else {
                    console.log('ℹ️ No hay sesión activa en el backend');

                    // Si frontend muestra usuario pero backend no tiene sesión
                    const userDropdown = document.getElementById('userDropdown');
                    if (userDropdown) {
                        console.log('⚠️ Frontend muestra usuario pero backend no tiene sesión');
                        console.log('🔄 Limpiando header...');
                        // Aquí podrías limpiar el header si es necesario
                    }
                }
            })
            .catch(error => {
                console.error('❌ Error al verificar sesión del backend:', error);
                console.error('💡 Backend URL:', apiUrl);
                console.error('💡 Verifica que el backend esté accesible');
            });
    }

    // Si ya hay un botón de logout, adjuntar LogoutService
    document.addEventListener('DOMContentLoaded', function() {
        // PASO 1: Verificar sesión del backend SIEMPRE al cargar
        console.log('🚀 DOM cargado, verificando sincronización con backend...');
        checkBackendSession();

        // PASO 2: Adjuntar LogoutService si existe el botón
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn && window.LogoutService) {
            console.log('🔗 Adjuntando LogoutService al botón de logout existente');
            window.LogoutService.attachToButton('#logoutBtn', {
                redirectUrl: '/'
            });
        }

        // PASO 3: Re-inicializar modal trigger después de actualizaciones
        const modalTrigger = document.getElementById('authModalTrigger');
        if (modalTrigger) {
            console.log('🔗 Modal trigger encontrado y listo');
        }
    });

    // Función global para actualizar header después de login exitoso
    window.updateHeaderAfterLogin = function(userData) {
        console.log('🔄 Actualizando header después de login:', userData);

        if (!userData || !userData.first_name) {
            console.error('❌ Datos de usuario inválidos');
            return;
        }

        const userDropdownContainer = document.querySelector('.d-flex.align-items-center.gap-2');
        if (!userDropdownContainer) {
            console.error('❌ Contenedor del header no encontrado');
            return;
        }

        // Construir HTML del dropdown de usuario
        const isAdmin = userData.role_id == 2;
        const userHTML = `
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user-circle me-1"></i>
                        ${userData.first_name}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <!-- Header del dropdown con info del usuario -->
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 36px; height: 36px;">
                                    <i class="bx bx-user text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">${userData.first_name}</div>
                                    <small class="text-muted">${isAdmin ? 'Administrador' : 'Usuario'}</small>
                                </div>
                            </div>
                        </li>

                        <!-- Opciones del menú -->
                        ${isAdmin ?
                    '<li><a class="dropdown-item py-2" href="/admin"><i class="bx bx-dashboard me-2 text-primary"></i>Dashboard Admin</a></li>' :
                    '<li><a class="dropdown-item py-2" href="/user"><i class="bx bx-dashboard me-2 text-primary"></i>Mi Dashboard</a></li>'
                }

                        <li><a class="dropdown-item py-2" href="/homelab"><i class="bx bx-cube me-2 text-primary"></i>HomeLab VR</a></li>
                        <li><a class="dropdown-item py-2" href="/profile"><i class="bx bx-user me-2 text-primary"></i>Mi Perfil</a></li>
                        <li><a class="dropdown-item py-2" href="/settings"><i class="bx bx-cog me-2 text-primary"></i>Configuración</a></li>

                        <li><hr class="dropdown-divider my-2"></li>

                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" id="logoutBtn">
                                <i class="bx bx-log-out me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            `;

        // Guardar el botón de theme
        const themeBtn = userDropdownContainer.querySelector('#themeToggle');

        // Limpiar contenedor
        userDropdownContainer.innerHTML = '';

        // Restaurar theme button
        if (themeBtn) {
            userDropdownContainer.appendChild(themeBtn);
        }

        // Agregar dropdown de usuario
        userDropdownContainer.insertAdjacentHTML('beforeend', userHTML);

        // Adjuntar LogoutService al nuevo botón
        setTimeout(function() {
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn && window.LogoutService) {
                window.LogoutService.attachToButton('#logoutBtn', {
                    redirectUrl: '/'
                });
                console.log('✅ LogoutService adjuntado al botón de logout');
            }
        }, 100);

        console.log('✅ Header actualizado con datos del usuario');
    };

    // Escuchar evento personalizado de login exitoso desde auth-modal.js
    window.addEventListener('userLoggedIn', function(event) {
        console.log('🔔 Header: Evento userLoggedIn recibido', event.detail);
        if (event.detail && event.detail.userData) {
            window.updateHeaderAfterLogin(event.detail.userData);
        }
    });

    console.log('✅ Header UI: Listo para actualizaciones dinámicas');
})();
</script>