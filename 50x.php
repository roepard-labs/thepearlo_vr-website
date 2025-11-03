<?php
/**
 * Página de Error 50x - Error del Servidor
 * HomeLab AR - Roepard Labs
 * 
 * Esta página se muestra cuando ocurre un error interno del servidor
 */

require_once __DIR__ . '/layout/AppLayout.php';

// Obtener información del error si está disponible
$error_code = $_SERVER['REDIRECT_STATUS'] ?? '500';
$requested_url = $_SERVER['REQUEST_URI'] ?? '/';

// Determinar tipo de error con descripciones completas
$error_types = [
    '500' => [
        'title' => 'Error Interno del Servidor',
        'description' => 'Algo salió mal en nuestros servidores. Ya estamos trabajando en resolverlo.',
        'icon' => 'bx-error',
        'color' => 'danger'
    ],
    '501' => [
        'title' => 'No Implementado',
        'description' => 'El servidor no soporta la funcionalidad requerida para completar la solicitud.',
        'icon' => 'bx-wrench',
        'color' => 'warning'
    ],
    '502' => [
        'title' => 'Bad Gateway',
        'description' => 'El servidor actuando como gateway recibió una respuesta inválida del servidor upstream.',
        'icon' => 'bx-cloud-off',
        'color' => 'warning'
    ],
    '503' => [
        'title' => 'Servicio No Disponible',
        'description' => 'El servicio está temporalmente fuera de línea por mantenimiento. Por favor, inténtalo de nuevo en unos minutos.',
        'icon' => 'bx-time',
        'color' => 'warning'
    ],
    '504' => [
        'title' => 'Gateway Timeout',
        'description' => 'El servidor no recibió una respuesta a tiempo del servidor upstream.',
        'icon' => 'bx-hourglass',
        'color' => 'warning'
    ],
    '505' => [
        'title' => 'Versión HTTP No Soportada',
        'description' => 'El servidor no soporta la versión del protocolo HTTP usada en la solicitud.',
        'icon' => 'bx-no-entry',
        'color' => 'danger'
    ],
    '507' => [
        'title' => 'Almacenamiento Insuficiente',
        'description' => 'El servidor no tiene suficiente espacio de almacenamiento para completar la solicitud.',
        'icon' => 'bx-hdd',
        'color' => 'danger'
    ],
    '508' => [
        'title' => 'Bucle Detectado',
        'description' => 'El servidor detectó un bucle infinito al procesar la solicitud.',
        'icon' => 'bx-infinite',
        'color' => 'danger'
    ],
    '511' => [
        'title' => 'Autenticación de Red Requerida',
        'description' => 'El cliente necesita autenticarse para obtener acceso a la red.',
        'icon' => 'bx-wifi-off',
        'color' => 'warning'
    ]
];

$error_info = $error_types[$error_code] ?? $error_types['500'];

ob_start();
?>

<section
    class="error-page min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden">
    <!-- Background Gradient -->
    <div class="position-absolute w-100 h-100 top-0 start-0"
        style="background: linear-gradient(135deg, rgba(255, 68, 68, 0.05), rgba(255, 170, 0, 0.05)); z-index: 0;">
    </div>

    <!-- Animated Background Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0;">
        <div class="position-absolute rounded-circle"
            style="width: 300px; height: 300px; background: rgba(255, 68, 68, 0.1); top: 10%; right: -5%; filter: blur(60px); animation: pulse 4s ease-in-out infinite;">
        </div>
        <div class="position-absolute rounded-circle"
            style="width: 400px; height: 400px; background: rgba(255, 170, 0, 0.1); bottom: -10%; left: -10%; filter: blur(80px); animation: pulse 5s ease-in-out infinite;">
        </div>
    </div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">

                <!-- Error Icon -->
                <div class="mb-4" data-aos="zoom-in" data-aos-duration="800">
                    <div class="d-inline-block position-relative">
                        <i class="bx <?php echo $error_info['icon']; ?>"
                            style="font-size: 120px; color: var(--color-<?php echo $error_info['color']; ?>); opacity: 0.9;"></i>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <span class="badge bg-<?php echo $error_info['color']; ?>"
                                style="font-size: 2rem; font-weight: 800; padding: 1rem 1.5rem;"><?php echo $error_code; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Error Title -->
                <h1 class="display-3 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100"
                    style="color: var(--bs-heading-color);">
                    <?php echo $error_info['title']; ?>
                </h1>

                <!-- Error Description -->
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="200" style="color: var(--bs-body-color);">
                    <?php echo $error_info['description']; ?>
                </p>

                <!-- Error Details -->
                <div class="custom-alert custom-alert-danger mb-4" data-aos="fade-up" data-aos-delay="300">
                    <i class="bx bx-info-circle me-2"></i>
                    <div class="text-start">
                        <strong class="d-block mb-2">Detalles Técnicos:</strong>
                        <div class="d-flex flex-column gap-1">
                            <small>
                                <strong>Código de Error:</strong>
                                <code class="ms-2"><?php echo $error_code; ?></code>
                            </small>
                            <small>
                                <strong>URL:</strong>
                                <code class="ms-2"><?php echo htmlspecialchars($requested_url); ?></code>
                            </small>
                            <small>
                                <strong>Hora:</strong>
                                <code class="ms-2"><?php echo date('Y-m-d H:i:s'); ?></code>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5" data-aos="fade-up"
                    data-aos-delay="400">
                    <button onclick="location.reload()" class="btn btn-primary btn-lg px-4">
                        <i class="bx bx-refresh me-2"></i>
                        Reintentar
                    </button>

                    <a href="/" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bx bx-home me-2"></i>
                        Volver al Inicio
                    </a>
                </div>

                <!-- Status Check Card -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="500"
                    style="background: var(--bs-body-bg);">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3" style="color: var(--bs-heading-color);">
                            <i class="bx bx-pulse me-2"></i>
                            Estado del Sistema
                        </h5>

                        <div class="d-flex flex-column gap-3">
                            <!-- Frontend Status -->
                            <div class="d-flex align-items-center justify-content-between p-3 rounded"
                                style="background: var(--bs-tertiary-bg);">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-desktop me-3"
                                        style="font-size: 1.5rem; color: var(--color-success);"></i>
                                    <div class="text-start">
                                        <strong class="d-block">Frontend</strong>
                                        <small class="text-muted">Sitio Web Principal</small>
                                    </div>
                                </div>
                                <span class="badge bg-success">
                                    <i class="bx bx-check-circle me-1"></i>
                                    Operativo
                                </span>
                            </div>

                            <!-- Backend Status -->
                            <div class="d-flex align-items-center justify-content-between p-3 rounded"
                                style="background: var(--bs-tertiary-bg);">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-server me-3"
                                        style="font-size: 1.5rem; color: var(--color-<?php echo $error_info['color']; ?>);"></i>
                                    <div class="text-start">
                                        <strong class="d-block">Backend API</strong>
                                        <small class="text-muted">api.roepard.online</small>
                                    </div>
                                </div>
                                <span class="badge bg-<?php echo $error_info['color']; ?>" id="backend-status">
                                    <i class="bx bx-error-circle me-1"></i>
                                    Verificando...
                                </span>
                            </div>

                            <!-- Database Status -->
                            <div class="d-flex align-items-center justify-content-between p-3 rounded"
                                style="background: var(--bs-tertiary-bg);">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-data me-3"
                                        style="font-size: 1.5rem; color: var(--bs-secondary-color);"></i>
                                    <div class="text-start">
                                        <strong class="d-block">Base de Datos</strong>
                                        <small class="text-muted">MySQL/MariaDB</small>
                                    </div>
                                </div>
                                <span class="badge bg-secondary">
                                    <i class="bx bx-question-mark me-1"></i>
                                    Desconocido
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top" style="border-color: var(--bs-border-color) !important;">
                            <button onclick="checkBackendStatus()" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bx bx-refresh me-2"></i>
                                Verificar Estado del Backend
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="600"
                    style="background: var(--bs-body-bg);">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3" style="color: var(--bs-heading-color);">
                            <i class="bx bx-help-circle me-2"></i>
                            ¿Qué puedes hacer?
                        </h5>
                        <div class="text-start">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <strong>Recargar la página</strong> - A veces un simple refresh resuelve el problema
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <strong>Esperar unos minutos</strong> - Podría ser mantenimiento temporal
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <strong>Verificar tu conexión</strong> - Asegúrate de estar conectado a internet
                                </li>
                                <li class="mb-0">
                                    <i class="bx bx-check text-success me-2"></i>
                                    <strong>Contactar soporte</strong> - Si el problema persiste, háznolo saber
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <p class="text-muted mt-4" data-aos="fade-up" data-aos-delay="700">
                    <small>
                        Si el problema persiste, por favor contacta al equipo técnico.<br>
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
    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }

    .custom-alert {
        display: flex;
        align-items: flex-start;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
    }

    .custom-alert-danger {
        border-left: 4px solid var(--color-danger);
        background: rgba(255, 68, 68, 0.1);
    }

    .custom-alert-danger i {
        font-size: 1.5rem;
        color: var(--color-danger);
    }

    code {
        padding: 0.25rem 0.5rem;
        background: var(--bs-tertiary-bg);
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        color: var(--bs-body-color);
    }

    .list-unstyled li {
        color: var(--bs-body-color);
    }
</style>

<script>
    // Verificar estado del backend
    async function checkBackendStatus() {
        const statusBadge = document.getElementById('backend-status');
        statusBadge.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Verificando...';
        statusBadge.className = 'badge bg-secondary';

        try {
            // Intentar hacer ping al backend
            const response = await fetch('<?php echo getenv("API_URL") ?: "http://localhost:3000"; ?>/api/health', {
                method: 'GET',
                timeout: 5000
            });

            if (response.ok) {
                statusBadge.innerHTML = '<i class="bx bx-check-circle me-1"></i> Operativo';
                statusBadge.className = 'badge bg-success';

                // Mostrar notificación de éxito
                if (typeof Notyf !== 'undefined') {
                    const notyf = new Notyf();
                    notyf.success('¡El backend está operativo! Puedes reintentar.');
                }
            } else {
                throw new Error('Backend no responde');
            }
        } catch (error) {
            statusBadge.innerHTML = '<i class="bx bx-error-circle me-1"></i> No Disponible';
            statusBadge.className = 'badge bg-danger';

            // Mostrar notificación de error
            if (typeof Notyf !== 'undefined') {
                const notyf = new Notyf();
                notyf.error('El backend aún no está disponible');
            }
        }
    }

    // Auto-verificar estado al cargar
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(checkBackendStatus, 1000);
    });
</script>

<?php
$content = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Error interno del servidor">
    <title><?php echo $error_code; ?> - Error del Servidor | HomeLab AR</title>

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

    <!-- Notyf -->
    <link href="/node_modules/notyf/notyf.min.css" rel="stylesheet">
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

    <!-- Notyf -->
    <script src="/node_modules/notyf/notyf.min.js"></script>

    <!-- Color Mode Toggler -->
    <script src="/js/color-mode-toggler.js"></script>
</body>

</html>