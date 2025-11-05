/**
 * NPM Dependencies Loader
 * Configuración centralizada de rutas a node_modules
 * HomeLab VR - Roepard Labs
 */

// ============================================
// CONFIGURACIÓN DE RUTAS
// ============================================

const NPM_CONFIG = {
    // Ruta base de node_modules (relativa desde /views/)
    basePath: '../node_modules',

    // CSS Dependencies
    css: {
        bootstrap: '/bootstrap/dist/css/bootstrap.min.css',
        boxicons: '/boxicons/css/boxicons.min.css',
        sweetalert2: '/sweetalert2/dist/sweetalert2.min.css',
        glightbox: '/glightbox/dist/css/glightbox.min.css',
        aos: '/aos/dist/aos.css',
        animate: '/animate.css/animate.min.css',
        datatables: '/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
        datatablesResponsive: '/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css',
        notyf: '/notyf/notyf.min.css',
        tippy: '/tippy.js/dist/tippy.css',
        tippyScale: '/tippy.js/animations/scale.css',
        photoswipe: '/photoswipe/dist/photoswipe.css',
        videojs: '/video.js/dist/video-js.min.css',
        tomselect: '/tom-select/dist/css/tom-select.bootstrap5.min.css',
        flatpickr: '/flatpickr/dist/flatpickr.min.css',

        // FilePond CSS
        filepond: '/filepond/dist/filepond.min.css',
        filepondImagePreview: '/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css',
        filepondImageEdit: '/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.min.css',
        filepondPoster: '/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css'
    },

    // JavaScript Dependencies
    js: {
        // ✨ HTTP Client (NUEVO - Principal)
        axios: '/axios/dist/axios.min.js',

        // Core libraries
        popper: '/@popperjs/core/dist/umd/popper.min.js',
        bootstrap: '/bootstrap/dist/js/bootstrap.bundle.min.js',
        jquery: '/jquery/dist/jquery.min.js',

        // UI Components
        aos: '/aos/dist/aos.js',
        anime: '/animejs/dist/bundles/anime.umd.min.js',
        sweetalert2: '/sweetalert2/dist/sweetalert2.all.min.js',
        chart: '/chart.js/dist/chart.umd.js',
        dayjs: '/dayjs/dayjs.min.js',
        glightbox: '/glightbox/dist/js/glightbox.min.js',

        // DataTables
        datatables: '/datatables.net/js/dataTables.min.js',
        datatablesBS5: '/datatables.net-bs5/js/dataTables.bootstrap5.min.js',
        datatablesResponsive: '/datatables.net-responsive/js/dataTables.responsive.min.js',
        datatablesResponsiveBS5: '/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js',

        // Notifications & UI
        notyf: '/notyf/notyf.min.js',
        tippy: '/tippy.js/dist/tippy-bundle.umd.min.js',

        // Form components
        tomselect: '/tom-select/dist/js/tom-select.complete.min.js',
        flatpickr: '/flatpickr/dist/flatpickr.min.js',

        // FilePond Core
        filepond: '/filepond/dist/filepond.min.js',

        // FilePond Plugins
        filepondEncode: '/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js',
        filepondMetadata: '/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.min.js',
        filepondPoster: '/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.js',
        filepondRename: '/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.min.js',
        filepondValidateSize: '/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js',
        filepondValidateType: '/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js',
        filepondImageCrop: '/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js',
        filepondImageEdit: '/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.min.js',
        filepondImageExif: '/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js',
        filepondImageFilter: '/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.min.js',
        filepondImagePreview: '/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js',
        filepondImageResize: '/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js',
        filepondImageTransform: '/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js',
        filepondImageValidateSize: '/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.min.js',
        filepondMediaPreview: '/filepond-plugin-media-preview/dist/filepond-plugin-media-preview.min.js',
        filepondPdfPreview: '/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.js',

        // Video
        videojs: '/video.js/dist/video.min.js'
    },

    // VR/AR Dependencies
    vr: {
        aframe: '/aframe/dist/aframe-master.min.js',
        arjs: '/ar.js/aframe/build/aframe-ar.min.js',
        three: '/three/build/three.module.js',
        webvrPolyfill: '/webvr-polyfill/build/webvr-polyfill.min.js'
    }
};

// ============================================
// FUNCIONES HELPER
// ============================================

/**
 * Obtener ruta completa de un asset CSS
 * @param {string} name - Nombre del paquete
 * @returns {string} Ruta completa
 */
function getCSSPath(name) {
    return NPM_CONFIG.basePath + (NPM_CONFIG.css[name] || '');
}

/**
 * Obtener ruta completa de un asset JS
 * @param {string} name - Nombre del paquete
 * @returns {string} Ruta completa
 */
function getJSPath(name) {
    return NPM_CONFIG.basePath + (NPM_CONFIG.js[name] || '');
}

/**
 * Obtener ruta completa de un asset VR/AR
 * @param {string} name - Nombre del paquete
 * @returns {string} Ruta completa
 */
function getVRPath(name) {
    return NPM_CONFIG.basePath + (NPM_CONFIG.vr[name] || '');
}

/**
 * Cargar un CSS dinámicamente
 * @param {string} name - Nombre del paquete
 * @returns {Promise<void>}
 */
function loadCSS(name) {
    return new Promise((resolve, reject) => {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = getCSSPath(name);
        link.onload = () => resolve();
        link.onerror = () => reject(new Error(`Failed to load CSS: ${name}`));
        document.head.appendChild(link);
    });
}

/**
 * Cargar un JS dinámicamente
 * @param {string} name - Nombre del paquete
 * @returns {Promise<void>}
 */
function loadJS(name) {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = getJSPath(name);
        script.onload = () => resolve();
        script.onerror = () => reject(new Error(`Failed to load JS: ${name}`));
        document.body.appendChild(script);
    });
}

/**
 * Cargar múltiples scripts en orden
 * @param {string[]} names - Array de nombres de paquetes
 * @returns {Promise<void>}
 */
async function loadJSSequential(names) {
    for (const name of names) {
        await loadJS(name);
    }
}

/**
 * Verificar si una librería está cargada
 * @param {string} name - Nombre del paquete
 * @returns {boolean}
 */
function isLoaded(name) {
    const checks = {
        axios: typeof axios !== 'undefined',
        jquery: typeof $ !== 'undefined',
        bootstrap: typeof bootstrap !== 'undefined',
        sweetalert2: typeof Swal !== 'undefined',
        chart: typeof Chart !== 'undefined',
        datatables: typeof $.fn?.dataTable !== 'undefined',
        notyf: typeof Notyf !== 'undefined',
        aos: typeof AOS !== 'undefined',
        glightbox: typeof GLightbox !== 'undefined',
        tomselect: typeof TomSelect !== 'undefined',
        flatpickr: typeof flatpickr !== 'undefined',
        filepond: typeof FilePond !== 'undefined',
        videojs: typeof videojs !== 'undefined',
        aframe: typeof AFRAME !== 'undefined',
        three: typeof THREE !== 'undefined'
    };

    return checks[name] || false;
}

/**
 * Reporte de dependencias cargadas
 */
function reportLoadedDependencies() {
    const report = {
        Axios: isLoaded('axios'),
        jQuery: isLoaded('jquery'),
        Bootstrap: isLoaded('bootstrap'),
        SweetAlert2: isLoaded('sweetalert2'),
        'Chart.js': isLoaded('chart'),
        DataTables: isLoaded('datatables'),
        Notyf: isLoaded('notyf'),
        AOS: isLoaded('aos'),
        Glightbox: isLoaded('glightbox'),
        TomSelect: isLoaded('tomselect'),
        Flatpickr: isLoaded('flatpickr'),
        FilePond: isLoaded('filepond'),
        'Video.js': isLoaded('videojs'),
        'A-Frame': isLoaded('aframe'),
        'Three.js': isLoaded('three')
    };

    console.log('%c📦 Estado de Dependencias NPM', 'color: #00ff88; font-size: 16px; font-weight: bold;');
    console.table(report);

    const loaded = Object.values(report).filter(v => v).length;
    const total = Object.keys(report).length;
    console.log(`%c✅ ${loaded}/${total} dependencias cargadas correctamente`, 'color: #00ff88; font-weight: bold;');

    return report;
}

// ============================================
// EXPORTAR CONFIGURACIÓN
// ============================================

// Para uso global
window.NPM_CONFIG = NPM_CONFIG;
window.getCSSPath = getCSSPath;
window.getJSPath = getJSPath;
window.getVRPath = getVRPath;
window.loadCSS = loadCSS;
window.loadJS = loadJS;
window.loadJSSequential = loadJSSequential;
window.isLoaded = isLoaded;
window.reportLoadedDependencies = reportLoadedDependencies;

// Log de inicialización
console.log('%c⚙️ NPM Loader inicializado', 'color: #0088ff; font-weight: bold;');
console.log('Rutas disponibles:', NPM_CONFIG);
