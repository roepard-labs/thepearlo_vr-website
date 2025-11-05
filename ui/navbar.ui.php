<?php
/**
 * Componente: Navbar Dashboard
 * Barra superior con breadcrumb dinámico, fecha/hora y acciones de usuario
 * HomeLab AR - Roepard Labs
 */

// Obtener datos del usuario
$userName = $_SESSION['user_name'] ?? 'Administrador';
$userFirstName = explode(' ', $userName)[0];
$userRole = $_SESSION['role_id'] ?? 2;
$roleName = $userRole == 2 ? 'Administrador' : 'Usuario';

// Detectar página actual desde la URL
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Mapear rutas a breadcrumbs y títulos
$pageInfo = [
    '/dashboard' => [
        'breadcrumb' => ['Dashboard'],
        'title' => 'Dashboard Principal',
        'icon' => 'bx-home-alt'
    ],
    '/dashboard/users' => [
        'breadcrumb' => ['Dashboard', 'Usuarios'],
        'title' => 'Gestión de Usuarios',
        'icon' => 'bx-user'
    ],
    '/dashboard/files' => [
        'breadcrumb' => ['Dashboard', 'Archivos'],
        'title' => 'Administrador de Archivos',
        'icon' => 'bx-folder-open'
    ],
    '/dashboard/settings' => [
        'breadcrumb' => ['Dashboard', 'Configuración'],
        'title' => 'Configuración del Sistema',
        'icon' => 'bx-cog'
    ],
    '/dashboard/profile' => [
        'breadcrumb' => ['Dashboard', 'Mi Perfil'],
        'title' => 'Mi Perfil de Usuario',
        'icon' => 'bx-user-circle'
    ]
];

// Obtener información de la página actual
$currentPageInfo = $pageInfo[$currentPath] ?? [
    'breadcrumb' => ['Dashboard'],
    'title' => 'Dashboard',
    'icon' => 'bx-home-alt'
];

$currentBreadcrumb = $currentPageInfo['breadcrumb'];
$pageTitle = $currentPageInfo['title'];
$pageIcon = $currentPageInfo['icon'];
?>

<nav class="navbar-dashboard border-bottom sticky-top" style="background-color: var(--bs-body-bg);">
    <div class="container-fluid px-4 py-3">
        <div class="row w-100 align-items-center">

            <!-- Left: Mobile Menu Button + Breadcrumb + Page Title -->
            <div class="col-12 col-md-7 d-flex align-items-center gap-3">

                <!-- Mobile Menu Toggle -->
                <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMobile">
                    <i class="bx bx-menu"></i>
                </button>

                <!-- Breadcrumb + Page Title -->
                <div class="page-header-section">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-1">
                        <ol class="breadcrumb mb-0">
                            <?php foreach ($currentBreadcrumb as $index => $crumb): ?>
                                <?php if ($index === count($currentBreadcrumb) - 1): ?>
                                    <li class="breadcrumb-item active" aria-current="page" id="currentPageBreadcrumb">
                                        <?php echo htmlspecialchars($crumb); ?>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item">
                                        <a href="/dashboard"
                                            class="text-decoration-none"><?php echo htmlspecialchars($crumb); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- Page Title -->
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" id="currentPageTitle">
                        <i class="bx <?php echo $pageIcon; ?> text-primary"></i>
                        <span><?php echo htmlspecialchars($pageTitle); ?></span>
                    </h5>
                </div>
            </div>

            <!-- Right: Date & Time Card -->
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end gap-3 mt-3 mt-md-0">

                <!-- Date & Time Card -->
                <div class="datetime-card d-flex align-items-center gap-3 px-3 py-2 rounded"
                    style="background-color: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);">

                    <!-- Calendar Icon -->
                    <div class="datetime-icon bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px;">
                        <i class="bx bx-calendar text-primary fs-5"></i>
                    </div>

                    <!-- Date & Time -->
                    <div class="datetime-info">
                        <div class="fw-semibold" style="font-size: 0.9rem; line-height: 1.2;" id="currentDate">
                            Cargando...
                        </div>
                        <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                            <i class="bx bx-time"></i>
                            <span id="currentTime">--:--:--</span>
                        </small>
                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>

<style>
    /* ===================================
   NAVBAR DASHBOARD STYLES
=================================== */
    .navbar-dashboard {
        z-index: 1020;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-header-section {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        font-size: 0.85rem;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: var(--bs-secondary);
    }

    .breadcrumb-item a {
        color: var(--bs-secondary);
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--bs-primary);
    }

    .breadcrumb-item.active {
        color: var(--bs-body-color);
        font-weight: 500;
    }

    #currentPageTitle {
        font-size: 1.25rem;
        color: var(--bs-body-color);
    }

    #currentPageTitle i {
        font-size: 1.5rem;
    }

    .datetime-card {
        transition: all 0.2s ease;
    }

    .datetime-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .datetime-icon {
        transition: transform 0.2s ease;
    }

    .datetime-card:hover .datetime-icon {
        transform: scale(1.05);
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .navbar-dashboard .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .user-stat-card {
            padding: 0.5rem 0.75rem;
        }

        .user-actions .btn {
            width: 32px;
            height: 32px;
        }
    }
</style>

<script>
    (function () {
        'use strict';

        // ===================================
        // DATE & TIME DISPLAY
        // ===================================
        function updateDateTime() {
            const now = new Date();

            // Formato de fecha: Lun, 3 Nov 2025
            const dateOptions = {
                weekday: 'short',
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            const dateStr = now.toLocaleDateString('es-ES', dateOptions);

            // Formato de hora: 14:30:45
            const timeStr = now.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');

            if (dateElement) dateElement.textContent = dateStr;
            if (timeElement) timeElement.textContent = timeStr;
        }

        // Actualizar cada segundo
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // ===================================
        // ACTUALIZAR BREADCRUMB DINÁMICAMENTE
        // ===================================
        const pageMapping = {
            '/dashboard': {
                breadcrumb: 'Dashboard',
                title: 'Dashboard Principal',
                icon: 'bx-home-alt'
            },
            '/dashboard/users': {
                breadcrumb: 'Usuarios',
                title: 'Gestión de Usuarios',
                icon: 'bx-user'
            },
            '/dashboard/files': {
                breadcrumb: 'Archivos',
                title: 'Administrador de Archivos',
                icon: 'bx-folder-open'
            },
            '/dashboard/settings': {
                breadcrumb: 'Configuración',
                title: 'Configuración del Sistema',
                icon: 'bx-cog'
            },
            '/dashboard/profile': {
                breadcrumb: 'Mi Perfil',
                title: 'Mi Perfil de Usuario',
                icon: 'bx-user-circle'
            }
        };

        function updateBreadcrumb() {
            const currentPath = window.location.pathname;
            const pageInfo = pageMapping[currentPath];

            if (!pageInfo) return;

            // Actualizar breadcrumb
            const breadcrumbItem = document.getElementById('currentPageBreadcrumb');
            if (breadcrumbItem) {
                breadcrumbItem.textContent = pageInfo.breadcrumb;
            }

            // Actualizar título de la página
            const pageTitle = document.getElementById('currentPageTitle');
            if (pageTitle) {
                pageTitle.innerHTML = `
                    <i class="bx ${pageInfo.icon} text-primary"></i>
                    <span>${pageInfo.title}</span>
                `;
            }

            console.log('📍 Breadcrumb actualizado:', currentPath, '→', pageInfo.title);
        }

        // Actualizar al cargar y cuando cambie la URL
        updateBreadcrumb();

        // Escuchar cambios de navegación (para SPAs o navegación dinámica)
        window.addEventListener('popstate', updateBreadcrumb);

        // Observar cambios en la URL (para navegación sin recargar)
        let lastPath = window.location.pathname;
        setInterval(() => {
            if (window.location.pathname !== lastPath) {
                lastPath = window.location.pathname;
                updateBreadcrumb();
            }
        }, 500);

        console.log('✅ Navbar Dashboard inicializado con breadcrumb dinámico');
    })();
</script>