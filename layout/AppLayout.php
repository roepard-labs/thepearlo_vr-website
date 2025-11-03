<?php
/**
 * AppLayout - Layout Principal
 * HomeLab AR - Roepard Labs
 * 
 * Este layout maneja la estructura HTML base y la carga de dependencias
 */

class AppLayout {
    
    // ===================================
    // CONFIGURACIÓN DE DEPENDENCIAS
    // ===================================
    
    /**
     * CSS Core (siempre se cargan)
     */
    private static $cssCore = ['bootstrap', 'boxicons', 'aos', 'animate'];
    
    /**
     * JS Core (siempre se cargan)
     */
    private static $jsCore = ['axios', 'jquery', 'bootstrap', 'aos'];
    
    /**
     * Mapeo de vistas a sus dependencias
     */
    private static $viewDependencies = [
        'home' => [
            'css' => ['glightbox'],
            'js' => ['glightbox', 'chart', 'anime']
        ],
        'homelab' => [
            'css' => [],
            'js' => [] // VR/AR dependencies loaded separately
        ],
        'dashboard' => [
            'css' => ['datatables', 'datatablesResponsive'],
            'js' => ['datatables', 'datatablesBS5', 'datatablesResponsive']
        ],
        'auth' => [
            'css' => ['sweetalert2'],
            'js' => ['sweetalert2']
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
    public static function render($view, $data = [], $config = []) {
        // Configuración por defecto
        $config = array_merge([
            'title' => 'HomeLab AR',
            'description' => 'Realidad Aumentada para Homelab',
            'includeHeader' => true,
            'includeFooter' => true,
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

    <main id="main-content">
        <?php self::includeView($view, $data); ?>
    </main>

    <?php if ($config['includeFooter']): ?>
    <?php self::includeComponent('ui/footer.ui.php', $data); ?>
    <?php endif; ?>

    <!-- NPM Loader (SIEMPRE primero) -->
    <script src="/composables/npm-loader.js"></script>

    <!-- Config & Router -->
    <script src="/composables/config.js"></script>
    <script src="/composables/router.js"></script>

    <!-- JavaScript Dependencies -->
    <?php self::renderJsScripts($allJs); ?>

    <!-- JavaScript Específico de la Vista -->
    <?php if (file_exists(__DIR__ . "/../js/{$view}.js")): ?>
    <script src="/js/<?php echo $view; ?>.js"></script>
    <?php endif; ?>

    <!-- Main App JS -->
    <script src="/js/main.js"></script>
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
        'datatables' => '/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        'datatablesResponsive' => '/node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css'
    ];
    
    /**
     * Mapeo de nombres a rutas JS en node_modules
     */
    private static $jsMap = [
        'axios' => '/node_modules/axios/dist/axios.min.js',
        'jquery' => '/node_modules/jquery/dist/jquery.min.js',
        'popper' => '/node_modules/@popperjs/core/dist/umd/popper.min.js',
        'bootstrap' => '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'aos' => '/node_modules/aos/dist/aos.js',
        'anime' => '/node_modules/animejs/dist/bundles/anime.umd.min.js',
        'glightbox' => '/node_modules/glightbox/dist/js/glightbox.min.js',
        'chart' => '/node_modules/chart.js/dist/chart.umd.js',
        'sweetalert2' => '/node_modules/sweetalert2/dist/sweetalert2.all.min.js',
        'notyf' => '/node_modules/notyf/notyf.min.js',
        'datatables' => '/node_modules/datatables.net/js/dataTables.min.js',
        'datatablesBS5' => '/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
        'datatablesResponsive' => '/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js'
    ];
    
    /**
     * Renderiza links CSS
     */
    private static function renderCssLinks($cssArray) {
        foreach ($cssArray as $cssName) {
            $path = self::$cssMap[$cssName] ?? "/css/{$cssName}.css";
            echo "    <link rel=\"stylesheet\" href=\"{$path}\">\n";
        }
    }
    
    /**
     * Renderiza scripts JS
     */
    private static function renderJsScripts($jsArray) {
        foreach ($jsArray as $jsName) {
            $path = self::$jsMap[$jsName] ?? "/js/{$jsName}.js";
            echo "    <script src=\"{$path}\"></script>\n";
        }
    }

/**
* Incluye una vista
*/
private static function includeView($view, $data) {
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
private static function includeComponent($component, $data = []) {
$componentPath = __DIR__ . "/../{$component}";
if (file_exists($componentPath)) {
extract($data);
include $componentPath;
}
}
}