<?php
/**
 * Vista: Términos y Condiciones (Dinámica)
 * Ruta: /terms
 * Descripción: Carga el contenido desde la API del backend
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página (SEO y meta tags)
$pageConfig = [
    'title' => 'Términos y Condiciones - HomeLab AR | Roepard Labs',
    'description' => 'Términos y condiciones de uso de HomeLab AR. Consulta nuestras políticas de uso, propiedad intelectual, limitación de responsabilidad y más.',
    'keywords' => 'términos, condiciones, uso aceptable, propiedad intelectual, limitación responsabilidad, HomeLab AR',
    'css' => [],
    'js' => []
];

// PASO 1: Iniciar captura de output buffering
ob_start();
?>

<!-- ================================= -->
<!-- TÉRMINOS Y CONDICIONES DINÁMICOS -->
<!-- ================================= -->

<!-- Loading State -->
<div id="terms-loading" class="container py-5 text-center" style="min-height: 60vh;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Cargando términos y condiciones...</span>
    </div>
    <p class="mt-3 text-muted">Cargando términos y condiciones...</p>
</div>

<!-- Error State -->
<div id="terms-error" class="container py-5 text-center d-none" style="min-height: 60vh;">
    <div class="alert alert-danger" role="alert">
        <i class="bx bx-error-circle fs-1"></i>
        <h4 class="mt-3">Error al Cargar Términos</h4>
        <p id="terms-error-message">No se pudieron cargar los términos y condiciones. Por favor, intenta más tarde.</p>
        <button class="btn btn-primary mt-3" onclick="location.reload()">
            <i class="bx bx-refresh"></i> Reintentar
        </button>
    </div>
</div>

<!-- Content Container -->
<section id="terms-content" class="py-5 d-none">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold mb-3">Términos y Condiciones</h1>
            <p class="lead text-muted" id="terms-subtitle">Consulta nuestros términos de uso y condiciones del servicio
            </p>

            <!-- Metadata -->
            <div class="d-flex justify-content-center gap-4 mt-4 flex-wrap">
                <div class="text-muted">
                    <i class="bx bx-calendar"></i>
                    <strong>Vigencia:</strong>
                    <span id="terms-effective-date">-</span>
                </div>
                <div class="text-muted">
                    <i class="bx bx-time"></i>
                    <strong>Última actualización:</strong>
                    <span id="terms-last-updated">-</span>
                </div>
                <div class="text-muted">
                    <i class="bx bx-tag"></i>
                    <strong>Versión:</strong>
                    <span id="terms-version">-</span>
                </div>
            </div>
        </div>

        <!-- Sections Container -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="terms-sections-container">
                    <!-- Las secciones se cargarán dinámicamente aquí -->
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Estilos para el contenido de términos */
    #terms-sections-container h2 {
        color: var(--bs-emphasis-color);
        border-bottom: 2px solid var(--bs-primary);
        padding-bottom: 0.5rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    #terms-sections-container h3 {
        color: var(--bs-emphasis-color);
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    #terms-sections-container p {
        margin-bottom: 1rem;
        line-height: 1.8;
    }

    #terms-sections-container ul,
    #terms-sections-container ol {
        line-height: 1.8;
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    #terms-sections-container li {
        margin-bottom: 0.5rem;
    }

    /* Estilos para metadata badges */
    #terms-content .text-muted {
        font-size: 0.95rem;
    }

    /* Animaciones suaves */
    .section-paragraphs {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===================================== */
    /* MODO OSCURO - SweetAlert2 Customization */
    /* ===================================== */

    /* Modal principal en modo oscuro */
    [data-bs-theme="dark"] .swal2-popup {
        background-color: #1a1d29 !important;
        color: #e9ecef !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    /* Título del modal */
    [data-bs-theme="dark"] .swal2-title {
        color: #ffffff !important;
    }

    /* Contenido HTML del modal */
    [data-bs-theme="dark"] .swal2-html-container {
        color: #e9ecef !important;
    }

    /* Textos pequeños (labels) */
    [data-bs-theme="dark"] .swal2-html-container .text-muted {
        color: #adb5bd !important;
    }

    /* Textos con peso semibold */
    [data-bs-theme="dark"] .swal2-html-container .fw-semibold {
        color: #f8f9fa !important;
    }

    /* Botones del modal */
    [data-bs-theme="dark"] .swal2-confirm,
    [data-bs-theme="dark"] .swal2-cancel {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    }

    /* Botón de confirmar (primary) */
    [data-bs-theme="dark"] .swal2-confirm {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }

    [data-bs-theme="dark"] .swal2-confirm:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
    }

    /* Botón de cancelar */
    [data-bs-theme="dark"] .swal2-cancel {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: #fff !important;
    }

    [data-bs-theme="dark"] .swal2-cancel:hover {
        background-color: #5c636a !important;
        border-color: #565e64 !important;
    }

    /* Botón de cerrar (X) */
    [data-bs-theme="dark"] .swal2-close {
        color: #adb5bd !important;
    }

    [data-bs-theme="dark"] .swal2-close:hover {
        color: #ffffff !important;
    }

    /* Inputs del formulario en modal */
    [data-bs-theme="dark"] .swal2-input,
    [data-bs-theme="dark"] .swal2-textarea,
    [data-bs-theme="dark"] .swal2-select,
    [data-bs-theme="dark"] .swal2-html-container input,
    [data-bs-theme="dark"] .swal2-html-container textarea,
    [data-bs-theme="dark"] .swal2-html-container select {
        background-color: rgba(255, 255, 255, 0.05) !important;
        color: #f8f9fa !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }

    [data-bs-theme="dark"] .swal2-input:focus,
    [data-bs-theme="dark"] .swal2-textarea:focus,
    [data-bs-theme="dark"] .swal2-select:focus,
    [data-bs-theme="dark"] .swal2-html-container input:focus,
    [data-bs-theme="dark"] .swal2-html-container textarea:focus,
    [data-bs-theme="dark"] .swal2-html-container select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }

    /* Labels de formulario */
    [data-bs-theme="dark"] .swal2-html-container label,
    [data-bs-theme="dark"] .swal2-html-container .form-label {
        color: #adb5bd !important;
    }

    /* Placeholder de inputs */
    [data-bs-theme="dark"] .swal2-input::placeholder,
    [data-bs-theme="dark"] .swal2-textarea::placeholder,
    [data-bs-theme="dark"] .swal2-html-container input::placeholder,
    [data-bs-theme="dark"] .swal2-html-container textarea::placeholder {
        color: #6c757d !important;
    }

    /* Badges en modal */
    [data-bs-theme="dark"] .swal2-html-container .badge {
        font-weight: 500 !important;
    }

    /* Loader/Loading spinner */
    [data-bs-theme="dark"] .swal2-loader {
        border-color: #0d6efd transparent #0d6efd transparent !important;
    }

    /* Modal de confirmación de loading */
    [data-bs-theme="dark"] .swal2-loading .swal2-styled {
        background-color: transparent !important;
        color: #f8f9fa !important;
    }

    /* Dividers/Separadores */
    [data-bs-theme="dark"] .swal2-html-container hr {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Select options en modo oscuro */
    [data-bs-theme="dark"] .swal2-select option,
    [data-bs-theme="dark"] .swal2-html-container select option {
        background-color: #1a1d29 !important;
        color: #f8f9fa !important;
    }

    /* Checkbox y radio buttons */
    [data-bs-theme="dark"] .swal2-html-container input[type="checkbox"],
    [data-bs-theme="dark"] .swal2-html-container input[type="radio"] {
        border-color: rgba(255, 255, 255, 0.15) !important;
    }

    /* Background del modal overlay */
    [data-bs-theme="dark"] .swal2-container.swal2-backdrop-show {
        background: rgba(0, 0, 0, 0.7) !important;
    }

    /* Iconos del modal */
    [data-bs-theme="dark"] .swal2-icon {
        border-color: #e9ecef !important;
    }

    [data-bs-theme="dark"] .swal2-icon .swal2-icon-content {
        color: #e9ecef !important;
    }

    /* ===================================== */
    /* MODO CLARO - SweetAlert2 (mejoras) */
    /* ===================================== */

    /* Asegurar buen contraste en modo claro */
    [data-bs-theme="light"] .swal2-popup {
        background-color: #ffffff !important;
        color: #212529 !important;
    }

    [data-bs-theme="light"] .swal2-html-container .text-muted {
        color: #6c757d !important;
    }

    [data-bs-theme="light"] .swal2-input,
    [data-bs-theme="light"] .swal2-textarea,
    [data-bs-theme="light"] .swal2-select,
    [data-bs-theme="light"] .swal2-html-container input,
    [data-bs-theme="light"] .swal2-html-container textarea,
    [data-bs-theme="light"] .swal2-html-container select {
        background-color: #ffffff !important;
        color: #212529 !important;
        border: 1px solid #dee2e6 !important;
    }

    [data-bs-theme="light"] .swal2-input:focus,
    [data-bs-theme="light"] .swal2-textarea:focus,
    [data-bs-theme="light"] .swal2-select:focus,
    [data-bs-theme="light"] .swal2-html-container input:focus,
    [data-bs-theme="light"] .swal2-html-container textarea:focus,
    [data-bs-theme="light"] .swal2-html-container select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
    }
</style>

<!-- JavaScript para Cargar Contenido -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('📄 Terms View: DOM cargado, esperando AppRouter...');

        // Esperar a que AppRouter esté disponible
        const checkRouter = setInterval(() => {
            if (window.AppRouter) {
                clearInterval(checkRouter);
                console.log('✅ Terms View: AppRouter disponible, cargando contenido...');
                loadTermsContent();
            }
        }, 100);
    });

    /**
     * Carga el contenido de términos desde la API
     */
    async function loadTermsContent() {
        const loadingDiv = document.getElementById('terms-loading');
        const errorDiv = document.getElementById('terms-error');
        const contentDiv = document.getElementById('terms-content');
        const errorMessage = document.getElementById('terms-error-message');

        try {
            console.log('📄 Cargando términos y condiciones desde API...');

            // Llamar a la API pública
            const response = await window.AppRouter.get('/routes/web/terms.php');

            console.log('✅ Términos cargados:', response);

            if (response.status === 'success' && response.data) {
                renderTermsContent(response.data);

                // Ocultar loading, mostrar content
                loadingDiv.classList.add('d-none');
                contentDiv.classList.remove('d-none');

                // Inicializar animaciones AOS si está disponible
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            } else {
                throw new Error(response.message || 'Formato de respuesta inválido');
            }

        } catch (error) {
            console.error('❌ Error al cargar términos:', error);

            // Mostrar error
            errorMessage.textContent = `Error: ${error.message || 'No se pudieron cargar los términos'}`;
            loadingDiv.classList.add('d-none');
            errorDiv.classList.remove('d-none');
        }
    }

    /**
     * Renderiza el contenido de términos en el DOM
     * @param {Object} data - Datos de términos desde la API
     */
    function renderTermsContent(data) {
        const { metadata, sections, total_sections } = data;

        // Renderizar metadata
        if (metadata) {
            // Formatear fecha de vigencia
            const effectiveDate = metadata.effective_date ?
                new Date(metadata.effective_date).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) : '-';

            // Formatear última actualización
            const lastUpdated = metadata.last_updated ?
                new Date(metadata.last_updated).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) : '-';

            document.getElementById('terms-effective-date').textContent = effectiveDate;
            document.getElementById('terms-last-updated').textContent = lastUpdated;
            document.getElementById('terms-version').textContent = metadata.version || '1.0';
        }

        // Renderizar secciones
        const sectionsContainer = document.getElementById('terms-sections-container');
        sectionsContainer.innerHTML = '';

        sections.forEach((section, index) => {
            const sectionHtml = `
            <div class="mb-5" data-aos="fade-up" data-aos-delay="${index * 100}">
                <h2 class="h3 fw-bold mb-4">
                    ${section.section_number}. ${section.section_title}
                </h2>
                <div class="section-paragraphs">
                    ${renderParagraphs(section.paragraphs)}
                </div>
            </div>
        `;
            sectionsContainer.innerHTML += sectionHtml;
        });

        console.log(`✅ Renderizadas ${total_sections} secciones de términos`);
    }

    /**
     * Renderiza los párrafos de una sección
     * @param {Array} paragraphs - Array de párrafos
     * @returns {string} HTML de párrafos
     */
    function renderParagraphs(paragraphs) {
        return paragraphs.map(p => `
        <p class="text-muted mb-3" style="text-align: justify; line-height: 1.8;">
            ${escapeHtml(p.content)}
        </p>
    `).join('');
    }

    /**
     * Formatea una fecha en formato legible
     * @param {string} dateString - Fecha en formato YYYY-MM-DD
     * @returns {string} Fecha formateada
     */
    function formatDate(dateString) {
        if (!dateString) return '-';

        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };

        return date.toLocaleDateString('es-ES', options);
    }

    /**
     * Formatea una fecha y hora en formato legible
     * @param {string} datetimeString - Fecha/hora en formato YYYY-MM-DD HH:mm:ss
     * @returns {string} Fecha/hora formateada
     */
    function formatDateTime(datetimeString) {
        if (!datetimeString) return '-';

        const date = new Date(datetimeString);
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };

        return date.toLocaleDateString('es-ES', options);
    }

    /**
     * Escapa HTML para prevenir XSS
     * @param {string} text - Texto a escapar
     * @returns {string} Texto escapado
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>

<!-- ================================= -->
<!-- FIN DEL CONTENIDO -->
<!-- ================================= -->

<?php
// PASO 2: Capturar todo el contenido generado
$content = ob_get_clean();

// PASO 3: Renderizar con AppLayout
// CRÍTICO: Pasar contenido directamente para evitar bucle infinito
AppLayout::render('terms-dynamic', ['content' => $content], $pageConfig);
?>