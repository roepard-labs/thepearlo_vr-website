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
// Definir items de navegación en un único array para reutilizar en desktop y mobile
$navItems = [
    ['page' => 'dashboard', 'href' => '/dashboard', 'icon' => 'bx bx-home-alt', 'label' => 'Dashboard'],
    ['divider' => true],
    ['page' => 'homelab', 'href' => '/dashboard/homelab', 'icon' => 'bx bx-glasses', 'label' => 'HomeLab VR'],
    ['divider' => true],
    ['page' => 'users', 'href' => '/dashboard/users', 'icon' => 'bx bx-user', 'label' => 'Usuarios', 'adminOnly' => true],
    ['page' => 'files', 'href' => '/dashboard/files', 'icon' => 'bx bx-folder-open', 'label' => 'Archivos'],
    ['page' => 'changes', 'href' => '/dashboard/changes', 'icon' => 'bx bx-git-branch', 'label' => 'Cambios'],
    ['divider' => true],
    ['page' => 'profile', 'href' => '/dashboard/profile', 'icon' => 'bx bx-user-circle', 'label' => 'Mi Perfil'],
    ['page' => 'settings', 'href' => '/dashboard/settings', 'icon' => 'bx bx-cog', 'label' => 'Configuración', 'adminOnly' => true],
];
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
                        <span class="fs-5 fw-bold" style="color: var(--bs-secondary);">VR-OS</span>
                    </div>
                </a>
                <div class="d-flex gap-2 mb-4 ms-2">
                    <a href="/" class="btn btn-sm btn-outline-primary sidebar-toggle" title="Ir al menú principal">
                        <i class="bx bx-home"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-secondary sidebar-toggle" id="sidebarToggle"
                        title="Colapsar sidebar">
                        <i class="bx bx-chevron-left"></i>
                    </button>
                    <!-- Settings Button (Expanded) - Al lado derecho de los otros botones -->
                    <button class="btn btn-sm btn-outline-secondary sidebar-toggle" id="widgetSettingsBtn"
                        title="Configuración de Widgets">
                        <i class="bx bx-cog"></i>
                    </button>
                </div>
            </div>
            <!-- Toggle button for collapsed state (appears below logo) -->
            <div class="sidebar-toggle-collapsed mt-3 mb-4 ms-2" style="display: none;">
                <div class="d-flex flex-column gap-2">
                    <a href="/" class="btn btn-sm btn-outline-primary w-100" title="Ir al menú principal">
                        <i class="bx bx-home"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-secondary w-100" id="sidebarToggleCollapsed"
                        title="Expandir sidebar">
                        <i class="bx bx-chevron-right"></i>
                    </button>
                    <!-- Settings Button (Collapsed) -->
                    <button class="btn btn-sm btn-outline-secondary w-100" id="widgetSettingsBtnCollapsed"
                        title="Configuración de Widgets">
                        <i class="bx bx-cog"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav flex-grow-1 p-3">
            <ul class="nav flex-column gap-2">
                <?php foreach ($navItems as $item): ?>
                <?php if (!empty($item['divider'])): ?>
                <li>
                    <hr class="sidebar-divider my-3">
                </li>
                <?php else:
                        $isAdminOnly = !empty($item['adminOnly']);
                        $liClass = $isAdminOnly ? 'nav-item admin-only' : 'nav-item';
                        $liAttrs = $isAdminOnly ? ' data-admin-only="true" style="display: none;" aria-hidden="true"' : '';
                        $activeClass = ($currentPage === $item['page']) ? ' active' : '';
                        $tabindex = $isAdminOnly ? ' tabindex="-1"' : '';
                    ?>
                <li class="<?php echo $liClass; ?>" <?php echo $liAttrs; ?>>
                    <a href="<?php echo $item['href']; ?>" class="nav-link sidebar-link<?php echo $activeClass; ?>"
                        data-page="<?php echo $item['page']; ?>" title="<?php echo htmlspecialchars($item['label']); ?>"
                        <?php echo $tabindex; ?>>
                        <i class="<?php echo $item['icon']; ?> me-3"></i>
                        <span class="sidebar-text"><?php echo htmlspecialchars($item['label']); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- User Footer Card -->
        <div class="sidebar-footer p-3 border-top">
            <!-- Layout Expandido: Avatar a la izquierda, info a la derecha -->
            <div class="user-footer-expanded">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <!-- User Avatar -->
                    <div class="user-avatar-wrapper flex-shrink-0">
                        <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                            style="width: 48px; height: 48px;" id="sidebarAvatarExpanded">
                            <img id="sidebarAvatarImgExpanded" src="/assets/img/default-avatar.png" alt="Avatar"
                                class="w-100 h-100 object-fit-cover" style="display: block;">
                            <i id="sidebarAvatarIconExpanded" class="bx bx-user text-white fs-4"
                                style="display: none;"></i>
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
                    <div class="user-avatar bg-primary rounded-circle d-inline-flex align-items-center justify-content-center overflow-hidden"
                        style="width: 48px; height: 48px;" id="sidebarAvatarCollapsed">
                        <img id="sidebarAvatarImgCollapsed" src="/assets/img/default-avatar.png" alt="Avatar"
                            class="w-100 h-100 object-fit-cover" style="display: block;">
                        <i id="sidebarAvatarIconCollapsed" class="bx bx-user text-white fs-4"
                            style="display: none;"></i>
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
            <span style="color: var(--bs-secondary);">VR-OS</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="p-3">
            <ul class="nav flex-column gap-2">
                <?php foreach ($navItems as $item): ?>
                <?php if (!empty($item['divider'])): ?>
                <li>
                    <hr class="sidebar-divider my-3">
                </li>
                <?php else:
                        $isAdminOnly = !empty($item['adminOnly']);
                        $liClass = $isAdminOnly ? 'nav-item admin-only' : 'nav-item';
                        $liAttrs = $isAdminOnly ? ' data-admin-only="true" style="display: none;" aria-hidden="true"' : '';
                        $activeClass = ($currentPage === $item['page']) ? ' active' : '';
                        $tabindex = $isAdminOnly ? ' tabindex="-1"' : '';
                    ?>
                <li class="<?php echo $liClass; ?>" <?php echo $liAttrs; ?>>
                    <a href="<?php echo $item['href']; ?>" class="nav-link sidebar-link<?php echo $activeClass; ?>"
                        data-page="<?php echo $item['page']; ?>" <?php echo $tabindex; ?>>
                        <i class="<?php echo $item['icon']; ?> me-3"></i>
                        <span><?php echo htmlspecialchars($item['label']); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
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
    position: relative;
    border: 2px solid rgba(var(--bs-primary-rgb), 0.2);
}

.sidebar-footer:hover .user-avatar {
    transform: scale(1.1);
    border-color: var(--bs-primary);
}

/* Estilos para imagen de perfil en sidebar */
.user-avatar img {
    object-fit: cover;
    object-position: center;
}

/* Mobile adjustments */
@media (max-width: 767.98px) {
    .sidebar {
        display: none !important;
    }
}

/* Ocultar por defecto los elementos reservados a administradores
   Estos elementos se mostrarán dinámicamente por RoleService cuando el
   usuario tenga permisos de admin. */
.admin-only {
    display: none;
}

/* Defender contra foco/click accidental cuando están ocultos */
.admin-only a {
    pointer-events: none;
}

/* ===================================
       SweetAlert2 - Dark/Light overrides (copiado desde users.page.php)
       Garantiza que los modales iniciados desde el sidebar respeten tema
    =================================== */
[data-bs-theme="dark"] .swal2-popup {
    background-color: #1a1d29 !important;
    color: #e9ecef !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
}

/* Título del modal */
[data-bs-theme="dark"] .swal2-title {
    color: #ffffff !important;
}

/* Contenido HTML del modal */
[data-bs-theme="dark"] .swal2-html-container {
    color: #e9ecef !important;
}

/* Textos pequeños (labels) */
[data-bs-theme="dark"] .swal2-html-container .text-muted {
    color: #adb5bd !important;
}

/* Textos con peso semibold */
[data-bs-theme="dark"] .swal2-html-container .fw-semibold {
    color: #f8f9fa !important;
}

/* Botones del modal */
[data-bs-theme="dark"] .swal2-confirm,
[data-bs-theme="dark"] .swal2-cancel {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
}

/* Botón de confirmar (primary) */
[data-bs-theme="dark"] .swal2-confirm {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

[data-bs-theme="dark"] .swal2-confirm:hover {
    background-color: #0b5ed7 !important;
    border-color: #0a58ca !important;
}

/* Botón de cancelar */
[data-bs-theme="dark"] .swal2-cancel {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: #fff !important;
}

[data-bs-theme="dark"] .swal2-cancel:hover {
    background-color: #5c636a !important;
    border-color: #565e64 !important;
}

/* Botón de cerrar (X) */
[data-bs-theme="dark"] .swal2-close {
    color: #adb5bd !important;
}

[data-bs-theme="dark"] .swal2-close:hover {
    color: #ffffff !important;
}

/* Inputs del formulario en modal */
[data-bs-theme="dark"] .swal2-input,
[data-bs-theme="dark"] .swal2-textarea,
[data-bs-theme="dark"] .swal2-select,
[data-bs-theme="dark"] .swal2-html-container input,
[data-bs-theme="dark"] .swal2-html-container textarea,
[data-bs-theme="dark"] .swal2-html-container select {
    background-color: rgba(255, 255, 255, 0.05) !important;
    color: #f8f9fa !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
}

[data-bs-theme="dark"] .swal2-input:focus,
[data-bs-theme="dark"] .swal2-textarea:focus,
[data-bs-theme="dark"] .swal2-select:focus,
[data-bs-theme="dark"] .swal2-html-container input:focus,
[data-bs-theme="dark"] .swal2-html-container textarea:focus,
[data-bs-theme="dark"] .swal2-html-container select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

/* Labels de formulario */
[data-bs-theme="dark"] .swal2-html-container label,
[data-bs-theme="dark"] .swal2-html-container .form-label {
    color: #adb5bd !important;
}

/* Placeholder de inputs */
[data-bs-theme="dark"] .swal2-input::placeholder,
[data-bs-theme="dark"] .swal2-textarea::placeholder,
[data-bs-theme="dark"] .swal2-html-container input::placeholder,
[data-bs-theme="dark"] .swal2-html-container textarea::placeholder {
    color: #6c757d !important;
}

/* Badges en modal */
[data-bs-theme="dark"] .swal2-html-container .badge {
    font-weight: 500 !important;
}

/* Loader/Loading spinner */
[data-bs-theme="dark"] .swal2-loader {
    border-color: #0d6efd transparent #0d6efd transparent !important;
}

/* Modal de confirmación de loading */
[data-bs-theme="dark"] .swal2-loading .swal2-styled {
    background-color: transparent !important;
    color: #f8f9fa !important;
}

/* Avatar circular del usuario */
[data-bs-theme="dark"] .swal2-html-container .rounded-circle {
    border: 3px solid rgba(255, 255, 255, 0.1) !important;
}

/* Dividers/Separadores */
[data-bs-theme="dark"] .swal2-html-container hr {
    border-color: rgba(255, 255, 255, 0.1) !important;
}

/* Select options en modo oscuro */
[data-bs-theme="dark"] .swal2-select option,
[data-bs-theme="dark"] .swal2-html-container select option {
    background-color: #1a1d29 !important;
    color: #f8f9fa !important;
}

/* Checkbox y radio buttons */
[data-bs-theme="dark"] .swal2-html-container input[type="checkbox"],
[data-bs-theme="dark"] .swal2-html-container input[type="radio"] {
    border-color: rgba(255, 255, 255, 0.15) !important;
}

/* Background del modal overlay */
[data-bs-theme="dark"] .swal2-container.swal2-backdrop-show {
    background: rgba(0, 0, 0, 0.7) !important;
}

/* Modo claro: asegurar contraste */
[data-bs-theme="light"] .swal2-popup {
    background-color: #ffffff !important;
    color: #212529 !important;
}

[data-bs-theme="light"] .swal2-html-container .text-muted {
    color: #6c757d !important;
}

[data-bs-theme="light"] .swal2-input,
[data-bs-theme="light"] .swal2-textarea,
[data-bs-theme="light"] .swal2-select,
[data-bs-theme="light"] .swal2-html-container input,
[data-bs-theme="light"] .swal2-html-container textarea,
[data-bs-theme="light"] .swal2-html-container select {
    background-color: #ffffff !important;
    color: #212529 !important;
    border: 1px solid #dee2e6 !important;
}

[data-bs-theme="light"] .swal2-input:focus,
[data-bs-theme="light"] .swal2-textarea:focus,
[data-bs-theme="light"] .swal2-select:focus,
[data-bs-theme="light"] .swal2-html-container input:focus,
[data-bs-theme="light"] .swal2-html-container textarea:focus,
[data-bs-theme="light"] .swal2-html-container select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}
</style>

<script>
(function() {
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
                const link = item.querySelector('a');
                if (isAdmin) {
                    // Mostrar para admins
                    item.style.display = '';
                    item.classList.remove('admin-only');
                    item.removeAttribute('aria-hidden');
                    if (link) link.removeAttribute('tabindex');
                    console.log('✅ Sidebar: Mostrando elemento admin-only');
                } else {
                    // Ocultar para usuarios regulares
                    item.style.display = 'none';
                    item.classList.add('admin-only');
                    item.setAttribute('aria-hidden', 'true');
                    if (link) link.setAttribute('tabindex', '-1');
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

            // Actualizar foto de perfil (obtener desde endpoint de perfil completo)
            try {
                const profileData = await window.AppRouter.get('/routes/profile/det_user.php');
                if (profileData && profileData.status === 'success' && profileData.data) {
                    updateSidebarAvatar(profileData.data.profile_picture);
                } else {
                    // Fallback a imagen por defecto
                    updateSidebarAvatar('/assets/img/default-avatar.png');
                }
            } catch (error) {
                console.warn('⚠️ Sidebar: No se pudo cargar foto de perfil, usando default:', error);
                updateSidebarAvatar('/assets/img/default-avatar.png');
            }

            console.log('✅ Sidebar: Información del usuario actualizada correctamente');

        } catch (error) {
            console.error('❌ Sidebar: Error al actualizar información del usuario:', error);
            sidebarUserUpdated = false; // Permitir reintento en caso de error
        }
    }

    // ===================================
    // ACTUALIZAR AVATAR EN SIDEBAR
    // ===================================
    function updateSidebarAvatar(profilePicture) {
        // Elementos del sidebar expandido
        const avatarImgExpanded = document.getElementById('sidebarAvatarImgExpanded');
        const avatarIconExpanded = document.getElementById('sidebarAvatarIconExpanded');

        // Elementos del sidebar colapsado
        const avatarImgCollapsed = document.getElementById('sidebarAvatarImgCollapsed');
        const avatarIconCollapsed = document.getElementById('sidebarAvatarIconCollapsed');

        console.log('📷 Sidebar: Actualizando avatar con:', profilePicture);
        console.log('🔍 Sidebar: Elementos encontrados:', {
            avatarImgExpanded: !!avatarImgExpanded,
            avatarIconExpanded: !!avatarIconExpanded,
            avatarImgCollapsed: !!avatarImgCollapsed,
            avatarIconCollapsed: !!avatarIconCollapsed
        });

        // Normalizar rutas incorrectas del backend (defensivo)
        if (profilePicture && !profilePicture.startsWith('/')) {
            if (profilePicture === 'default-avatar.png' || profilePicture === 'default-profile.png') {
                profilePicture = '/assets/img/default-avatar.png';
                console.log('🔧 Sidebar: Ruta normalizada a:', profilePicture);
            }
        }

        // Si no hay foto o es null/undefined
        if (!profilePicture) {
            console.log('⚠️ Sidebar: Sin foto de perfil, mostrando icono por defecto');
            avatarImgExpanded.style.display = 'none';
            avatarIconExpanded.style.display = 'block';
            avatarImgCollapsed.style.display = 'none';
            avatarIconCollapsed.style.display = 'block';
            return;
        }

        // Construir URL completa según el tipo de imagen
        let imageUrl;

        if (profilePicture === '/assets/img/default-avatar.png') {
            // Foto por defecto: Cargar desde frontend
            imageUrl = profilePicture;
            console.log('🖼️ Sidebar: Cargando imagen por defecto:', imageUrl);
        } else if (profilePicture.startsWith('/uploads/')) {
            // Foto personalizada: Cargar desde BACKEND
            const backendUrl = window.ENV_CONFIG?.BACKEND_URL || 'http://localhost:3000';
            imageUrl = backendUrl + profilePicture;
            console.log('📸 Sidebar: Cargando foto personalizada desde backend:', imageUrl);
        } else {
            // Ruta relativa o desconocida
            imageUrl = profilePicture;
            console.log('⚠️ Sidebar: Ruta desconocida, usando tal cual:', imageUrl);
        }

        // Actualizar ambas versiones del avatar (expandido y colapsado)
        avatarImgExpanded.src = imageUrl;
        avatarImgExpanded.style.display = 'block';
        avatarIconExpanded.style.display = 'none';

        avatarImgCollapsed.src = imageUrl;
        avatarImgCollapsed.style.display = 'block';
        avatarIconCollapsed.style.display = 'none';

        console.log('✅ Sidebar: Avatar actualizado en ambas versiones (expandido y colapsado)');
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
        } else if (currentPath.includes('/dashboard/homelab')) {
            activePage = 'homelab';
        } else if (currentPath.includes('/dashboard/users')) {
            activePage = 'users';
        } else if (currentPath.includes('/dashboard/files')) {
            activePage = 'files';
        } else if (currentPath.includes('/dashboard/changes')) {
            activePage = 'changes';
        } else if (currentPath.includes('/dashboard/profile')) {
            activePage = 'profile';
        } else if (currentPath.includes('/dashboard/settings')) {
            activePage = 'settings';
        } // Agregar clase active al link correspondiente
        const activeLink = document.querySelector(`.sidebar-link[data-page="${activePage}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
            console.log('✅ Sidebar: Página activa:', activePage);
        }
    }

    // ===================================
    // INICIALIZAR AL CARGAR (UNA SOLA VEZ)
    // ===================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Sidebar: DOM cargado');

        // CRÍTICO: Verificar rol SOLO AL CARGAR (NO EN SEGUNDO PLANO)
        updateSidebarByRole();

        // CRÍTICO: Actualizar información del usuario desde backend (UNA SOLA VEZ)
        updateSidebarUserInfo();

        // Resaltar página activa
        highlightActivePage();

        console.log('✅ Sidebar: Verificación única completada (sin polling en segundo plano)');
    });

    // ===================================
    // MODAL DE CONFIGURACIÓN DE WIDGETS (SWAL)
    // ===================================
    const widgetSettingsBtn = document.getElementById('widgetSettingsBtn');
    const widgetSettingsBtnCollapsed = document.getElementById('widgetSettingsBtnCollapsed');

    function openWidgetSettingsModal() {
        // Cargar preferencias actuales
        const currentTimeFormat = localStorage.getItem('widget_prefs_time_format') || '24h';
        const currentTempUnit = localStorage.getItem('widget_prefs_temp_unit') || 'C';
        const currentDateFormat = localStorage.getItem('widget_prefs_date_format') || 'DD/MM/YYYY';

        Swal.fire({
            title: '<i class="bx bx-cog me-2"></i>Configuración de Widgets',
            html: `
                    <div class="text-start">
                        <!-- Formato de Hora -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bx bx-time me-1"></i>
                                Formato de Hora
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="swal_timeFormatToggle" 
                                       ${currentTimeFormat === 'AM/PM' ? 'checked' : ''}>
                                <label class="form-check-label" for="swal_timeFormatToggle" id="swal_timeFormatLabel">
                                    ${currentTimeFormat}
                                </label>
                            </div>
                            <small class="text-muted">Alterna entre formato 12h (AM/PM) y 24h</small>
                        </div>

                        <!-- Unidades de Temperatura -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bx bx-temp me-1"></i>
                                Unidades de Temperatura
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="swal_tempUnit" id="swal_tempCelsius" value="C" 
                                       ${currentTempUnit === 'C' ? 'checked' : ''}>
                                <label class="btn btn-outline-primary btn-sm" for="swal_tempCelsius">°C</label>

                                <input type="radio" class="btn-check" name="swal_tempUnit" id="swal_tempFahrenheit" value="F"
                                       ${currentTempUnit === 'F' ? 'checked' : ''}>
                                <label class="btn btn-outline-primary btn-sm" for="swal_tempFahrenheit">°F</label>

                                <input type="radio" class="btn-check" name="swal_tempUnit" id="swal_tempKelvin" value="K"
                                       ${currentTempUnit === 'K' ? 'checked' : ''}>
                                <label class="btn btn-outline-primary btn-sm" for="swal_tempKelvin">K</label>
                            </div>
                            <small class="text-muted d-block mt-2">Celsius, Fahrenheit o Kelvin</small>
                        </div>

                        <!-- Formato de Fecha -->
                        <div class="mb-3">
                            <label for="swal_dateFormatSelect" class="form-label fw-bold">
                                <i class="bx bx-calendar me-1"></i>
                                Formato de Fecha
                            </label>
                            <select class="form-select" id="swal_dateFormatSelect">
                                <option value="DD/MM/YYYY" ${currentDateFormat === 'DD/MM/YYYY' ? 'selected' : ''}>DD/MM/YYYY (06/11/2025)</option>
                                <option value="MM/DD/YYYY" ${currentDateFormat === 'MM/DD/YYYY' ? 'selected' : ''}>MM/DD/YYYY (11/06/2025)</option>
                                <option value="YYYY-MM-DD" ${currentDateFormat === 'YYYY-MM-DD' ? 'selected' : ''}>YYYY-MM-DD (2025-11-06)</option>
                                <option value="DD-MM-YYYY" ${currentDateFormat === 'DD-MM-YYYY' ? 'selected' : ''}>DD-MM-YYYY (06-11-2025)</option>
                                <option value="YYYY/MM/DD" ${currentDateFormat === 'YYYY/MM/DD' ? 'selected' : ''}>YYYY/MM/DD (2025/11/06)</option>
                                <option value="DD MMM YYYY" ${currentDateFormat === 'DD MMM YYYY' ? 'selected' : ''}>DD MMM YYYY (06 Nov 2025)</option>
                                <option value="MMM DD, YYYY" ${currentDateFormat === 'MMM DD, YYYY' ? 'selected' : ''}>MMM DD, YYYY (Nov 06, 2025)</option>
                            </select>
                            <small class="text-muted d-block mt-2">Selecciona cómo se muestran las fechas</small>
                        </div>
                    </div>
                `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: '<i class="bx bx-save me-1"></i>Guardar',
            cancelButtonText: 'Cancelar',
            showDenyButton: true,
            denyButtonText: '<i class="bx bx-reset me-1"></i>Resetear',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary',
                denyButton: 'btn btn-outline-secondary'
            },
            buttonsStyling: false,
            didOpen: () => {
                // Toggle para cambiar label de formato de hora
                const toggle = document.getElementById('swal_timeFormatToggle');
                const label = document.getElementById('swal_timeFormatLabel');

                toggle.addEventListener('change', function() {
                    label.textContent = this.checked ? 'AM/PM' : '24h';
                });
            },
            preConfirm: () => {
                // Obtener valores del formulario
                const timeFormat = document.getElementById('swal_timeFormatToggle').checked ? 'AM/PM' :
                    '24h';
                const tempUnit = document.querySelector('input[name="swal_tempUnit"]:checked')?.value ||
                    'C';
                const dateFormat = document.getElementById('swal_dateFormatSelect').value;

                return {
                    timeFormat,
                    tempUnit,
                    dateFormat
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Guardar preferencias
                const {
                    timeFormat,
                    tempUnit,
                    dateFormat
                } = result.value;

                localStorage.setItem('widget_prefs_time_format', timeFormat);
                localStorage.setItem('widget_prefs_temp_unit', tempUnit);
                localStorage.setItem('widget_prefs_date_format', dateFormat);

                console.log('💾 Preferencias guardadas:', {
                    timeFormat,
                    tempUnit,
                    dateFormat
                });

                // Disparar evento para recargar widgets
                window.dispatchEvent(new CustomEvent('widgetPreferencesChanged', {
                    detail: {
                        timeFormat,
                        tempUnit,
                        dateFormat
                    }
                }));

                // Recargar widgets
                if (window.ClockService) {
                    window.ClockService.updateDateTime();
                }
                if (window.WeatherService && typeof updateWeatherWidget === 'function') {
                    updateWeatherWidget();
                }

                // Mostrar notificación
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'Preferencias guardadas exitosamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else if (result.isDenied) {
                // Resetear preferencias
                localStorage.removeItem('widget_prefs_time_format');
                localStorage.removeItem('widget_prefs_temp_unit');
                localStorage.removeItem('widget_prefs_date_format');

                console.log('🔄 Preferencias reseteadas a valores por defecto');

                // Disparar evento
                window.dispatchEvent(new CustomEvent('widgetPreferencesChanged', {
                    detail: {
                        timeFormat: '24h',
                        tempUnit: 'C',
                        dateFormat: 'DD/MM/YYYY'
                    }
                }));

                // Recargar widgets
                if (window.ClockService) {
                    window.ClockService.updateDateTime();
                }
                if (window.WeatherService && typeof updateWeatherWidget === 'function') {
                    updateWeatherWidget();
                }

                // Mostrar notificación
                Swal.fire({
                    icon: 'info',
                    title: 'Reseteado',
                    text: 'Preferencias reseteadas a valores por defecto',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Agregar event listeners a ambos botones
    if (widgetSettingsBtn) {
        widgetSettingsBtn.addEventListener('click', openWidgetSettingsModal);
        console.log('✅ Sidebar: Modal de settings vinculado (expandido)');
    }

    if (widgetSettingsBtnCollapsed) {
        widgetSettingsBtnCollapsed.addEventListener('click', openWidgetSettingsModal);
        console.log('✅ Sidebar: Modal de settings vinculado (colapsado)');
    }

})();
</script>