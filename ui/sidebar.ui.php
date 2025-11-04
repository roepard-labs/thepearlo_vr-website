<?php
/**
 * Componente: Sidebar
 * Sidebar de navegación para dashboard de administrador
 * HomeLab AR - Roepard Labs
 */

// Obtener datos del usuario desde la sesión
$userName = $_SESSION['user_name'] ?? 'Administrador';
$userRole = $_SESSION['role_id'] ?? 2;
$roleName = $userRole == 2 ? 'Administrador' : 'Usuario';

// Obtener página actual para marcar item activo
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<!-- Sidebar Desktop -->
<aside class="sidebar d-none d-md-flex flex-column" id="sidebar-admin">
    <div class="sidebar-content h-100 d-flex flex-column">

        <!-- Logo/Title + Toggle -->
        <div class="sidebar-header p-4 border-bottom d-flex align-items-center justify-content-between">
            <a href="/" class="text-decoration-none d-flex align-items-center sidebar-logo">
                <i class="bx bx-cube-alt fs-2 me-2" style="color: var(--bs-primary);"></i>
                <div class="sidebar-text">
                    <span class="fs-5 fw-bold" style="color: var(--bs-primary);">HomeLab</span>
                    <span class="fs-5 fw-bold" style="color: var(--bs-secondary);">AR</span>
                    <small class="d-block text-muted" style="font-size: 0.75rem;">Admin Panel</small>
                </div>
            </a>
            <button class="btn btn-sm btn-outline-secondary sidebar-toggle" id="sidebarToggle" title="Colapsar sidebar">
                <i class="bx bx-chevron-left"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav flex-grow-1 p-3">
            <ul class="nav flex-column gap-2">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard"
                        class="nav-link sidebar-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>"
                        title="Dashboard">
                        <i class="bx bx-home-alt me-3"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>

                <!-- Usuarios (Solo para administradores) -->
                <li class="nav-item" data-admin-only="true" style="display: none;">
                    <a href="/admin/users"
                        class="nav-link sidebar-link <?php echo $currentPage === 'users' ? 'active' : ''; ?>"
                        title="Usuarios">
                        <i class="bx bx-user me-3"></i>
                        <span class="sidebar-text">Usuarios</span>
                    </a>
                </li>

                <!-- Divider -->
                <li>
                    <hr class="sidebar-divider my-3">
                </li>

                <!-- Configuración -->
                <li class="nav-item">
                    <a href="/settings" class="nav-link sidebar-link" title="Configuración">
                        <i class="bx bx-cog me-3"></i>
                        <span class="sidebar-text">Configuración</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- User Footer Card -->
        <div class="sidebar-footer p-3 border-top">
            <!-- User Avatar -->
            <div class="user-avatar-wrapper text-center mb-3">
                <div class="user-avatar bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mx-auto"
                    style="width: 50px; height: 50px;">
                    <i class="bx bx-user text-white fs-4"></i>
                </div>
                <div class="user-info mt-2 sidebar-text">
                    <div class="fw-semibold" style="font-size: 0.9rem;">
                        <?php echo htmlspecialchars($userFirstName ?? 'Usuario'); ?>
                    </div>
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <?php echo htmlspecialchars($roleName); ?>
                    </small>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-center sidebar-text">
                <!-- Theme Toggle -->
                <button class="btn btn-sm btn-outline-secondary" id="themeToggleSidebar" title="Cambiar tema">
                    <i class="bx bx-moon"></i>
                </button>

                <!-- Home -->
                <a href="/" class="btn btn-sm btn-outline-secondary" title="Ir al inicio">
                    <i class="bx bx-home-alt"></i>
                </a>

                <!-- Logout -->
                <button class="btn btn-sm btn-outline-danger" id="logoutBtnSidebar" title="Cerrar sesión">
                    <i class="bx bx-log-out"></i>
                </button>
            </div>
        </div>

    </div>
</aside>

<!-- Sidebar Mobile (Offcanvas) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="sidebarMobileLabel">
            <i class="bx bx-cube-alt me-2" style="color: var(--bs-primary);"></i>
            <span style="color: var(--bs-primary);">HomeLab</span>
            <span style="color: var(--bs-secondary);">AR</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="p-3">
            <ul class="nav flex-column gap-2">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard"
                        class="nav-link sidebar-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                        <i class="bx bx-home-alt me-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Usuarios (Solo para administradores) -->
                <li class="nav-item" data-admin-only="true" style="display: none;">
                    <a href="/admin/users"
                        class="nav-link sidebar-link <?php echo $currentPage === 'users' ? 'active' : ''; ?>">
                        <i class="bx bx-user me-3"></i>
                        <span>Usuarios</span>
                    </a>
                </li>

                <!-- Divider -->
                <li>
                    <hr class="sidebar-divider my-3">
                </li>

                <!-- Configuración -->
                <li class="nav-item">
                    <a href="/settings" class="nav-link sidebar-link">
                        <i class="bx bx-cog me-3"></i>
                        <span>Configuración</span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</div>

<style>
    /* ===================================
   SIDEBAR STYLES
=================================== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background-color: var(--bs-body-bg);
        border-right: 1px solid var(--bs-border-color);
        z-index: 1030;
        transition: all 0.3s ease;
    }

    /* Sidebar Collapsed */
    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar.collapsed .sidebar-text {
        display: none;
    }

    .sidebar.collapsed .sidebar-header {
        justify-content: center;
    }

    .sidebar.collapsed .sidebar-logo {
        margin: 0;
    }

    .sidebar.collapsed .sidebar-toggle i {
        transform: rotate(180deg);
    }

    .sidebar.collapsed .sidebar-link {
        justify-content: center;
        padding: 0.75rem 0.5rem;
    }

    .sidebar.collapsed .sidebar-link i {
        margin: 0 !important;
    }

    .sidebar.collapsed .sidebar-footer {
        padding: 1rem 0.5rem;
    }

    .sidebar.collapsed .user-info {
        display: none;
    }

    .sidebar-header {
        background-color: var(--bs-body-bg);
    }

    .sidebar-toggle {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .sidebar-toggle:hover {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }

    .sidebar-toggle i {
        transition: transform 0.3s ease;
    }

    .sidebar-nav {
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--bs-border-color) transparent;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background-color: var(--bs-border-color);
        border-radius: 3px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--bs-body-color);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .sidebar-link:hover {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-primary);
        transform: translateX(5px);
    }

    .sidebar.collapsed .sidebar-link:hover {
        transform: none;
    }

    .sidebar-link.active {
        background-color: var(--bs-primary);
        color: white;
    }

    .sidebar-link.active:hover {
        background-color: var(--bs-primary);
        color: white;
    }

    .sidebar-link i {
        font-size: 1.25rem;
        transition: transform 0.2s ease;
    }

    .sidebar-link:hover i {
        transform: scale(1.1);
    }

    .sidebar-divider {
        border-color: var(--bs-border-color);
        opacity: 0.5;
    }

    /* Sidebar Footer */
    .sidebar-footer {
        background-color: var(--bs-body-bg);
    }

    .user-avatar-wrapper .user-avatar {
        transition: transform 0.3s ease;
    }

    .sidebar-footer:hover .user-avatar {
        transform: scale(1.1);
    }

    /* Mobile adjustments */
    @media (max-width: 767.98px) {
        .sidebar {
            display: none !important;
        }
    }
</style>

<script>
    (function () {
        'use strict';

        console.log('🧭 Sidebar: Inicializando control de visibilidad por rol');

        // ===================================
        // ACTUALIZAR SIDEBAR SEGÚN ROL (UNA SOLA VEZ AL CARGAR)
        // ===================================
        let sidebarRoleChecked = false; // Flag para evitar verificaciones múltiples
        let updateSidebarRetries = 0;
        const MAX_SIDEBAR_RETRIES = 10; // Máximo 3 segundos de espera

        async function updateSidebarByRole() {
            // Evitar verificaciones duplicadas
            if (sidebarRoleChecked) {
                console.log('⏭️ Sidebar: Ya actualizado, saltando verificación duplicada');
                return;
            }

            console.log('🔄 Sidebar: Actualizando según rol (una sola vez)...');

            // Esperar a que RoleService esté disponible
            if (!window.RoleService) {
                updateSidebarRetries++;
                if (updateSidebarRetries >= MAX_SIDEBAR_RETRIES) {
                    console.error('❌ Sidebar: RoleService no disponible después de', MAX_SIDEBAR_RETRIES, 'intentos');
                    console.warn('⚠️ Sidebar: Cargando sin verificación de rol (elementos admin ocultos por defecto)');
                    return;
                }
                console.warn('⏳ Sidebar: Esperando a RoleService... Intento', updateSidebarRetries, 'de', MAX_SIDEBAR_RETRIES);
                setTimeout(updateSidebarByRole, 300);
                return;
            }

            try {
                sidebarRoleChecked = true; // Marcar como verificado ANTES de la llamada

                const roleStatus = await window.RoleService.check();
                const isAdmin = roleStatus.isAdmin;

                console.log('👔 Sidebar: Es admin?', isAdmin);

                // Obtener todos los elementos que requieren rol admin
                const adminOnlyItems = document.querySelectorAll('[data-admin-only="true"]');

                adminOnlyItems.forEach(item => {
                    if (isAdmin) {
                        item.style.display = '';  // Mostrar para admins
                        console.log('✅ Sidebar: Mostrando elemento admin-only');
                    } else {
                        item.style.display = 'none';  // Ocultar para usuarios regulares
                        console.log('❌ Sidebar: Ocultando elemento admin-only');
                    }
                });

                console.log('✅ Sidebar: Actualizado correctamente (sin polling en segundo plano)');

            } catch (error) {
                console.error('❌ Sidebar: Error al actualizar por rol:', error);
                sidebarRoleChecked = false; // Permitir reintento en caso de error
            }
        }

        // ===================================
        // DESACTIVADO: Eventos de rol en tiempo real
        // MOTIVO: Ejecutar verificaciones constantemente colapsará el servidor
        // SOLUCIÓN: Solo verificar al cargar
        // ===================================
        /*
        window.addEventListener('roleChanged', function (event) {
            console.log('🔔 Sidebar: Evento roleChanged recibido', event.detail);
            if (!event.detail.checking) {
                updateSidebarByRole();
            }
        });
        */

        // ===================================
        // TOGGLE SIDEBAR COLLAPSE
        // ===================================
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar-admin');
        const dashboardLayout = document.querySelector('.dashboard-layout');

        if (sidebarToggle && sidebar && dashboardLayout) {
            // Cargar estado guardado
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                dashboardLayout.classList.add('sidebar-collapsed');
            }

            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
                dashboardLayout.classList.toggle('sidebar-collapsed');

                // Guardar estado
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);

                console.log('🔀 Sidebar:', collapsed ? 'Colapsado' : 'Expandido');
            });
        }

        // ===================================
        // THEME TOGGLE EN SIDEBAR
        // ===================================
        const themeToggleSidebar = document.getElementById('themeToggleSidebar');

        if (themeToggleSidebar) {
            // Sincronizar con el tema actual
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeIconSidebar(currentTheme);

            themeToggleSidebar.addEventListener('click', function () {
                const html = document.documentElement;
                const currentTheme = html.getAttribute('data-bs-theme') || 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIconSidebar(newTheme);

                console.log('🎨 Tema cambiado a:', newTheme);
            });
        }

        function updateThemeIconSidebar(theme) {
            const icon = themeToggleSidebar?.querySelector('i');
            if (icon) {
                icon.className = theme === 'dark' ? 'bx bx-sun' : 'bx bx-moon';
            }
        }

        // ===================================
        // LOGOUT BUTTON EN SIDEBAR
        // ===================================
        const logoutBtnSidebar = document.getElementById('logoutBtnSidebar');

        if (logoutBtnSidebar) {
            logoutBtnSidebar.addEventListener('click', function () {
                if (window.LogoutService) {
                    window.LogoutService.logout({ redirectUrl: '/' });
                } else {
                    console.log('🔄 LogoutService no disponible, usando logout básico');
                    window.location.href = '/';
                }
            });
        }

        // ===================================
        // INICIALIZAR AL CARGAR (UNA SOLA VEZ)
        // ===================================
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🚀 Sidebar: DOM cargado');
            // CRÍTICO: Verificar rol SOLO AL CARGAR (NO EN SEGUNDO PLANO)
            updateSidebarByRole();
            console.log('✅ Sidebar: Verificación única completada (sin polling en segundo plano)');
        });

    })();
</script>