<?php
/**
 * Página de Error 404 - No Encontrado
 * HomeLab AR - Roepard Labs
 * 
 * Esta página se muestra cuando un recurso no se encuentra
 */

require_once __DIR__ . '/layout/AppLayout.php';

// Obtener la URL solicitada
$requested_url = $_SERVER['REQUEST_URI'] ?? '/';
$referer = $_SERVER['HTTP_REFERER'] ?? '/';

ob_start();
?>

<section
    class="error-page min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden">
    <!-- Background Gradient -->
    <div class="position-absolute w-100 h-100 top-0 start-0"
        style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.05), rgba(102, 16, 242, 0.05)); z-index: 0;">
    </div>

    <!-- Animated Background Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0;">
        <div class="position-absolute rounded-circle"
            style="width: 300px; height: 300px; background: rgba(13, 110, 253, 0.1); top: 10%; left: -5%; filter: blur(60px);">
        </div>
        <div class="position-absolute rounded-circle"
            style="width: 400px; height: 400px; background: rgba(102, 16, 242, 0.1); bottom: -10%; right: -10%; filter: blur(80px);">
        </div>
    </div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">

                <!-- Error Icon -->
                <div class="mb-4" data-aos="zoom-in" data-aos-duration="800">
                    <div class="d-inline-block position-relative">
                        <i class="bx bx-error-circle"
                            style="font-size: 120px; color: var(--bs-primary); opacity: 0.9;"></i>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <span class="badge bg-primary"
                                style="font-size: 2rem; font-weight: 800; padding: 1rem 1.5rem;">404</span>
                        </div>
                    </div>
                </div>

                <!-- Error Title -->
                <h1 class="display-3 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100"
                    style="color: var(--bs-heading-color);">
                    Página No Encontrada
                </h1>

                <!-- Error Description -->
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200" style="color: var(--bs-body-color);">
                    Lo sentimos, la página que estás buscando no existe o ha sido movida.
                </p>

                <!-- Requested URL Info -->
                <?php if ($requested_url !== '/'): ?>
                    <div class="custom-alert custom-alert-info mb-4" data-aos="fade-up" data-aos-delay="300">
                        <i class="bx bx-info-circle me-2"></i>
                        <div>
                            <strong>URL solicitada:</strong>
                            <code class="ms-2"
                                style="color: var(--bs-body-color);"><?php echo htmlspecialchars($requested_url); ?></code>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5" data-aos="fade-up"
                    data-aos-delay="400">
                    <a href="/" class="btn btn-primary btn-lg px-4">
                        <i class="bx bx-home me-2"></i>
                        Volver al Inicio
                    </a>

                    <?php if ($referer && strpos($referer, $_SERVER['HTTP_HOST']) !== false): ?>
                        <button onclick="window.history.back()" class="btn btn-outline-primary btn-lg px-4">
                            <i class="bx bx-arrow-back me-2"></i>
                            Página Anterior
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Helpful Links -->
                <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="500"
                    style="background: var(--bs-body-bg);">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3" style="color: var(--bs-heading-color);">
                            <i class="bx bx-compass me-2"></i>
                            ¿Buscas algo específico?
                        </h5>
                        <div class="row g-3 text-start">
                            <div class="col-md-6">
                                <a href="/"
                                    class="d-flex align-items-start text-decoration-none hover-card p-3 rounded transition-all"
                                    style="color: var(--bs-body-color);">
                                    <i class="bx bx-home-alt me-3 mt-1"
                                        style="font-size: 1.5rem; color: var(--bs-primary);"></i>
                                    <div>
                                        <strong class="d-block mb-1">Inicio</strong>
                                        <small class="text-muted">Página principal de HomeLab AR</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="/views/homelab.view.php"
                                    class="d-flex align-items-start text-decoration-none hover-card p-3 rounded transition-all"
                                    style="color: var(--bs-body-color);">
                                    <i class="bx bx-show-alt me-3 mt-1"
                                        style="font-size: 1.5rem; color: var(--bs-primary);"></i>
                                    <div>
                                        <strong class="d-block mb-1">Demo VR/AR</strong>
                                        <small class="text-muted">Experiencia de realidad aumentada</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="https://docs.roepard.online" target="_blank"
                                    class="d-flex align-items-start text-decoration-none hover-card p-3 rounded transition-all"
                                    style="color: var(--bs-body-color);">
                                    <i class="bx bx-book-open me-3 mt-1"
                                        style="font-size: 1.5rem; color: var(--bs-primary);"></i>
                                    <div>
                                        <strong class="d-block mb-1">Documentación</strong>
                                        <small class="text-muted">Guías y recursos</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="https://api.roepard.online" target="_blank"
                                    class="d-flex align-items-start text-decoration-none hover-card p-3 rounded transition-all"
                                    style="color: var(--bs-body-color);">
                                    <i class="bx bx-data me-3 mt-1"
                                        style="font-size: 1.5rem; color: var(--bs-primary);"></i>
                                    <div>
                                        <strong class="d-block mb-1">API</strong>
                                        <small class="text-muted">API REST del backend</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <p class="text-muted mt-4" data-aos="fade-up" data-aos-delay="600">
                    <small>
                        Si crees que esto es un error, por favor contacta al administrador.<br>
                        <a href="https://github.com/roepard-labs" target="_blank" class="text-decoration-none">
                            <i class="bx bxl-github me-1"></i>
                            GitHub: roepard-labs
                        </a>
                    </small>
                </p>

            </div>
        </div>
    </div>
</section>

<style>
    .hover-card {
        transition: all var(--transition-base);
    }

    .hover-card:hover {
        background: var(--bs-tertiary-bg);
        transform: translateX(5px);
    }

    .custom-alert {
        display: flex;
        align-items: flex-start;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
        border-left: 4px solid var(--color-info);
        background: rgba(23, 162, 184, 0.1);
    }

    .custom-alert i {
        font-size: 1.5rem;
        color: var(--color-info);
    }

    code {
        padding: 0.25rem 0.5rem;
        background: var(--bs-tertiary-bg);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
    }
</style>

<?php
$content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="La página que buscas no existe">
    <title>404 - Página No Encontrada | HomeLab AR</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/favicon.png">

    <!-- CSS Base del Proyecto -->
    <link rel="stylesheet" href="/css/variables.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- Bootstrap 5 -->
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="/node_modules/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- AOS -->
    <link href="/node_modules/aos/dist/aos.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="/node_modules/animate.css/animate.min.css" rel="stylesheet">
</head>

<body class="error-page-body">

    <?php
    // Incluir header
    if (file_exists(__DIR__ . '/ui/header.ui.php')) {
        include __DIR__ . '/ui/header.ui.php';
    }
    ?>

    <main id="main-content">
        <?php echo $content; ?>
    </main>

    <?php
    // Incluir footer
    if (file_exists(__DIR__ . '/ui/footer.ui.php')) {
        include __DIR__ . '/ui/footer.ui.php';
    }
    ?>

    <!-- JavaScript Core -->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- AOS -->
    <script src="/node_modules/aos/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>

    <!-- Color Mode Toggler -->
    <script src="/js/color-mode-toggler.js"></script>
</body>

</html>