<?php
/**
 * Vista: Dashboard
 * Dashboard unificado para usuarios y administradores
 * Usa sessionCheck.js y roleCheck.js para determinar permisos
 * Sistema de páginas dinámicas desde /pages
 * HomeLab AR - Roepard Labs
 */

// NOTA: NO verificamos autenticación con PHP porque frontend no puede leer
// las sesiones del backend (puertos diferentes). La verificación se hace con
// JavaScript usando SessionService que SÍ puede comunicarse con el backend.
// session_start() ya se ejecutó en index.php

require_once __DIR__ . '/../layout/AppLayout.php';

// Datos del usuario (pueden estar indefinidos en frontend)
// Estos valores son placeholders, los reales vienen del backend vía JavaScript
$userName = $_SESSION['user_name'] ?? 'Usuario';
$userFirstName = explode(' ', $userName)[0];
$userRole = $_SESSION['role_id'] ?? 1;

// ===================================
// SISTEMA DE PÁGINAS DINÁMICAS
// ===================================

// Obtener la ruta actual para determinar qué página cargar
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Determinar qué página cargar desde /pages
$dashboardPage = null;

if ($currentPath === '/dashboard/users') {
    $dashboardPage = 'users.page.php';
} elseif ($currentPath === '/dashboard/settings') {
    $dashboardPage = 'settings.page.php';
} elseif ($currentPath === '/dashboard/profile') {
    $dashboardPage = 'profile.page.php';
} elseif ($currentPath === '/dashboard/files') {
    $dashboardPage = 'files.page.php';
}

// Configuración de la página
$pageConfig = [
    'title' => 'Mi Dashboard - HomeLab AR | Roepard Labs',
    'description' => 'Panel de control de HomeLab AR',
    'keywords' => 'dashboard, panel, control, homelab',
    'includeHeader' => false,  // Dashboard tiene su propio navbar
    'includeFooter' => false,  // Dashboard no necesita footer
    'css' => ['chart'],
    'js' => ['chart']
];

// Capturar contenido del dashboard
ob_start();
?>

<!-- Layout con Sidebar -->
<div class="dashboard-layout">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../ui/sidebar.ui.php'; ?>

    <!-- Main Content Area -->
    <div class="main-content">

        <!-- Navbar/Breadcrumb (Siempre visible en todas las páginas) -->
        <?php include __DIR__ . '/../ui/navbar.ui.php'; ?>

        <?php if ($dashboardPage): ?>
            <!-- RENDERIZAR PÁGINA DESDE /pages -->
            <div class="container-fluid py-4">
                <?php
                $pagePath = __DIR__ . '/../pages/' . $dashboardPage;
                if (file_exists($pagePath)) {
                    include $pagePath;
                } else {
                    echo '<div class="alert alert-danger">Página no encontrada: ' . htmlspecialchars($dashboardPage) . '</div>';
                }
                ?>
            </div>
        <?php else: ?>

            <!-- Dashboard Content -->
            <div class="container-fluid p-4">

                <!-- Welcome Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="welcome-card p-4 rounded"
                            style="background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%); color: white;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="welcome-icon bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bx bx-home-heart" style="font-size: 2.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="mb-2 fw-bold" id="welcomeTitle">¡Bienvenido de nuevo! 👋</h2>
                                    <p class="mb-0 opacity-75" style="font-size: 1.1rem;" id="welcomeSubtitle">
                                        Cargando información...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Quick Stats Row -->
                <div class="row g-4 mb-4">

                    <!-- Total Usuarios -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Total Usuarios</p>
                                    <h3 class="mb-0 fw-bold" id="totalUsers">--</h3>
                                </div>
                                <div class="stat-icon bg-primary bg-opacity-10 rounded p-3">
                                    <i class="bx bx-user" style="font-size: 1.5rem; color: var(--bs-primary);"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-success">
                                    <i class="bx bx-up-arrow-alt"></i> 12% este mes
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Usuarios Activos -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Usuarios Activos</p>
                                    <h3 class="mb-0 fw-bold" id="activeUsers">--</h3>
                                </div>
                                <div class="stat-icon bg-success bg-opacity-10 rounded p-3">
                                    <i class="bx bx-check-circle" style="font-size: 1.5rem; color: var(--bs-success);"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-success">
                                    <i class="bx bx-up-arrow-alt"></i> 8% este mes
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Sesiones Hoy -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Sesiones Hoy</p>
                                    <h3 class="mb-0 fw-bold" id="sessionsToday">--</h3>
                                </div>
                                <div class="stat-icon bg-info bg-opacity-10 rounded p-3">
                                    <i class="bx bx-time-five" style="font-size: 1.5rem; color: var(--bs-info);"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-info">
                                    <i class="bx bx-trending-up"></i> Promedio: 42
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Sistema -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Estado Sistema</p>
                                    <h3 class="mb-0 fw-bold text-success">Operativo</h3>
                                </div>
                                <div class="stat-icon bg-success bg-opacity-10 rounded p-3">
                                    <i class="bx bx-server" style="font-size: 1.5rem; color: var(--bs-success);"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-muted">
                                    <i class="bx bx-chip"></i> 99.9% uptime
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Main Content Row -->
                <div class="row g-4">

                    <!-- Left Column: Quick Actions -->
                    <div class="col-12 col-lg-8">
                        <div class="card border-0 shadow-sm h-100" style="background-color: var(--bs-body-bg);">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bx bx-bolt-circle me-2 text-primary"></i>
                                    Acciones Rápidas
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Contenido dinámico según rol -->
                                <div id="quickActionsContent">
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <p class="text-muted mt-3">Cargando acciones...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: System Info -->
                    <div class="col-12 col-lg-4">
                        <div class="card border-0 shadow-sm h-100" style="background-color: var(--bs-body-bg);">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bx bx-info-circle me-2 text-primary"></i>
                                    Información del Sistema
                                </h5>
                            </div>
                            <div class="card-body p-4">

                                <!-- Server Status -->
                                <div class="info-item mb-4 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Estado del Servidor</span>
                                        <span class="badge bg-success">Online</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>

                                <!-- Database -->
                                <div class="info-item mb-4 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Base de Datos</span>
                                        <span class="badge bg-success">Conectada</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bx bx-data"></i> MySQL 8.0
                                    </small>
                                </div>

                                <!-- API Status -->
                                <div class="info-item mb-4 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">API Backend</span>
                                        <span class="badge bg-success" id="apiStatus">Verificando...</span>
                                    </div>
                                    <small class="text-muted" id="apiUrl">
                                        <i class="bx bx-link"></i> --
                                    </small>
                                </div>

                                <!-- Version -->
                                <div class="info-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Versión</span>
                                        <span class="fw-bold">v1.0.0</span>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bx bx-git-branch"></i> HomeLab AR
                                    </small>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        <?php endif; ?>
        <!-- FIN: Condicional de páginas dinámicas -->

    </div>

</div>

<style>
    /* ===================================
   DASHBOARD LAYOUT STYLES
   Usa variables de variables.css, base.css y main.css
=================================== */

    /* Dashboard Layout */
    .dashboard-layout {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        margin-left: 280px;
        min-height: 100vh;
        background-color: var(--bs-body-bg);
        transition: margin-left 0.3s ease;
    }

    /* Sidebar Collapsed State */
    .dashboard-layout.sidebar-collapsed .main-content {
        margin-left: 80px;
    }

    /* Stat Cards - Apilar verticalmente cuando sidebar está colapsado */
    @media (min-width: 992px) {
        .dashboard-layout.sidebar-collapsed .col-lg-3 {
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .dashboard-layout.sidebar-collapsed .col-lg-4 {
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
    }

    /* Smooth transition for column changes */
    .dashboard-layout .col-lg-3,
    .dashboard-layout .col-lg-4 {
        transition: max-width 0.3s ease, flex 0.3s ease;
    }

    /* ===================================
   WELCOME CARD
=================================== */
    .welcome-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
        overflow: hidden;
        position: relative;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .welcome-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .welcome-icon {
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    /* ===================================
   STAT CARDS
=================================== */
    .stat-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .stat-footer {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--bs-border-color);
    }

    /* ===================================
   QUICK ACTION CARDS
=================================== */
    .quick-action-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .quick-action-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-color: var(--bs-primary) !important;
    }

    .action-icon {
        transition: transform 0.2s ease;
    }

    .quick-action-card:hover .action-icon {
        transform: scale(1.1);
    }

    /* ===================================
   INFO ITEMS
=================================== */
    .info-item {
        transition: all 0.2s ease;
    }

    .info-item:hover {
        padding-left: 0.5rem;
    }

    .info-item .progress {
        border-radius: 3px;
        overflow: hidden;
        background-color: var(--bs-tertiary-bg);
    }

    .info-item .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
    }

    /* ===================================
   ANIMATIONS
=================================== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }

    /* ===================================
   CARDS
=================================== */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* ===================================
   RESPONSIVE
=================================== */
    @media (max-width: 991.98px) {
        .main-content {
            margin-left: 0;
            padding-top: 60px;
        }
    }

    @media (max-width: 767.98px) {
        .main-content {
            margin-left: 0;
        }

        .welcome-card h2 {
            font-size: 1.5rem !important;
        }

        .welcome-card p {
            font-size: 0.9rem !important;
        }

        .welcome-icon {
            width: 60px !important;
            height: 60px !important;
        }

        .welcome-icon i {
            font-size: 2rem !important;
        }

        .stat-card h3 {
            font-size: 1.5rem;
        }

        .quick-action-card {
            padding: 1rem !important;
        }

        .action-icon {
            padding: 0.5rem !important;
        }

        .action-icon i {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 575.98px) {
        .dashboard-layout {
            padding: 0.5rem;
        }

        .container-fluid {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        .stat-card {
            padding: 1rem !important;
        }
    }

    /* ===================================
   DARK MODE ADJUSTMENTS
   Usa variables CSS de variables.css
=================================== */
    [data-bs-theme="dark"] .welcome-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    [data-bs-theme="dark"] .stat-card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    [data-bs-theme="dark"] .stat-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    [data-bs-theme="dark"] .quick-action-card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    [data-bs-theme="dark"] .quick-action-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* ===================================
   UTILITIES
=================================== */
    .bg-opacity-10 {
        opacity: 0.1;
    }

    .fw-bold {
        font-weight: 700 !important;
    }

    .text-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===================================
   SESSION CARDS - Profile Page
=================================== */
    .session-card {
        transition: all 0.3s ease;
    }

    .session-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .session-icon {
        transition: transform 0.3s ease;
    }

    .session-card:hover .session-icon {
        transform: scale(1.1);
    }

    .btn-close-session {
        opacity: 0.7;
        transition: all 0.2s ease;
    }

    .btn-close-session:hover {
        opacity: 1;
        transform: scale(1.1);
    }
</style>

<!-- Sessions Management Service -->
<script src="../js/sessions.js"></script>

<script>
    (function () {
        'use strict';

        console.log('📊 Dashboard: Inicializando con SessionService y RoleService');

        // Contador de reintentos para evitar bucles infinitos
        let verifyAuthRetries = 0;
        const MAX_VERIFY_RETRIES = 10; // Máximo 3 segundos de espera

        // ===================================
        // VERIFICAR AUTENTICACIÓN (CRÍTICO)
        // ===================================
        async function verifyAuthentication() {
            console.log('🔐 Dashboard: Verificando autenticación con backend...');

            // Esperar a que SessionService esté disponible
            if (!window.SessionService) {
                verifyAuthRetries++;
                if (verifyAuthRetries >= MAX_VERIFY_RETRIES) {
                    console.error('❌ Dashboard: SessionService no disponible después de', MAX_VERIFY_RETRIES,
                        'intentos');
                    console.error('❌ Redirigiendo a home por timeout...');
                    window.location.href = '/';
                    return;
                }
                console.warn('⏳ Dashboard: Esperando a SessionService... Intento', verifyAuthRetries, 'de',
                    MAX_VERIFY_RETRIES);
                setTimeout(verifyAuthentication, 300);
                return;
            }

            try {
                const sessionStatus = await window.SessionService.check();

                console.log('📊 Dashboard: Estado de sesión:', sessionStatus);

                if (!sessionStatus.isAuthenticated) {
                    console.warn('❌ Dashboard: Usuario NO autenticado, redirigiendo a home...');
                    window.location.href = '/';
                    return;
                }

                console.log('✅ Dashboard: Usuario autenticado, cargando contenido...');

                // Inicializar resto del dashboard
                checkBackendStatus();
                loadStats();
                updateDashboardContent();

            } catch (error) {
                console.error('❌ Dashboard: Error al verificar autenticación:', error);
                console.warn('🔄 Dashboard: Redirigiendo a home por error...');
                window.location.href = '/';
            }
        }

        // ===================================
        // VERIFICAR ESTADO DEL BACKEND (UNA SOLA VEZ AL CARGAR)
        // ===================================
        let backendStatusChecked = false; // Flag para evitar verificaciones múltiples

        function checkBackendStatus() {
            // Evitar verificaciones duplicadas
            if (backendStatusChecked) {
                console.log('⏭️ Backend ya verificado, saltando verificación duplicada');
                return;
            }

            backendStatusChecked = true;

            const apiUrl = window.ENV_CONFIG?.API_URL || window.AppRouter?.baseURL || 'http://localhost:3000';

            const apiUrlElement = document.getElementById('apiUrl');
            if (apiUrlElement) {
                apiUrlElement.innerHTML = `<i class="bx bx-link"></i> ${apiUrl}`;
            }

            if (window.AppRouter) {
                console.log('🔍 Verificando estado del backend (una sola vez)...');
                window.AppRouter.get('/routes/user/check_session.php')
                    .then(data => {
                        const apiStatus = document.getElementById('apiStatus');
                        if (apiStatus) {
                            apiStatus.textContent = 'Online';
                            apiStatus.className = 'badge bg-success';
                        }
                        console.log('✅ Backend API: Online');
                    })
                    .catch(error => {
                        const apiStatus = document.getElementById('apiStatus');
                        if (apiStatus) {
                            apiStatus.textContent = 'Offline';
                            apiStatus.className = 'badge bg-danger';
                        }
                        console.error('❌ Backend API: Offline', error);
                    });
            }
        }

        // ===================================
        // CARGAR ESTADÍSTICAS (UNA SOLA VEZ AL CARGAR)
        // ===================================
        let statsLoaded = false; // Flag para evitar cargas múltiples

        function loadStats() {
            // Evitar cargas duplicadas de estadísticas
            if (statsLoaded) {
                console.log('⏭️ Estadísticas ya cargadas, saltando carga duplicada');
                return;
            }

            statsLoaded = true;
            console.log('📊 Cargando estadísticas (una sola vez)...');

            // Simulación de datos (reemplazar con llamadas reales a la API)
            setTimeout(() => {
                const totalUsers = document.getElementById('totalUsers');
                const activeUsers = document.getElementById('activeUsers');
                const sessionsToday = document.getElementById('sessionsToday');

                if (totalUsers) totalUsers.textContent = '156';
                if (activeUsers) activeUsers.textContent = '142';
                if (sessionsToday) sessionsToday.textContent = '48';

                console.log('✅ Estadísticas cargadas correctamente');
            }, 500);
        }

        // Contador de reintentos para updateDashboardContent
        let updateContentRetries = 0;
        const MAX_UPDATE_RETRIES = 10; // Máximo 3 segundos de espera

        // ===================================
        // ACTUALIZAR CONTENIDO SEGÚN ROL
        // ===================================
        async function updateDashboardContent() {
            console.log('🔄 Actualizando dashboard según rol...');

            // Esperar a que SessionService y RoleService estén listos
            if (!window.SessionService || !window.RoleService) {
                updateContentRetries++;
                if (updateContentRetries >= MAX_UPDATE_RETRIES) {
                    console.error('❌ Dashboard: Services no disponibles después de', MAX_UPDATE_RETRIES,
                        'intentos');
                    console.warn('⚠️ Cargando dashboard con datos por defecto...');
                    updateWelcomeMessage('Usuario', false);
                    loadQuickActions(false);
                    return;
                }
                console.warn('⏳ Esperando a SessionService y RoleService... Intento', updateContentRetries, 'de',
                    MAX_UPDATE_RETRIES);
                setTimeout(updateDashboardContent, 300);
                return;
            }

            try {
                // Verificar sesión y rol
                const sessionStatus = await window.SessionService.check();
                const roleStatus = await window.RoleService.check();

                console.log('📊 Session Status:', sessionStatus);
                console.log('👔 Role Status:', roleStatus);

                // Si no está autenticado, redirigir
                if (!sessionStatus.isAuthenticated) {
                    console.log('❌ Usuario no autenticado, redirigiendo...');
                    window.location.href = '/';
                    return;
                }

                // Obtener datos del usuario
                const userData = sessionStatus.userData || {};
                const userName = userData.first_name || userData.user_name || 'Usuario';
                const userFirstName = userName.split(' ')[0];
                const isAdmin = roleStatus.isAdmin;

                console.log('👤 Usuario:', userFirstName, '| Admin:', isAdmin);

                // Actualizar mensaje de bienvenida
                updateWelcomeMessage(userFirstName, isAdmin);

                // Cargar acciones rápidas según rol
                loadQuickActions(isAdmin);

                console.log('✅ Dashboard actualizado correctamente');

            } catch (error) {
                console.error('❌ Error al actualizar dashboard:', error);
                // En caso de error, mostrar mensaje genérico
                updateWelcomeMessage('Usuario', false);
                loadQuickActions(false);
            }
        }

        // ===================================
        // ACTUALIZAR MENSAJE DE BIENVENIDA
        // ===================================
        function updateWelcomeMessage(firstName, isAdmin) {
            const welcomeTitle = document.getElementById('welcomeTitle');
            const welcomeSubtitle = document.getElementById('welcomeSubtitle');

            if (welcomeTitle) {
                welcomeTitle.textContent = `¡Bienvenido de nuevo, ${firstName}! 👋`;
            }

            if (welcomeSubtitle) {
                if (isAdmin) {
                    welcomeSubtitle.textContent =
                        'Este es tu panel de control administrativo. Desde aquí puedes gestionar usuarios, configuraciones y monitorear el sistema.';
                } else {
                    welcomeSubtitle.textContent =
                        'Este es tu panel de control personal. Desde aquí puedes gestionar tus proyectos y acceder a todas las funcionalidades.';
                }
            }
        }

        // ===================================
        // VERIFICAR SESIÓN MANUALMENTE (SOLO AL HACER CLICK)
        // ===================================
        async function verifySessionOnClick(event, targetUrl) {
            // Solo verificar para rutas protegidas
            const protectedRoutes = ['/admin/users', '/settings', '/projects'];

            if (!protectedRoutes.includes(targetUrl)) {
                // Ruta no protegida, permitir navegación normal
                return true;
            }

            event.preventDefault();
            console.log('🔒 Verificando sesión antes de navegar a:', targetUrl);

            try {
                const sessionStatus = await window.SessionService.check();

                if (!sessionStatus.isAuthenticated) {
                    console.warn('❌ Sesión expirada, redirigiendo a home...');
                    window.location.href = '/';
                    return false;
                }

                console.log('✅ Sesión válida, navegando a:', targetUrl);
                window.location.href = targetUrl;
                return true;

            } catch (error) {
                console.error('❌ Error al verificar sesión:', error);
                window.location.href = '/';
                return false;
            }
        }

        // ===================================
        // CARGAR ACCIONES RÁPIDAS SEGÚN ROL
        // ===================================
        function loadQuickActions(isAdmin) {
            const container = document.getElementById('quickActionsContent');
            if (!container) return;

            let actionsHTML = '<div class="row g-3">';

            if (isAdmin) {
                // Acciones para administrador (CON verificación al hacer click)
                actionsHTML += `
                    <!-- Ver Usuarios -->
                    <div class="col-12 col-sm-6">
                        <a href="#" data-route="/admin/users" class="quick-action-card protected-route d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-primary bg-opacity-10 rounded p-3">
                                    <i class="bx bx-user-circle" style="font-size: 2rem; color: var(--bs-primary);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Gestionar Usuarios</h6>
                                    <small class="text-muted">Ver y editar usuarios</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Configuración -->
                    <div class="col-12 col-sm-6">
                        <a href="#" data-route="/settings" class="quick-action-card protected-route d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-success bg-opacity-10 rounded p-3">
                                    <i class="bx bx-cog" style="font-size: 2rem; color: var(--bs-success);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Configuración</h6>
                                    <small class="text-muted">Ajustes del sistema</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- HomeLab VR (sin verificación, ruta pública) -->
                    <div class="col-12 col-sm-6">
                        <a href="/homelab" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-info bg-opacity-10 rounded p-3">
                                    <i class="bx bx-cube" style="font-size: 2rem; color: var(--bs-info);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">HomeLab VR</h6>
                                    <small class="text-muted">Experiencia inmersiva</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Volver al Home (sin verificación, ruta pública) -->
                    <div class="col-12 col-sm-6">
                        <a href="/" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-warning bg-opacity-10 rounded p-3">
                                    <i class="bx bx-home-alt" style="font-size: 2rem; color: var(--bs-warning);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Página Principal</h6>
                                    <small class="text-muted">Volver al inicio</small>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            } else {
                // Acciones para usuario regular (CON verificación al hacer click)
                actionsHTML += `
                    <!-- Mis Proyectos -->
                    <div class="col-12 col-sm-6">
                        <a href="#" data-route="/projects" class="quick-action-card protected-route d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-primary bg-opacity-10 rounded p-3">
                                    <i class="bx bx-folder" style="font-size: 2rem; color: var(--bs-primary);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Mis Proyectos</h6>
                                    <small class="text-muted">Ver tus proyectos</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Configuración -->
                    <div class="col-12 col-sm-6">
                        <a href="#" data-route="/settings" class="quick-action-card protected-route d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-success bg-opacity-10 rounded p-3">
                                    <i class="bx bx-cog" style="font-size: 2rem; color: var(--bs-success);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Configuración</h6>
                                    <small class="text-muted">Ajustes personales</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- HomeLab VR (sin verificación, ruta pública) -->
                    <div class="col-12 col-sm-6">
                        <a href="/homelab" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-info bg-opacity-10 rounded p-3">
                                    <i class="bx bx-cube" style="font-size: 2rem; color: var(--bs-info);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">HomeLab VR</h6>
                                    <small class="text-muted">Experiencia inmersiva</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Volver al Home (sin verificación, ruta pública) -->
                    <div class="col-12 col-sm-6">
                        <a href="/" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon bg-warning bg-opacity-10 rounded p-3">
                                    <i class="bx bx-home-alt" style="font-size: 2rem; color: var(--bs-warning);"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Página Principal</h6>
                                    <small class="text-muted">Volver al inicio</small>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
            }

            actionsHTML += '</div>';
            container.innerHTML = actionsHTML;

            // ===================================
            // AGREGAR EVENT LISTENERS A RUTAS PROTEGIDAS
            // ===================================
            setTimeout(() => {
                const protectedLinks = document.querySelectorAll('.protected-route');
                protectedLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        const targetUrl = this.getAttribute('data-route');
                        verifySessionOnClick(event, targetUrl);
                    });
                });
                console.log('✅ Event listeners agregados a', protectedLinks.length, 'rutas protegidas');
            }, 100);
        }

        // ===================================
        // DESACTIVADO: Eventos de sesión/rol en tiempo real
        // MOTIVO: Ejecutar verificaciones constantemente colapsará el servidor
        // SOLUCIÓN: Solo verificar al cargar y cuando usuario hace click en acciones
        // ===================================
        /*
            window.addEventListener('sessionChanged', function (event) {
                console.log('🔔 Dashboard: Evento sessionChanged recibido', event.detail);
                if (event.detail.isAuthenticated && !event.detail.checking) {
                    updateDashboardContent();
                }
            });
        
            window.addEventListener('roleChanged', function (event) {
                console.log('🔔 Dashboard: Evento roleChanged recibido', event.detail);
                if (!event.detail.checking) {
                    updateDashboardContent();
                }
            });
            */

        // ===================================
        // INICIALIZAR AL CARGAR (UNA SOLA VEZ)
        // ===================================
        document.addEventListener('DOMContentLoaded', function () {
            console.log('🚀 Dashboard: DOM cargado');

            // CRÍTICO: Verificar autenticación SOLO AL CARGAR (NO EN SEGUNDO PLANO)
            // Si no está autenticado, redirige a home automáticamente
            verifyAuthentication();

            console.log('✅ Dashboard: Verificación única completada (sin polling en segundo plano)');
        });

    })();
</script>

<?php
$content = ob_get_clean();

// CRÍTICO: Pasar NULL como vista para evitar bucle infinito
// Ya tenemos el contenido capturado en $content, no necesitamos incluir la vista de nuevo
AppLayout::render(null, ['content' => $content], $pageConfig);
?>