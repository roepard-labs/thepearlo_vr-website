<?php
/**
 * AppLayout - Layout Principal
 * HomeLab AR - Roepard Labs
 * 
 * Este layout maneja la estructura HTML base y la carga de dependencias
 */

class AppLayout
{

    // ===================================
    // CONFIGURACIÓN DE DEPENDENCIAS
    // ===================================

    /**
     * CSS Core (siempre se cargan)
     * Incluye librerías esenciales usadas en todo el proyecto
     */
    private static $cssCore = [
        'bootstrap',   // Framework CSS principal
        'boxicons',    // Iconos
        'aos',         // Animate on Scroll
        'animate',     // Animaciones CSS
        'sweetalert2', // Alertas bonitas
        'notyf',       // Notificaciones toast
        'tippy'        // Tooltips avanzados
    ];

    /**
     * JS Core (siempre se cargan)
     * Incluye librerías esenciales usadas en todo el proyecto
     */
    private static $jsCore = [
        'axios',       // HTTP Client (para API)
        'jquery',      // DOM manipulation (legacy)
        'popper',      // Requerido por Bootstrap tooltips
        'bootstrap',   // Framework JS principal
        'aos',         // Animate on Scroll
        'anime',       // Animaciones avanzadas
        'sweetalert2', // Alertas bonitas
        'notyf',       // Notificaciones toast
        'tippy'        // Tooltips avanzados
    ];

    /**
     * Mapeo de vistas a sus dependencias ADICIONALES
     * (las dependencias core ya están cargadas globalmente)
     */
    private static $viewDependencies = [
        'home' => [
            'css' => ['glightbox'],
            // Modernizr se añade para permitir diagnósticos tempranos en la página Home
            'js' => ['modernizr', 'glightbox', 'chart', 'anime']
        ],
        'homelab' => [
            'css' => [],
            'js' => [] // VR/AR dependencies loaded separately
        ],
        'dashboard' => [
            'css' => ['datatables', 'datatablesResponsive'], // Chart.js NO tiene CSS
            'js' => ['datatables', 'datatablesBS5', 'datatablesResponsive', 'chart', 'dayjs', 'anime'] // Dashboard unificado con estadísticas
        ],
        // Páginas del dashboard usan las mismas dependencias
        'users' => [
            'css' => ['datatables', 'datatablesResponsive'],
            'js' => ['datatables', 'datatablesBS5', 'datatablesResponsive']
        ],
        'settings' => [
            'css' => [],
            'js' => []
        ],
        'profile' => [
            'css' => ['filepond', 'filepondImagePreview'],
            'js' => [
                'filepond',
                'filepondValidateType',
                'filepondValidateSize',
                'filepondImagePreview',
                'filepondImageCrop',
                'filepondImageResize',
                'filepondImageTransform',
                'filepondImageExif'
            ]
        ],
        'features' => [
            'css' => [],
            'js' => [] // Solo usa dependencias core
        ],
        'privacy' => [
            'css' => [],
            'js' => [] // Solo usa dependencias core
        ],
        'terms' => [
            'css' => [],
            'js' => [] // Solo usa dependencias core
        ]
    ];

    // ===================================
    // MÉTODOS PRINCIPALES
    // ===================================

    /**
     * Renderiza el layout completo
     * 
     * @param string $view Nombre de la vista
     * @param array $data Datos para la vista
     * @param array $config Configuración adicional
     */
    public static function render($view, $data = [], $config = [])
    {
        // Configuración por defecto
        $config = array_merge([
            'title' => 'HomeLab AR',
            'description' => 'Realidad Aumentada para Homelab',
            'includeHeader' => true,
            'includeFooter' => true,
            'includeAuthModal' => true,
            'bodyClass' => '',
            'additionalCss' => [],
            'additionalJs' => []
        ], $config);

        // Obtener dependencias de la vista
        $viewDeps = self::$viewDependencies[$view] ?? ['css' => [], 'js' => []];

        // Combinar dependencias
        $allCss = array_merge(
            self::$cssCore,
            $viewDeps['css'],
            $config['additionalCss']
        );

        $allJs = array_merge(
            self::$jsCore,
            $viewDeps['js'],
            $config['additionalJs']
        );

        // Extraer datos para usar en la vista
        extract($data);

        // Renderizar directamente sin buffer
        ?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($config['description']); ?>">
    <title><?php echo htmlspecialchars($config['title']); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/favicon.png">

    <!-- CSS Base del Proyecto -->
    <link rel="stylesheet" href="/css/variables.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/main.css">

    <!-- CSS Dependencies -->
    <?php self::renderCssLinks($allCss); ?>

    <!-- CSS Específico de la Vista -->
    <?php if (file_exists(__DIR__ . "/../css/{$view}.css")): ?>
    <link rel="stylesheet" href="/css/<?php echo $view; ?>.css">
    <?php endif; ?>
</head>

<body class="<?php echo htmlspecialchars($config['bodyClass']); ?>">

    <?php if ($config['includeHeader']): ?>
    <?php self::includeComponent('ui/header.ui.php', $data); ?>
    <?php endif; ?>

    <!-- NPM Loader + Core scripts -->
    <!-- CARGAR PRIMERO: npm-loader, librerías core y router/config para que las vistas inline puedan usarlas -->
    <script src="/composables/npm-loader.js"></script>
    <?php if (in_array('modernizr', $allJs)): ?>
    <!-- Cargar Modernizr temprano en <head> mediante el npm-loader para que aplique clases en <html> -->
    <script>
    (function() {
        try {
            if (window.loadJS) {
                window.loadJS('modernizr', {
                    target: 'head',
                    async: false
                });
            } else {
                console.warn('NPM loader no disponible para inyectar Modernizr en <head>');
            }
        } catch (e) {
            console.error('Error intentando cargar Modernizr en head', e);
        }
    })();
    </script>
    <?php endif; ?>
    <?php
            // Separar JS core (siempre deben cargarse antes de los scripts inline de las vistas)
            $coreJs = self::$jsCore;
            // Otros JS: dependencias de la vista + adicionales de config
            $otherJs = array_merge($viewDeps['js'] ?? [], $config['additionalJs'] ?? []);
            // Eliminar duplicados que ya están en core, preservando orden
            $otherJs = array_values(array_diff($otherJs, $coreJs));

            // 1) Renderizar los scripts core (axios, jquery, anime, bootstrap, etc.)
            self::renderJsScripts($coreJs);
            ?>

    <!-- Diagnostic: verificar que anime se exponga globalmente y mostrar ruta desde npm-loader -->
    <script>
    (function() {
        try {
            console.log('🔎 Core diagnostic: typeof anime =', typeof window.anime);
            if (typeof window.getJSPath === 'function') {
                console.log('🔎 NPM loader path for anime:', window.getJSPath('anime'));
            }
            if (typeof window.anime === 'undefined') {
                console.warn('⚠️ anime no está definido aún en window');
            }
        } catch (e) {
            console.error('Diagnostic error:', e);
        }
    })();
    </script>
    <?php
            ?>

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

    <main id="main-content">
        <?php
                // CRÍTICO: Prevenir bucles infinitos
                // Si se proporciona contenido directamente, usarlo
                // Si no hay contenido Y hay vista, intentar incluir el archivo de vista
                if (isset($data['content']) && !empty($data['content'])) {
                    echo $data['content'];
                } elseif ($view !== null) {
                    self::includeView($view, $data);
                }
                ?>
    </main>

    <?php if ($config['includeFooter']): ?>
    <?php self::includeComponent('ui/footer.ui.php', $data); ?>
    <?php endif; ?>

    <!-- Auth Modal -->
    <?php if ($config['includeAuthModal']): ?>
    <?php self::includeComponent('modals/auth.modal.php', $data); ?>
    <?php endif; ?>



    <?php
            // 2) Ahora renderizar los JS específicos de la vista (si los hay)
            self::renderJsScripts($otherJs);
            ?>

    <!-- JavaScript Específico de la Vista -->
    <?php if ($view !== null && file_exists(__DIR__ . "/../js/{$view}.js")): ?>
    <script src="/js/<?php echo $view; ?>.js"></script>
    <?php endif; ?>

    <!-- Main App JS -->
    <script src="/js/main.js"></script>

    <!-- Auth Modal Handler (después de jQuery) -->
    <?php if ($config['includeAuthModal']): ?>
    <script src="/js/auth-modal.js"></script>
    <?php endif; ?>
</body>

</html>
<?php
    }

    // ===================================
    // MÉTODOS AUXILIARES
    // ===================================

    /**
     * Mapeo de nombres a rutas CSS en node_modules
     */
    private static $cssMap = [
        'bootstrap' => '/node_modules/bootstrap/dist/css/bootstrap.min.css',
        'boxicons' => '/node_modules/boxicons/css/boxicons.min.css',
        'aos' => '/node_modules/aos/dist/aos.css',
        'animate' => '/node_modules/animate.css/animate.min.css',
        'glightbox' => '/node_modules/glightbox/dist/css/glightbox.min.css',
        'sweetalert2' => '/node_modules/sweetalert2/dist/sweetalert2.min.css',
        'notyf' => '/node_modules/notyf/notyf.min.css',
        'tippy' => '/node_modules/tippy.js/dist/tippy.css',
        'datatables' => '/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'datatablesResponsive' => '/node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        'filepond' => '/node_modules/filepond/dist/filepond.min.css',
        'filepondImagePreview' => '/node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
    ];

    /**
     * Mapeo de nombres a rutas JS en node_modules
     */
    private static $jsMap = [
        'axios' => '/node_modules/axios/dist/axios.min.js',
        'modernizr' => '/node_modules/modernizr/dist/modernizr-build.js',
        'jquery' => '/node_modules/jquery/dist/jquery.min.js',
        'popper' => '/node_modules/@popperjs/core/dist/umd/popper.min.js',
        'bootstrap' => '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'aos' => '/node_modules/aos/dist/aos.js',
        'anime' => '/node_modules/animejs/dist/bundles/anime.umd.min.js',
        'glightbox' => '/node_modules/glightbox/dist/js/glightbox.min.js',
        'chart' => '/node_modules/chart.js/dist/chart.umd.js',
        'sweetalert2' => '/node_modules/sweetalert2/dist/sweetalert2.all.min.js',
        'notyf' => '/node_modules/notyf/notyf.min.js',
        'tippy' => '/node_modules/tippy.js/dist/tippy-bundle.umd.min.js',
        'datatables' => '/node_modules/datatables.net/js/dataTables.min.js',
        'datatablesBS5' => '/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
        'datatablesResponsive' => '/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js',
        'dayjs' => '/node_modules/dayjs/dayjs.min.js',
        'filepond' => '/node_modules/filepond/dist/filepond.min.js',
        'filepondValidateType' => '/node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js',
        'filepondValidateSize' => '/node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js',
        'filepondImagePreview' => '/node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js',
        'filepondImageCrop' => '/node_modules/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js',
        'filepondImageResize' => '/node_modules/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js',
        'filepondImageTransform' => '/node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js',
        'filepondImageExif' => '/node_modules/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'
    ];

    /**
     * Renderiza links CSS
     */
    private static function renderCssLinks($cssArray)
    {
        foreach ($cssArray as $cssName) {
            // Verificar si existe en el mapeo, sino intentar con ruta directa /css/
            if (isset(self::$cssMap[$cssName])) {
                $path = self::$cssMap[$cssName];
                echo "    <link rel=\"stylesheet\" href=\"{$path}\">\n";
            } elseif (file_exists(__DIR__ . "/../css/{$cssName}.css")) {
                // Solo cargar si el archivo CSS existe físicamente
                $path = "/css/{$cssName}.css";
                echo "    <link rel=\"stylesheet\" href=\"{$path}\">\n";
            }
            // Si no existe ni en mapeo ni como archivo, no hacer nada (evitar 404)
        }
    }

    /**
     * Renderiza scripts JS
     */
    private static function renderJsScripts($jsArray)
    {
        foreach ($jsArray as $jsName) {
            // Verificar si existe en el mapeo, sino intentar con ruta directa /js/
            if (isset(self::$jsMap[$jsName])) {
                $path = self::$jsMap[$jsName];
                echo "    <script src=\"{$path}\"></script>\n";
            } elseif (file_exists(__DIR__ . "/../js/{$jsName}.js")) {
                // Solo cargar si el archivo JS existe físicamente
                $path = "/js/{$jsName}.js";
                echo "    <script src=\"{$path}\"></script>\n";
            }
            // Si no existe ni en mapeo ni como archivo, no hacer nada (evitar 404)
        }
    }

    /**
     * Incluye una vista
     */
    private static function includeView($view, $data)
    {
        $viewPath = __DIR__ . "/../views/{$view}.view.php";
        if (file_exists($viewPath)) {
            extract($data);
            include $viewPath;
        } else {
            echo "
    <!-- Vista no encontrada: {$view} -->";
        }
    }

    /**
     * Incluye un componente
     */
    private static function includeComponent($component, $data = [])
    {
        $componentPath = __DIR__ . "/../{$component}";
        if (file_exists($componentPath)) {
            extract($data);
            include $componentPath;
        }
    }
}