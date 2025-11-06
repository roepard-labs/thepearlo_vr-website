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
        <div class="sidebar-header p-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between sidebar-header-content">
                <a href="/" class="text-decoration-none d-flex align-items-center sidebar-logo">
                    <i class="bx bx-cube-alt fs-2 me-2" style="color: var(--bs-primary);"></i>
                    <div class="sidebar-text">
                        <span class="fs-5 fw-bold" style="color: var(--bs-primary);">HomeLab</span>
                        <span class="fs-5 fw-bold" style="color: var(--bs-secondary);">OS-VR</span>
                    </div>
                </a>
                <div class="d-flex gap-2">
                    <a href="/" class="btn btn-sm btn-outline-primary sidebar-toggle" title="Ir al menú principal">
                        <i class="bx bx-home"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-secondary sidebar-toggle" id="sidebarToggle"
                        title="Colapsar sidebar">
                        <i class="bx bx-chevron-left"></i>
                    </button>
                </div>
            </div>
            <!-- Toggle button for collapsed state (appears below logo) -->
            <div class="sidebar-toggle-collapsed mt-3" style="display: none;">
                <div class="d-flex flex-column gap-2">
                    <a href="/" class="btn btn-sm btn-outline-primary w-100" title="Ir al menú principal">
                        <i class="bx bx-home"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-secondary w-100" id="sidebarToggleCollapsed"
                        title="Expandir sidebar">
                        <i class="bx bx-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav flex-grow-1 p-3">
            <ul class="nav flex-column gap-2">

                <!-- Dashboard Principal -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link sidebar-link" data-page="dashboard" title="Dashboard">
                        <i class="bx bx-home-alt me-3"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <li>
                    <hr class="sidebar-divider my-3">
                </li>

                <!-- Gestión (Solo para administradores) -->
                <li class="nav-item" data-admin-only="true" style="display: none;">
                    <a href="/dashboard/users" class="nav-link sidebar-link" data-page="users"
                        title="Gestión de Usuarios">
                        <i class="bx bx-user me-3"></i>
                        <span class="sidebar-text">Usuarios</span>
                    </a>
                </li>

                <!-- Archivos -->
                <li class="nav-item">
                    <a href="/dashboard/files" class="nav-link sidebar-link" data-page="files"
                        title="Administrador de Archivos">
                        <i class="bx bx-folder-open me-3"></i>
                        <span class="sidebar-text">Archivos</span>
                    </a>
                </li>

                <!-- Perfil -->
                <li class="nav-item">
                    <a href="/dashboard/profile" class="nav-link sidebar-link" data-page="profile" title="Mi Perfil">
                        <i class="bx bx-user-circle me-3"></i>
                        <span class="sidebar-text">Mi Perfil</span>
                    </a>
                </li>

                <!-- Configuración -->
                <li class="nav-item">
                    <a href="/dashboard/settings" class="nav-link sidebar-link" data-page="settings"
                        title="Configuración">
                        <i class="bx bx-cog me-3"></i>
                        <span class="sidebar-text">Configuración</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- User Footer Card -->
        <div class="sidebar-footer p-3 border-top">
            <!-- Layout Expandido: Avatar a la izquierda, info a la derecha -->
            <div class="user-footer-expanded">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <!-- User Avatar -->
                    <div class="user-avatar-wrapper flex-shrink-0">
                        <?php
                        // Verificar si existe foto de perfil
                        $profilePicture = isset($_SESSION['profile_picture']) && !empty($_SESSION['profile_picture'])
                            ? $_SESSION['profile_picture']
                            : '../assets/img/default-avatar.png';
                        ?>
                        <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px;">
                            <i class="bx bx-user text-white fs-4"></i>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="user-info flex-grow-1 overflow-hidden">
                        <div class="fw-bold text-truncate" id="sidebarUserName">
                            <?php echo htmlspecialchars($userName); ?>
                        </div>
                        <small class="text-muted"
                            id="sidebarUserRole"><?php echo htmlspecialchars($roleName); ?></small>
                    </div>
                </div>

                <!-- Action Buttons (horizontal cuando expandido) -->
                <div class="d-flex gap-2 justify-content-between">
                    <button class="btn btn-sm btn-outline-secondary flex-fill" id="themeToggleSidebar"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Cambiar tema">
                        <i class="bx bx-moon"></i>
                    </button>
                    <a href="/dashboard/profile" class="btn btn-sm btn-outline-primary flex-fill"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ver perfil">
                        <i class="bx bx-user-circle"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger flex-fill" id="logoutBtnSidebar"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar sesión">
                        <i class="bx bx-log-out"></i>
                    </button>
                </div>
            </div>

            <!-- Layout Colapsado: Solo avatar centrado -->
            <div class="user-footer-collapsed" style="display: none;">
                <div class="user-avatar-wrapper text-center mb-2">
                    <div class="user-avatar bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bx bx-user text-white fs-4"></i>
                    </div>
                </div>

                <!-- Action Buttons (vertical cuando colapsado) -->
                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-sm btn-outline-secondary" id="themeToggleSidebarCollapsed"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Cambiar tema">
                        <i class="bx bx-moon"></i>
                    </button>
                    <a href="/dashboard/profile" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                        data-bs-placement="right" title="Ver perfil">
                        <i class="bx bx-user-circle"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" id="logoutBtnSidebarCollapsed"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Cerrar sesión">
                        <i class="bx bx-log-out"></i>
                    </button>
                </div>
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
            <span style="color: var(--bs-secondary);">OS-VR</span>
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
                    <a href="/dashboard/users"
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
                    <a href="/dashboard/settings" class="nav-link sidebar-link">
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
        flex-direction: column;
    }

    .sidebar.collapsed .sidebar-header-content {
        justify-content: center !important;
    }

    .sidebar.collapsed .sidebar-logo {
        margin: 0;
    }

    /* Ocultar botón de toggle normal cuando está colapsado */
    .sidebar.collapsed .sidebar-toggle {
        display: none;
    }

    /* Mostrar botón de toggle debajo del logo cuando está colapsado */
    .sidebar.collapsed .sidebar-toggle-collapsed {
        display: block !important;
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

    /* Footer expandido/colapsado */
    .sidebar .user-footer-expanded {
        display: block;
    }

    .sidebar .user-footer-collapsed {
        display: none !important;
    }

    .sidebar.collapsed .user-footer-expanded {
        display: none !important;
    }

    .sidebar.collapsed .user-footer-collapsed {
        display: block !important;
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
                    console.error('❌ Sidebar: RoleService no disponible después de', MAX_SIDEBAR_RETRIES,
                        'intentos');
                    console.warn(
                        '⚠️ Sidebar: Cargando sin verificación de rol (elementos admin ocultos por defecto)');
                    return;
                }
                console.warn('⏳ Sidebar: Esperando a RoleService... Intento', updateSidebarRetries, 'de',
                    MAX_SIDEBAR_RETRIES);
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
                        item.style.display = ''; // Mostrar para admins
                        console.log('✅ Sidebar: Mostrando elemento admin-only');
                    } else {
                        item.style.display = 'none'; // Ocultar para usuarios regulares
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
        const sidebarToggleCollapsed = document.getElementById('sidebarToggleCollapsed');
        const sidebar = document.getElementById('sidebar-admin');
        const dashboardLayout = document.querySelector('.dashboard-layout');

        function toggleSidebar() {
            if (sidebar && dashboardLayout) {
                sidebar.classList.toggle('collapsed');
                dashboardLayout.classList.toggle('sidebar-collapsed');

                // Guardar estado
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', collapsed);

                console.log('🔀 Sidebar:', collapsed ? 'Colapsado' : 'Expandido');
            }
        }

        if (sidebar && dashboardLayout) {
            // Cargar estado guardado
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                dashboardLayout.classList.add('sidebar-collapsed');
            }

            // Evento para botón normal (expandido)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            // Evento para botón colapsado (debajo del logo)
            if (sidebarToggleCollapsed) {
                sidebarToggleCollapsed.addEventListener('click', toggleSidebar);
            }
        }

        // ===================================
        // THEME TOGGLE EN SIDEBAR (Ambos botones: expandido y colapsado)
        // ===================================
        const themeToggleSidebar = document.getElementById('themeToggleSidebar');
        const themeToggleSidebarCollapsed = document.getElementById('themeToggleSidebarCollapsed');

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Cambiar el tema
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Actualizar iconos en ambos botones
            updateThemeIconSidebar(newTheme);
            console.log('🎨 Tema cambiado a:', newTheme);
        }

        function updateThemeIconSidebar(theme) {
            const iconExpanded = themeToggleSidebar?.querySelector('i');
            const iconCollapsed = themeToggleSidebarCollapsed?.querySelector('i');
            const iconClass = theme === 'dark' ? 'bx bx-sun' : 'bx bx-moon';

            if (iconExpanded) iconExpanded.className = iconClass;
            if (iconCollapsed) iconCollapsed.className = iconClass;
        }

        if (themeToggleSidebar) {
            // Sincronizar con el tema actual
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeIconSidebar(currentTheme);

            themeToggleSidebar.addEventListener('click', toggleTheme);
        }

        if (themeToggleSidebarCollapsed) {
            // Sincronizar con el tema actual
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateThemeIconSidebar(currentTheme);

            themeToggleSidebarCollapsed.addEventListener('click', toggleTheme);
        }

        // ===================================
        // LOGOUT BUTTON EN SIDEBAR (Ambos botones: expandido y colapsado)
        // ===================================
        const logoutBtnSidebar = document.getElementById('logoutBtnSidebar');
        const logoutBtnSidebarCollapsed = document.getElementById('logoutBtnSidebarCollapsed');

        async function handleLogout(e) {
            e.preventDefault();

            // CRÍTICO: Usar LogoutService en lugar de window.logoutUser
            if (window.LogoutService && typeof window.LogoutService.logout === 'function') {
                console.log('🚪 Sidebar: Ejecutando logout con LogoutService');
                await window.LogoutService.logout({
                    confirm: true,
                    redirect: true,
                    redirectUrl: '/'
                });
            } else {
                console.warn('⚠️ LogoutService no está disponible, esperando...');
                // Esperar a que LogoutService se cargue
                setTimeout(() => handleLogout(e), 500);
            }
        }

        if (logoutBtnSidebar) {
            logoutBtnSidebar.addEventListener('click', handleLogout);
            console.log('✅ Sidebar: Handler de logout adjuntado al botón expandido');
        }

        if (logoutBtnSidebarCollapsed) {
            logoutBtnSidebarCollapsed.addEventListener('click', handleLogout);
            console.log('✅ Sidebar: Handler de logout adjuntado al botón colapsado');
        } // ===================================
        // ACTUALIZAR INFORMACIÓN DEL USUARIO (UNA SOLA VEZ AL CARGAR)
        // ===================================
        let sidebarUserUpdated = false; // Flag para evitar actualizaciones múltiples

        async function updateSidebarUserInfo() {
            // Evitar actualizaciones duplicadas
            if (sidebarUserUpdated) {
                console.log('⏭️ Sidebar: Info de usuario ya actualizada');
                return;
            }

            console.log('👤 Sidebar: Actualizando información del usuario desde backend...');

            // Esperar a que SessionService y RoleService estén disponibles
            if (!window.SessionService || !window.RoleService) {
                console.warn('⏳ Sidebar: Esperando a SessionService y RoleService...');
                setTimeout(updateSidebarUserInfo, 300);
                return;
            }

            try {
                sidebarUserUpdated = true; // Marcar como actualizado ANTES de la llamada

                // Obtener datos de sesión y rol del backend
                const sessionStatus = await window.SessionService.check();
                const roleStatus = await window.RoleService.check();

                if (!sessionStatus.isAuthenticated) {
                    console.log('⚠️ Sidebar: Usuario no autenticado');
                    return;
                }

                const userData = sessionStatus.userData || {};
                const isAdmin = roleStatus.isAdmin;

                // DEBUG: Ver qué datos llegan realmente del backend
                console.log('🔍 Sidebar: userData completo:', userData);
                console.log('🔍 Sidebar: roleStatus completo:', roleStatus);

                // Obtener nombre para mostrar (solo primer nombre)
                let displayName = userData.user_name || userData.first_name || 'Usuario';
                if (userData.user_name && userData.user_name.includes(' ')) {
                    displayName = userData.user_name.split(' ')[0];
                }

                // CRÍTICO: roleStatus usa camelCase (roleId), no snake_case (role_id)
                // roleStatus.roleId viene de RoleService que consulta check_role.php
                // Intentar en orden: roleStatus.roleId > roleStatus.role_id > userData.role_id
                const roleId = parseInt(roleStatus.roleId || roleStatus.role_id || userData.role_id);

                // Mapear role_id a nombre en español
                let roleName = 'Usuario'; // Default
                if (roleId === 2) {
                    roleName = 'Administrador';
                } else if (roleId === 3) {
                    roleName = 'Supervisor';
                }
                // Si role_id === 1 o cualquier otro valor, queda "Usuario"

                console.log('👤 Sidebar: Datos del backend:', {
                    displayName,
                    roleId,
                    roleName,
                    isAdmin,
                    'roleStatus.roleId (camelCase)': roleStatus.roleId,
                    'roleStatus.role_id (snake_case)': roleStatus.role_id,
                    'userData.role_id': userData.role_id
                });

                // Actualizar elementos del DOM
                const userNameElement = document.getElementById('sidebarUserName');
                const userRoleElement = document.getElementById('sidebarUserRole');

                if (userNameElement) {
                    userNameElement.textContent = displayName;
                    console.log('✅ Sidebar: Nombre actualizado:', displayName);
                }

                if (userRoleElement) {
                    userRoleElement.textContent = roleName;
                    console.log('✅ Sidebar: Rol actualizado:', roleName);
                }

                console.log('✅ Sidebar: Información del usuario actualizada correctamente');

            } catch (error) {
                console.error('❌ Sidebar: Error al actualizar información del usuario:', error);
                sidebarUserUpdated = false; // Permitir reintento en caso de error
            }
        }

        // ===================================
        // RESALTAR PÁGINA ACTIVA
        // ===================================
        function highlightActivePage() {
            // Obtener la ruta actual
            const currentPath = window.location.pathname;
            console.log('📍 Sidebar: Ruta actual:', currentPath);

            // Remover clase active de todos los links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('active');
            });

            // Determinar qué página está activa
            let activePage = 'dashboard'; // Por defecto

            if (currentPath === '/dashboard') {
                activePage = 'dashboard';
            } else if (currentPath.includes('/dashboard/users')) {
                activePage = 'users';
            } else if (currentPath.includes('/dashboard/files')) {
                activePage = 'files';
            } else if (currentPath.includes('/dashboard/profile')) {
                activePage = 'profile';
            } else if (currentPath.includes('/dashboard/settings')) {
                activePage = 'settings';
            }

            // Agregar clase active al link correspondiente
            const activeLink = document.querySelector(`.sidebar-link[data-page="${activePage}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
                console.log('✅ Sidebar: Página activa:', activePage);
            }
        }

        // ===================================
        // INICIALIZAR AL CARGAR (UNA SOLA VEZ)
        // ===================================
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🚀 Sidebar: DOM cargado');

            // CRÍTICO: Verificar rol SOLO AL CARGAR (NO EN SEGUNDO PLANO)
            updateSidebarByRole();

            // CRÍTICO: Actualizar información del usuario desde backend (UNA SOLA VEZ)
            updateSidebarUserInfo();

            // Resaltar página activa
            highlightActivePage();

            console.log('✅ Sidebar: Verificación única completada (sin polling en segundo plano)');
        });

    })();
</script>