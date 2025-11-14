
<?php
/**
 * PearlLayout - Layout especializado para HomeLab VR/AR
 * HomeLab AR - Roepard Labs
 *
 * Este layout está optimizado para experiencias VR/AR y carga todas las dependencias necesarias.
 */

class PearlLayout
{
    /**
     * Renderiza el layout especializado para HomeLab VR/AR
     * @param string $view Nombre de la vista
     * @param array $data Datos para la vista
     * @param array $config Configuración adicional
     */
    public static function render($view, $data = [], $config = [])
    {
        $config = array_merge([
            'title' => 'HomeLab VR/AR',
            'description' => 'Experiencia inmersiva VR/AR para homelab',
            'includeHeader' => true,
            'includeFooter' => true,
            'bodyClass' => 'vr-ar-experience',
            'additionalCss' => [],
            'additionalJs' => []
        ], $config);

        // Mapeo de rutas VR/AR reales (según npm-loader.js)
        $vrJs = [
            'aframe',
            // 'arjs',
            'webvrPolyfill',
            'aframe-htmlembed-component',
            'aframe-super-keyboard',
            'aframe-extras',
            'aframe-play-sound-on-event',
            'aframe-physics-system',
            'aframe-particle-system-component',
            'aframe-canvas-text',
            'aframe-aabb-collider-component',
            'aframe-atlas-uvs-component',
            'aframe-audioanalyser-component',
            'aframe-event-decorators',
            'aframe-event-set-component',
            'aframe-geometry-merger-component',
            'aframe-log-component',
            'aframe-orbit-controls',
            'aframe-environment-component',
            'aframe-proxy-event-component',
            'aframe-slice9-component',
            'aframe-state-component',
            'aframe-look-at-component',
            'aframe-randomizer-components',
            'aframe-teleport-controls',
            'networked-aframe'
        ];

        $vrJsMap = [
            'aframe' => '/node_modules/aframe/dist/aframe-master.min.js',
            // 'arjs' => '/node_modules/ar.js/aframe/build/aframe-ar.min.js',
            'webvrPolyfill' => '/node_modules/webvr-polyfill/build/webvr-polyfill.min.js',
            'aframe-htmlembed-component' => '/node_modules/aframe-htmlembed-component/dist/build.js',
            'aframe-super-keyboard' => '/node_modules/aframe-super-keyboard/dist/aframe-super-keyboard.min.js',
            'aframe-extras' => '/node_modules/aframe-extras/dist/aframe-extras.min.js',
            'aframe-play-sound-on-event' => '/node_modules/aframe-play-sound-on-event/dist/aframe-play-sound-on-event.min.js',
            'aframe-physics-system' => '/node_modules/aframe-physics-system/dist/aframe-physics-system.min.js',
            'aframe-particle-system-component' => '/node_modules/aframe-particle-system-component/dist/aframe-particle-system-component.min.js',
            'aframe-canvas-text' => '/node_modules/aframe-canvas-text/dist/canvas-text.min.js',
            'aframe-aabb-collider-component' => '/node_modules/aframe-aabb-collider-component/dist/aframe-aabb-collider-component.min.js',
            'aframe-atlas-uvs-component' => '/node_modules/aframe-atlas-uvs-component/dist/aframe-atlas-uvs-component.min.js',
            'aframe-audioanalyser-component' => '/node_modules/aframe-audioanalyser-component/dist/aframe-audioanalyser-component.min.js',
            'aframe-event-decorators' => '/node_modules/aframe-event-decorators/dist/aframe-event-decorators.min.js',
            'aframe-event-set-component' => '/node_modules/aframe-event-set-component/dist/aframe-event-set-component.min.js',
            'aframe-geometry-merger-component' => '/node_modules/aframe-geometry-merger-component/dist/aframe-geometry-merger-component.min.js',
            'aframe-log-component' => '/node_modules/aframe-log-component/dist/aframe-log-component.min.js',
            'aframe-orbit-controls' => '/node_modules/aframe-orbit-controls/dist/aframe-orbit-controls.min.js',
            'aframe-environment-component' => '/node_modules/aframe-environment-component/dist/aframe-environment-component.min.js',
            'aframe-proxy-event-component' => '/node_modules/aframe-proxy-event-component/dist/aframe-proxy-event-component.min.js',
            'aframe-slice9-component' => '/node_modules/aframe-slice9-component/dist/aframe-slice9-component.min.js',
            'aframe-state-component' => '/node_modules/aframe-state-component/dist/aframe-state-component.min.js',
            'aframe-look-at-component' => '/node_modules/aframe-look-at-component/dist/aframe-look-at-component.min.js',
            'aframe-randomizer-components' => '/node_modules/aframe-randomizer-components/dist/aframe-randomizer-components.min.js',
            'aframe-teleport-controls' => '/node_modules/aframe-teleport-controls/dist/aframe-teleport-controls.min.js',
            'networked-aframe' => '/node_modules/networked-aframe/dist/networked-aframe.min.js'
        ];

        // Extraer datos para usar en la vista
        extract($data);
        ?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($config['description']); ?>">
    <title><?php echo htmlspecialchars($config['title']); ?></title>
    <link rel="icon" type="image/png" href="/assets/favicon.png">
    <link rel="stylesheet" href="/css/variables.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="/node_modules/aos/dist/aos.css">
    <link rel="stylesheet" href="/node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="/node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/node_modules/notyf/notyf.min.css">
    <link rel="stylesheet" href="/node_modules/tippy.js/dist/tippy.css">
    <?php if (file_exists(__DIR__ . "/../css/homelab.css")): ?>
    <link rel="stylesheet" href="/css/homelab.css">
    <?php endif; ?>
</head>
<body class="<?php echo htmlspecialchars($config['bodyClass']); ?>">
    <!-- Sin header UI -->
    <script src="/composables/npm-loader.js"></script>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/axios/dist/axios.min.js"></script>
    <script src="/node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/node_modules/aos/dist/aos.js"></script>
    <script src="/node_modules/animejs/dist/bundles/anime.umd.min.js"></script>
    <script src="/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="/node_modules/notyf/notyf.min.js"></script>
    <script src="/node_modules/tippy.js/dist/tippy-bundle.umd.min.js"></script>

    <!-- Config & Router (dependen de axios/jQuery cargados arriba) -->
    <script src="/composables/config.js"></script>
    <script src="/composables/router.js"></script>

    <!-- Backend Status Check -->
    <script src="/composables/statusCheck.js"></script>

    <!-- Clock Service (Date & Time) -->
    <script src="/composables/clockCheck.js"></script>

    <!-- Session & Role Services (se cargan pero no necesariamente ejecutan antes del contenido) -->
    <script src="/composables/sessionCheck.js"></script>
    <script src="/composables/roleCheck.js"></script>
    <script src="/composables/changesCheck.js"></script>
    <script src="/services/logoutService.js"></script>

    <?php foreach ($vrJs as $js): ?>
    <?php if (isset($vrJsMap[$js])): ?>
    <script src="<?php echo $vrJsMap[$js]; ?>"></script>
    <?php else: ?>
    <!-- Script VR/AR no mapeado: <?php echo $js; ?> -->
    <?php endif; ?>
    <?php endforeach; ?>
    <main id="main-content">
        <?php if (isset($data['content']) && !empty($data['content'])) {
            echo $data['content'];
        } elseif ($view !== null) {
            $viewPath = __DIR__ . "/../views/{$view}.view.php";
            if (file_exists($viewPath)) {
                include $viewPath;
            } else {
                echo "<!-- Vista no encontrada: {$view} -->";
            }
        }
        ?>
    </main>
    <!-- Sin footer UI -->
</body>
</html>
<?php
    }
}