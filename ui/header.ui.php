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

<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
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
                        <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="bx bx-user-circle me-1"></i>
                            <?php echo htmlspecialchars($userName); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bx bx-dashboard me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="/profile"><i class="bx bx-user me-2"></i>Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="bx bx-log-out me-2"></i>Cerrar Sesión</a></li>
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
}

.navbar-brand {
    font-size: 1.5rem;
}

.nav-link {
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: var(--color-primary) !important;
}
</style>
