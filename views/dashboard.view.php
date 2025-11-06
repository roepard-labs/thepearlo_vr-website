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

// Determinar qué página cargar desde /pages y sus dependencias
$dashboardPage = null;
$additionalCss = [];
$additionalJs = [];

if ($currentPath === '/dashboard/users') {
    $dashboardPage = 'users.page.php';
    // Dependencias específicas para la página de usuarios
    $additionalCss = ['datatables', 'datatablesResponsive'];
    $additionalJs = ['datatables', 'datatablesBS5', 'datatablesResponsive'];
} elseif ($currentPath === '/dashboard/settings') {
    $dashboardPage = 'settings.page.php';
    // Sin dependencias adicionales
} elseif ($currentPath === '/dashboard/profile') {
    $dashboardPage = 'profile.page.php';
    // Dependencias específicas para la página de perfil
    $additionalCss = ['filepond', 'filepondImagePreview'];
    $additionalJs = [
        'filepond',
        'filepondImagePreview',
        'filepondImageExif',
        'filepondImageTransform',
        'filepondImageCrop',
        'filepondImageResize',
        'filepondImageValidateSize',
        'filepondImageEdit'
    ];
} elseif ($currentPath === '/dashboard/files') {
    $dashboardPage = 'files.page.php';
    // Dependencias específicas para la página de archivos
    $additionalCss = ['filepond', 'filepondImagePreview'];
    $additionalJs = [
        'filepond',
        'filepondImagePreview',
        'filepondImageExif',
        'filepondImageTransform',
        'filepondImageCrop',
        'filepondImageResize',
        'filepondImageValidateSize',
        'filepondImageEdit'
    ];
} elseif ($currentPath === '/dashboard/changes') {
    $dashboardPage = 'changes.page.php';
    // Dependencias específicas para la página de cambios
    $additionalCss = ['datatables', 'datatablesResponsive'];
    $additionalJs = ['datatables', 'datatablesBS5', 'datatablesResponsive'];
}

// Configuración de la página con dependencias dinámicas
$pageConfig = [
    'title' => 'Mi Dashboard - HomeLab AR | Roepard Labs',
    'description' => 'Panel de control de HomeLab AR',
    'keywords' => 'dashboard, panel, control, homelab',
    'includeHeader' => false,  // Dashboard tiene su propio navbar
    'includeFooter' => false,  // Dashboard no necesita footer
    'additionalCss' => $additionalCss, // Solo CSS específico de cada página (Chart.js no tiene CSS)
    'additionalJs' => array_merge(['chart'], $additionalJs) // Chart.js solo tiene JS
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

            <!-- Welcome & Session Info Section -->
            <div class="row mb-4">
                <!-- Welcome Card (50%) -->
                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                    <div class="welcome-card h-100 p-4 rounded"
                        style="background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%); color: white;">
                        <div>
                            <h3 class="mb-2 fw-bold" id="welcomeTitle">¡Bienvenido de nuevo! 👋</h3>
                            <p class="mb-0 opacity-75" id="welcomeSubtitle">
                                Cargando información...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Current Session Info (50%) -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0" style="background: rgba(var(--bs-success-rgb), 0.1);">
                        <div class="card-body p-4">
                            <h6 class="text-success mb-3">
                                <i class="bx bx-check-circle"></i> Sesión Activa
                            </h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Dispositivo</small>
                                    <strong id="currentDevice" class="small">--</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Navegador</small>
                                    <strong id="currentBrowser" class="small">--</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">IP</small>
                                    <strong id="currentIP" class="small">--</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Inicio</small>
                                    <strong id="sessionStart" class="small">--</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Row -->
                <div class="row g-4 mb-4">

                    <!-- Total Usuarios -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Total Usuarios</p>
                                    <h3 class="mb-0 fw-bold" id="totalUsers">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </h3>
                                </div>
                                <div class="stat-icon rounded p-3"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bx bx-user" style="font-size: 1.5rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-muted" id="totalUsersDetail">Cargando...</small>
                            </div>
                        </div>
                    </div>

                    <!-- Sesiones Activas -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Sesiones Activas</p>
                                    <h3 class="mb-0 fw-bold" id="activeSessions">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </h3>
                                </div>
                                <div class="stat-icon rounded p-3"
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="bx bx-time-five" style="font-size: 1.5rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-muted" id="activeSessionsDetail">Cargando...</small>
                            </div>
                        </div>
                    </div>

                    <!-- Archivos Subidos -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Archivos</p>
                                    <h3 class="mb-0 fw-bold" id="totalFiles">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </h3>
                                </div>
                                <div class="stat-icon rounded p-3"
                                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <i class="bx bx-file" style="font-size: 1.5rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-muted" id="totalFilesDetail">Cargando...</small>
                            </div>
                        </div>
                    </div>

                    <!-- Logins Esta Semana -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="stat-card h-100 p-4 rounded"
                            style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">Logins (7 días)</p>
                                    <h3 class="mb-0 fw-bold" id="loginsWeek">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </h3>
                                </div>
                                <div class="stat-icon rounded p-3"
                                    style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                    <i class="bx bx-trending-up" style="font-size: 1.5rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="stat-footer">
                                <small class="text-muted" id="loginsWeekDetail">Cargando...</small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Charts Row - Solo para administradores -->
                <div class="row g-4 mb-4" id="adminChartsSection">
                    <!-- Gráfica: Sesiones por Día -->
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bx bx-line-chart me-2 text-primary"></i>
                                    Sesiones Últimos 7 Días
                                </h5>
                            </div>
                            <div class="card-body">
                                <canvas id="sessionsChart" style="max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfica: Usuarios por Rol -->
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bx bx-pie-chart-alt me-2 text-primary"></i>
                                    Distribución por Rol
                                </h5>
                            </div>
                            <div class="card-body">
                                <canvas id="rolesChart" style="max-height: 300px;"></canvas>
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

                                <!-- Versión y Repositorios -->
                                <div class="info-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Versión</span>
                                        <span class="fw-bold" id="systemVersion">v0.0.0</span>
                                    </div>
                                    <small class="text-muted d-block mb-2">
                                        <i class="bx bx-git-branch"></i> HomeLab AR
                                    </small>

                                    <!-- GitHub Repos -->
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        <!-- Website -->
                                        <a href="https://github.com/roepard-labs/thepearlo_vr-website" target="_blank"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                            title="Website Repository">
                                            <i class="bx bxl-github"></i> Website
                                        </a>
                                        <!-- Backend -->
                                        <a href="https://github.com/roepard-labs/thepearlo_vr-backend" target="_blank"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                            title="Backend Repository">
                                            <i class="bx bxl-github"></i> Backend
                                        </a>
                                        <!-- AppStore -->
                                        <a href="https://github.com/roepard-labs/thepearlo_vr-appstore" target="_blank"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                            title="AppStore Repository">
                                            <i class="bx bxl-github"></i> AppStore
                                        </a>
                                        <!-- Networked -->
                                        <a href="https://github.com/roepard-labs/thepearlo_vr-networked" target="_blank"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                            title="Networked Repository">
                                            <i class="bx bxl-github"></i> Networked
                                        </a>
                                        <!-- Docs -->
                                        <a href="https://github.com/roepard-labs/docs" target="_blank"
                                            class="btn btn-sm btn-outline-secondary"
                                            style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                            title="Documentation Repository">
                                            <i class="bx bxl-github"></i> Docs
                                        </a>
                                    </div>
                                </div>

                                <!-- Diagnostic Button -->
                                <div class="d-grid">
                                    <button class="btn btn-sm btn-outline-primary" id="diagnosticBtn"
                                        data-bs-toggle="modal" data-bs-target="#diagnosticModal">
                                        <i class="bx bx-health"></i> Diagnóstico del Sistema
                                    </button>
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

    <!-- Modal: Diagnóstico del Sistema -->
    <div class="modal fade" id="diagnosticModal" tabindex="-1" aria-labelledby="diagnosticModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="diagnosticModalLabel">
                        <i class="bx bx-health text-primary"></i> Diagnóstico del Sistema
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="diagnosticContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Ejecutando diagnóstico...</span>
                        </div>
                        <p class="text-muted mt-3">Ejecutando diagnóstico del sistema...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="refreshDiagnostic">
                        <i class="bx bx-refresh"></i> Actualizar
                    </button>
                </div>
            </div>
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
    (function() {
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
                loadStats();
                loadCurrentSession();
                updateDashboardContent();

            } catch (error) {
                console.error('❌ Dashboard: Error al verificar autenticación:', error);
                console.warn('🔄 Dashboard: Redirigiendo a home por error...');
                window.location.href = '/';
            }
        }

        // ===================================
        // CARGAR ESTADÍSTICAS REALES
        // ===================================
        let statsLoaded = false;
        let dashboardCharts = {}; // Almacenar instancias de gráficas

        async function loadStats() {
            if (statsLoaded) {
                console.log('⏭️ Estadísticas ya cargadas, saltando carga duplicada');
                return;
            }

            statsLoaded = true;
            console.log('📊 Cargando estadísticas reales desde API...');

            if (!window.AppRouter) {
                console.error('❌ AppRouter no disponible');
                return;
            }

            try {
                const data = await window.AppRouter.get('/routes/dashboard/stats.php');

                if (data.status === 'success') {
                    const stats = data.data.stats;
                    const charts = data.data.charts;
                    const roleId = data.data.role_id;

                    console.log('✅ Estadísticas cargadas:', stats);

                    // Actualizar stats de usuario/sesiones
                    if (roleId == 2) { // Admin
                        updateElement('totalUsers', stats.users.total);
                        updateElement('totalUsersDetail',
                            `${stats.users.active} activos, ${stats.users.admins} admins`);

                        updateElement('activeSessions', stats.sessions.active);
                        updateElement('activeSessionsDetail', `${stats.sessions.total} total en sistema`);

                        updateElement('totalFiles', stats.storage.total_files);
                        updateElement('totalFilesDetail', formatBytes(stats.storage.total_size));

                        updateElement('loginsWeek', stats.activity.logins_week);
                        updateElement('loginsWeekDetail',
                            `${stats.activity.logins_today} hoy, ${stats.activity.logins_month} este mes`);
                    } else { // Usuario normal
                        updateElement('totalUsers', '---');
                        updateElement('totalUsersDetail', 'Solo administradores');

                        updateElement('activeSessions', stats.sessions.user_sessions);
                        updateElement('activeSessionsDetail', 'Tus sesiones activas');

                        updateElement('totalFiles', stats.storage.user_files);
                        updateElement('totalFilesDetail', formatBytes(stats.storage.user_size));

                        updateElement('loginsWeek', '---');
                        updateElement('loginsWeekDetail', 'Solo administradores');
                    }

                    // Cargar gráficas (solo admin)
                    if (roleId == 2) {
                        loadSessionsChart(charts.sessions_by_day);
                        loadRolesChart(charts.users_by_role);
                    }
                } else {
                    console.error('❌ Error al cargar estadísticas:', data.message);
                }
            } catch (error) {
                console.error('❌ Error al cargar estadísticas:', error);
                // Mostrar valores de error
                updateElement('totalUsers', 'Error');
                updateElement('activeSessions', 'Error');
                updateElement('totalFiles', 'Error');
                updateElement('loginsWeek', 'Error');
            }
        }

        // ===================================
        // CARGAR SESIÓN ACTUAL
        // ===================================
        async function loadCurrentSession() {
            try {
                const currentSession = await window.SessionService.getCurrentSession();

                if (currentSession) {
                    updateElement('currentDevice', currentSession.device_type || 'Desconocido');
                    updateElement('currentBrowser', currentSession.browser || 'Desconocido');
                    updateElement('currentIP', currentSession.ip_address || '--');
                    updateElement('sessionStart', formatRelativeTime(currentSession.created_at));

                    console.log('✅ Sesión actual cargada:', currentSession);
                } else {
                    console.warn('⚠️ No se pudo obtener sesión actual');
                }
            } catch (error) {
                console.error('❌ Error al cargar sesión actual:', error);
            }
        }

        // ===================================
        // GRÁFICAS CON CHART.JS
        // ===================================
        function loadSessionsChart(data) {
            const ctx = document.getElementById('sessionsChart');
            if (!ctx) return;

            // Destruir gráfica anterior si existe
            if (dashboardCharts.sessions) {
                dashboardCharts.sessions.destroy();
            }

            const labels = data.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('es-ES', {
                    month: 'short',
                    day: 'numeric'
                });
            });
            const values = data.map(item => parseInt(item.count));

            dashboardCharts.sessions = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sesiones',
                        data: values,
                        borderColor: 'rgb(13, 110, 253)',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        function loadRolesChart(data) {
            const ctx = document.getElementById('rolesChart');
            if (!ctx) return;

            // Destruir gráfica anterior si existe
            if (dashboardCharts.roles) {
                dashboardCharts.roles.destroy();
            }

            const labels = data.map(item => item.role_name);
            const values = data.map(item => parseInt(item.count));
            const colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'];

            dashboardCharts.roles = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.slice(0, values.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // ===================================
        // DIAGNÓSTICO DEL SISTEMA
        // ===================================
        async function runDiagnostic() {
            const content = document.getElementById('diagnosticContent');
            if (!content) return;

            // Mostrar loading
            content.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Ejecutando diagnóstico...</span>
                    </div>
                    <p class="text-muted mt-3">Ejecutando diagnóstico del sistema...</p>
                </div>
            `;

            try {
                const data = await window.AppRouter.get('/routes/dashboard/diagnostic.php');

                if (data.status === 'success') {
                    const diagnostic = data.data;
                    renderDiagnostic(diagnostic);
                } else {
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bx bx-error"></i> Error al ejecutar diagnóstico: ${data.message || 'Error desconocido'}
                        </div>
                    `;
                }
            } catch (error) {
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bx bx-error"></i> Error al comunicarse con el servidor: ${error.message}
                    </div>
                `;
            }
        }

        function renderDiagnostic(diagnostic) {
            const content = document.getElementById('diagnosticContent');
            if (!content) return;

            const statusColors = {
                'healthy': 'success',
                'warning': 'warning',
                'degraded': 'warning',
                'error': 'danger',
                'critical': 'danger'
            };

            const statusIcons = {
                'healthy': 'bx-check-circle',
                'warning': 'bx-error-circle',
                'degraded': 'bx-error-circle',
                'error': 'bx-x-circle',
                'critical': 'bx-x-circle'
            };

            let html = `
                <div class="mb-4">
                    <h6 class="text-${statusColors[diagnostic.overall_status]}">
                        <i class="bx ${statusIcons[diagnostic.overall_status]}"></i>
                        Estado General: <strong>${diagnostic.overall_status.toUpperCase()}</strong>
                    </h6>
                    <small class="text-muted">Última verificación: ${diagnostic.timestamp}</small>
                </div>

                <div class="accordion" id="diagnosticAccordion">
            `;

            Object.entries(diagnostic.components).forEach(([key, component], index) => {
                const collapseId = `collapse${index}`;
                const color = statusColors[component.status];
                const icon = statusIcons[component.status];

                html += `
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button ${index === 0 ? '' : 'collapsed'}" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#${collapseId}">
                                <i class="bx ${icon} text-${color} me-2"></i>
                                <strong>${key.replace('_', ' ').toUpperCase()}</strong>
                                <span class="badge bg-${color} ms-auto">${component.status}</span>
                            </button>
                        </h2>
                        <div id="${collapseId}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                            data-bs-parent="#diagnosticAccordion">
                            <div class="accordion-body">
                                <p class="mb-2">${component.message}</p>
                                ${renderDiagnosticDetails(component.details)}
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `</div>`;
            content.innerHTML = html;
        }

        function renderDiagnosticDetails(details) {
            if (!details || typeof details !== 'object') return '';

            let html = '<small class="text-muted"><ul class="mb-0">';
            Object.entries(details).forEach(([key, value]) => {
                if (typeof value === 'object') {
                    html += `<li><strong>${key}:</strong> ${JSON.stringify(value)}</li>`;
                } else {
                    html += `<li><strong>${key}:</strong> ${value}</li>`;
                }
            });
            html += '</ul></small>';
            return html;
        }

        // ===================================
        // UTILIDADES
        // ===================================
        function updateElement(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.innerHTML = value;
            }
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        function formatRelativeTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);

            if (days > 0) return `Hace ${days}d`;
            if (hours > 0) return `Hace ${hours}h`;
            if (minutes > 0) return `Hace ${minutes}min`;
            return 'Ahora';
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
                console.warn('⏳ Esperando a SessionService y RoleService... Intento', updateContentRetries,
                    'de',
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

                // Mostrar/ocultar gráficas según rol (solo admin)
                toggleAdminCharts(isAdmin);

                console.log('✅ Dashboard actualizado correctamente');

            } catch (error) {
                console.error('❌ Error al actualizar dashboard:', error);
                // En caso de error, mostrar mensaje genérico
                updateWelcomeMessage('Usuario', false);
                loadQuickActions(false);
                toggleAdminCharts(false);
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
                // Acciones para administrador
                actionsHTML += `
                    <!-- Gestionar Usuarios -->
                    <div class="col-12 col-sm-6">
                        <a href="/dashboard/users" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                    <i class="bx bx-user-circle" style="font-size: 2rem; color: white;"></i>
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
                        <a href="/dashboard/settings" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                                    <i class="bx bx-cog" style="font-size: 2rem; color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Configuración</h6>
                                    <small class="text-muted">Ajustes del sistema</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- HomeLab VR -->
                    <div class="col-12 col-sm-6">
                        <a href="/homelab" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #0dcaf0 0%, #087990 100%);">
                                    <i class="bx bx-cube" style="font-size: 2rem; color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">HomeLab VR</h6>
                                    <small class="text-muted">Experiencia inmersiva</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Página Principal -->
                    <div class="col-12 col-sm-6">
                        <a href="/" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%);">
                                    <i class="bx bx-home-alt" style="font-size: 2rem; color: white;"></i>
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
                // Acciones para usuario regular y supervisor
                actionsHTML += `
                    <!-- Mis Archivos -->
                    <div class="col-12 col-sm-6">
                        <a href="/dashboard/files" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                    <i class="bx bx-folder" style="font-size: 2rem; color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Mis Archivos</h6>
                                    <small class="text-muted">Gestionar archivos</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Registro de Cambios -->
                    <div class="col-12 col-sm-6">
                        <a href="/dashboard/changes" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                                    <i class="bx bx-git-branch" style="font-size: 2rem; color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">Registro de Cambios</h6>
                                    <small class="text-muted">Ver actualizaciones</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- HomeLab VR -->
                    <div class="col-12 col-sm-6">
                        <a href="/homelab" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #0dcaf0 0%, #087990 100%);">
                                    <i class="bx bx-cube" style="font-size: 2rem; color: white;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="color: var(--bs-body-color);">HomeLab VR</h6>
                                    <small class="text-muted">Experiencia inmersiva</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Página Principal -->
                    <div class="col-12 col-sm-6">
                        <a href="/" class="quick-action-card d-block p-4 rounded text-decoration-none" style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="action-icon rounded p-3" style="background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%);">
                                    <i class="bx bx-home-alt" style="font-size: 2rem; color: white;"></i>
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
                    link.addEventListener('click', function(event) {
                        const targetUrl = this.getAttribute('data-route');
                        verifySessionOnClick(event, targetUrl);
                    });
                });
                console.log('✅ Event listeners agregados a', protectedLinks.length, 'rutas protegidas');
            }, 100);
        }

        // ===================================
        // MOSTRAR/OCULTAR GRÁFICAS SEGÚN ROL
        // ===================================
        function toggleAdminCharts(isAdmin) {
            const chartsSection = document.getElementById('adminChartsSection');
            if (!chartsSection) {
                console.warn('⚠️ Sección de gráficas no encontrada');
                return;
            }

            if (isAdmin) {
                chartsSection.style.display = 'flex'; // Mostrar gráficas
                console.log('📊 Gráficas de admin mostradas');
            } else {
                chartsSection.style.display = 'none'; // Ocultar gráficas
                console.log('🔒 Gráficas de admin ocultadas (solo administradores)');
            }
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
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Dashboard: DOM cargado');

            // Cargar versión desde config.js
            if (window.ENV_CONFIG && window.ENV_CONFIG.APP_VERSION) {
                const versionElement = document.getElementById('systemVersion');
                if (versionElement) {
                    versionElement.textContent = 'v' + window.ENV_CONFIG.APP_VERSION;
                    console.log('✅ Versión del sistema cargada:', window.ENV_CONFIG.APP_VERSION);
                }
            }

            // CRÍTICO: Verificar autenticación SOLO AL CARGAR (NO EN SEGUNDO PLANO)
            // Si no está autenticado, redirige a home automáticamente
            verifyAuthentication();

            // Event listener para modal de diagnóstico
            const diagnosticModal = document.getElementById('diagnosticModal');
            if (diagnosticModal) {
                diagnosticModal.addEventListener('shown.bs.modal', function() {
                    console.log('🔍 Ejecutando diagnóstico del sistema...');
                    runDiagnostic();
                });
            }

            // Event listener para refrescar diagnóstico
            const refreshDiagnosticBtn = document.getElementById('refreshDiagnostic');
            if (refreshDiagnosticBtn) {
                refreshDiagnosticBtn.addEventListener('click', function() {
                    console.log('🔄 Refrescando diagnóstico...');
                    runDiagnostic();
                });
            }

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