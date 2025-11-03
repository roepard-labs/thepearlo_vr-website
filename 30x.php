<?php
/**
 * Página de errores 30x - Redirecciones
 * Maneja todos los códigos de estado de redirección HTTP
 */

// Obtener el código de error exacto desde nginx
$error_code = $_SERVER['REDIRECT_STATUS'] ?? '300';

// Definición de tipos de errores 30x con información específica
$error_types = [
    '300' => [
        'title' => 'Múltiples Opciones',
        'description' => 'Este recurso tiene múltiples representaciones disponibles. Por favor, selecciona una opción.',
        'icon' => 'bx-list-ul',
        'color' => 'info',
        'suggestion' => 'Revisa las opciones disponibles y selecciona la más apropiada.'
    ],
    '301' => [
        'title' => 'Movido Permanentemente',
        'description' => 'Este recurso se ha movido permanentemente a una nueva ubicación.',
        'icon' => 'bx-export',
        'color' => 'success',
        'suggestion' => 'Serás redirigido automáticamente. Actualiza tus marcadores con la nueva URL.'
    ],
    '302' => [
        'title' => 'Encontrado (Redirección Temporal)',
        'description' => 'Este recurso está temporalmente disponible en otra ubicación.',
        'icon' => 'bx-shuffle',
        'color' => 'info',
        'suggestion' => 'La redirección es temporal. La URL original puede volver a estar activa.'
    ],
    '303' => [
        'title' => 'Ver Otro',
        'description' => 'La respuesta a esta solicitud se puede encontrar en otra URI.',
        'icon' => 'bx-link-external',
        'color' => 'info',
        'suggestion' => 'Utiliza una petición GET para obtener el recurso desde la nueva ubicación.'
    ],
    '304' => [
        'title' => 'No Modificado',
        'description' => 'El recurso no ha sido modificado desde tu última visita.',
        'icon' => 'bx-check-circle',
        'color' => 'success',
        'suggestion' => 'Puedes usar la versión almacenada en caché. No es necesario descargar de nuevo.'
    ],
    '307' => [
        'title' => 'Redirección Temporal',
        'description' => 'Este recurso está temporalmente en otra ubicación. El método de solicitud debe mantenerse.',
        'icon' => 'bx-directions',
        'color' => 'info',
        'suggestion' => 'La redirección es temporal. Mantén el método HTTP original en la nueva ubicación.'
    ],
    '308' => [
        'title' => 'Redirección Permanente',
        'description' => 'Este recurso se ha movido permanentemente. El método de solicitud debe mantenerse.',
        'icon' => 'bx-export',
        'color' => 'success',
        'suggestion' => 'Actualiza tus marcadores. El recurso siempre estará en la nueva ubicación.'
    ]
];

// Obtener información del error o usar valores por defecto
$error_info = $error_types[$error_code] ?? [
    'title' => 'Redirección',
    'description' => 'El recurso solicitado ha sido redirigido.',
    'icon' => 'bx-right-arrow-circle',
    'color' => 'info',
    'suggestion' => 'Espera mientras te redirigimos a la ubicación correcta.'
];

// Información técnica para debugging
$request_uri = $_SERVER['REQUEST_URI'] ?? 'N/A';
$request_method = $_SERVER['REQUEST_METHOD'] ?? 'N/A';
$redirect_url = $_SERVER['HTTP_REFERER'] ?? '/';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $error_code; ?> - <?php echo $error_info['title']; ?> | HomeLab AR</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/favicon.ico">

    <!-- Bootstrap 5 -->
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="./node_modules/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- AOS Animations -->
    <link href="./node_modules/aos/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/variables.css" rel="stylesheet">
    <link href="./css/base.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">

    <style>
    .redirect-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg,
                var(--bs-body-bg) 0%,
                color-mix(in srgb, var(--bs-primary) 5%, var(--bs-body-bg)) 100%);
    }

    .redirect-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .redirect-card {
        max-width: 600px;
        width: 100%;
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 1rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .redirect-header {
        background: linear-gradient(135deg,
                var(--bs-<?php echo $error_info['color']; ?>) 0%,
                color-mix(in srgb, var(--bs-<?php echo $error_info['color']; ?>), black 20%) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .redirect-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }

    .redirect-body {
        padding: 2rem;
    }

    .error-code {
        font-size: 4rem;
        font-weight: 700;
        color: var(--bs-<?php echo $error_info['color']; ?>);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .countdown-timer {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--bs-primary);
        margin: 1.5rem 0;
    }

    .redirect-url {
        background: var(--bs-light);
        border: 1px solid var(--bs-border-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin: 1.5rem 0;
        word-break: break-all;
    }

    .tech-details {
        background: color-mix(in srgb, var(--bs-secondary) 10%, var(--bs-body-bg));
        border-left: 4px solid var(--bs-secondary);
        border-radius: 0.375rem;
        padding: 1rem;
        margin-top: 1.5rem;
        font-size: 0.875rem;
    }

    .progress {
        height: 8px;
        margin-top: 1rem;
    }

    .progress-bar {
        transition: width 1s linear;
        background: linear-gradient(90deg,
                var(--bs-<?php echo $error_info['color']; ?>) 0%,
                color-mix(in srgb, var(--bs-<?php echo $error_info['color']; ?>), white 30%) 100%);
    }
    </style>
</head>

<body class="redirect-page">

    <?php 
    // Incluir header si existe
    if (file_exists(__DIR__ . '/ui/header.ui.php')) {
        include __DIR__ . '/ui/header.ui.php';
    }
    ?>

    <main class="redirect-content">
        <div class="redirect-card" data-aos="zoom-in" data-aos-duration="600">
            <div class="redirect-header">
                <i class='bx <?php echo $error_info['icon']; ?> redirect-icon'></i>
                <div class="error-code"><?php echo $error_code; ?></div>
                <h1 class="h3 mb-0"><?php echo $error_info['title']; ?></h1>
            </div>

            <div class="redirect-body">
                <p class="lead text-center mb-4">
                    <?php echo $error_info['description']; ?>
                </p>

                <?php if (in_array($error_code, ['301', '302', '307', '308'])): ?>
                <div class="text-center">
                    <div class="countdown-timer">
                        <i class='bx bx-time-five'></i>
                        Redirigiendo en <span id="countdown">5</span> segundos...
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" id="progressBar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="alert alert-<?php echo $error_info['color']; ?> mt-4" role="alert">
                    <i class='bx bx-info-circle'></i>
                    <strong>Sugerencia:</strong> <?php echo $error_info['suggestion']; ?>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="/" class="btn btn-primary btn-lg">
                        <i class='bx bx-home'></i> Ir al Inicio
                    </a>

                    <?php if ($error_code === '304'): ?>
                    <button onclick="location.reload(true)" class="btn btn-outline-secondary">
                        <i class='bx bx-refresh'></i> Forzar Recarga
                    </button>
                    <?php else: ?>
                    <button onclick="history.back()" class="btn btn-outline-secondary">
                        <i class='bx bx-arrow-back'></i> Volver Atrás
                    </button>
                    <?php endif; ?>
                </div>

                <div class="tech-details">
                    <strong><i class='bx bx-info-circle'></i> Detalles Técnicos:</strong>
                    <ul class="list-unstyled mb-0 mt-2">
                        <li><strong>Código:</strong> <?php echo $error_code; ?></li>
                        <li><strong>URL Solicitada:</strong> <code><?php echo htmlspecialchars($request_uri); ?></code>
                        </li>
                        <li><strong>Método:</strong> <?php echo htmlspecialchars($request_method); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <?php 
    // Incluir footer si existe
    if (file_exists(__DIR__ . '/ui/footer.ui.php')) {
        include __DIR__ . '/ui/footer.ui.php';
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS -->
    <script src="./node_modules/aos/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
    </script>

    <!-- Color Mode Toggler -->
    <script src="./js/color-mode-toggler.js"></script>

    <?php if (in_array($error_code, ['301', '302', '307', '308'])): ?>
    <!-- Countdown y auto-redirect -->
    <script>
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');
    const progressBar = document.getElementById('progressBar');

    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;

        // Actualizar barra de progreso
        const progress = (countdown / 5) * 100;
        progressBar.style.width = progress + '%';

        if (countdown <= 0) {
            clearInterval(timer);
            // Redirigir al inicio o a la URL de referencia
            window.location.href = '<?php echo htmlspecialchars($redirect_url); ?>';
        }
    }, 1000);

    // Cancelar redirección si el usuario hace clic en un botón
    document.querySelectorAll('a, button').forEach(element => {
        element.addEventListener('click', () => {
            clearInterval(timer);
        });
    });
    </script>
    <?php endif; ?>

</body>

</html>