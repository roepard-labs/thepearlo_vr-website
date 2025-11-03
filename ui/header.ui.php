<?php
/**
 * Componente: Header
 * Header con navegación y autenticación
 * HomeLab AR - Roepard Labs
 */

// Verificar si el usuario está autenticado
$isAuthenticated = isset($_SESSION['user']) && !empty($_SESSION['user']);
$userName = $isAuthenticated ? $_SESSION['user']['name'] : '';
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
                    <a class="nav-link" href="#features">Características</a>
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
                            data-bs-toggle="dropdown">
                            <i class="bx bx-user-circle me-1"></i>
                            <?php echo htmlspecialchars($userName); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bx bx-dashboard me-2"></i>Dashboard</a>
                            </li>
                            <li><a class="dropdown-item" href="/profile"><i class="bx bx-user me-2"></i>Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i
                                        class="bx bx-log-out me-2"></i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Usuario no autenticado -->
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#authModal">
                        <i class="bx bx-log-in me-1"></i> Iniciar Sesión
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">
                        <i class="bx bx-user-plus me-1"></i> Registrarse
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
    }

    .dropdown-item {
        color: var(--bs-body-color);
    }

    .dropdown-item:hover {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-body-color);
    }
</style>