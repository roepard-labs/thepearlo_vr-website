<?php
/**
 * Componente: Navbar Dashboard
 * Barra superior con breadcrumb, fecha/hora y acciones de usuario
 * HomeLab AR - Roepard Labs
 */

// Obtener datos del usuario
$userName = $_SESSION['user_name'] ?? 'Administrador';
$userFirstName = explode(' ', $userName)[0];
$userRole = $_SESSION['role_id'] ?? 2;
$roleName = $userRole == 2 ? 'Administrador' : 'Usuario';

// Breadcrumb según página actual
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$breadcrumbs = [
    'dashboard' => ['Dashboard'],
    'users' => ['Dashboard', 'Usuarios'],
    'settings' => ['Dashboard', 'Configuración']
];
$currentBreadcrumb = $breadcrumbs[$currentPage] ?? ['Dashboard'];
?>

<nav class="navbar-dashboard border-bottom sticky-top" style="background-color: var(--bs-body-bg);">
    <div class="container-fluid px-4 py-3">
        <div class="row w-100 align-items-center">

            <!-- Left: Mobile Menu Button + Breadcrumb -->
            <div class="col-12 col-md-6 d-flex align-items-center gap-3">

                <!-- Mobile Menu Toggle -->
                <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMobile">
                    <i class="bx bx-menu"></i>
                </button>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-0">
                    <ol class="breadcrumb mb-0">
                        <?php foreach ($currentBreadcrumb as $index => $crumb): ?>
                            <?php if ($index === count($currentBreadcrumb) - 1): ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <strong><?php echo htmlspecialchars($crumb); ?></strong>
                                </li>
                            <?php else: ?>
                                <li class="breadcrumb-item">
                                    <a href="/admin" class="text-decoration-none"><?php echo htmlspecialchars($crumb); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>

            <!-- Right: Date & Time Card -->
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-md-end gap-3 mt-3 mt-md-0">

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

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: var(--bs-secondary);
    }

    .breadcrumb-item a {
        color: var(--bs-secondary);
    }

    .breadcrumb-item a:hover {
        color: var(--bs-primary);
    }

    .breadcrumb-item.active {
        color: var(--bs-body-color);
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

        console.log('✅ Navbar Dashboard inicializado');
    })();
</script>