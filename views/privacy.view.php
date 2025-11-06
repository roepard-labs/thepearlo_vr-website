<?php
/**
 * Vista: Privacy Policy
 * Política de privacidad (contenido dinámico desde API)
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página
$pageConfig = [
    'title' => 'Política de Privacidad - HomeLab AR | Roepard Labs',
    'description' => 'Conoce cómo protegemos tus datos y respetamos tu privacidad en HomeLab AR.',
    'keywords' => 'privacidad, política, protección datos, GDPR, seguridad',
    'css' => [],
    'js' => []
];

// Capturar contenido
ob_start();
?>

<section class="py-5 bg-body">
    <div class="container py-5">
        <!-- Header -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 fw-bold mb-3">Política de Privacidad</h1>
                <p class="text-muted" id="last-updated">
                    <i class="bx bx-time me-1"></i>
                    <span>Cargando...</span>
                </p>
            </div>
        </div>

        <!-- Loading State -->
        <div class="row" id="loading-state">
            <div class="col-lg-8 mx-auto text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="text-muted">Cargando política de privacidad...</p>
            </div>
        </div>

        <!-- Contenido Dinámico -->
        <div class="row" id="content-container" style="display: none;">
            <div class="col-lg-8 mx-auto">
                <div class="content-wrapper" id="privacy-content">
                    <!-- El contenido se cargará dinámicamente -->
                </div>

                <!-- Botón volver -->
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="/" class="btn btn-primary btn-lg px-5">
                        <i class="bx bx-home me-2"></i>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div class="row" id="error-state" style="display: none;">
            <div class="col-lg-8 mx-auto text-center py-5">
                <i class="bx bx-error-circle display-1 text-danger mb-3"></i>
                <h3>Error al cargar el contenido</h3>
                <p class="text-muted mb-4">No se pudo cargar la política de privacidad. Por favor, intenta nuevamente.
                </p>
                <button class="btn btn-primary" onclick="loadPrivacyContent()">
                    <i class="bx bx-refresh me-2"></i>
                    Reintentar
                </button>
            </div>
        </div>
    </div>
</section>

<style>
    /* Estilos para el contenido de privacidad */
    .content-wrapper h2 {
        color: var(--bs-emphasis-color);
        border-bottom: 2px solid var(--bs-primary);
        padding-bottom: 0.5rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    .content-wrapper h3 {
        color: var(--bs-emphasis-color);
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .content-wrapper ul,
    .content-wrapper ol {
        line-height: 1.8;
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    .content-wrapper li {
        margin-bottom: 0.5rem;
    }

    .content-wrapper p {
        margin-bottom: 1rem;
        line-height: 1.8;
    }

    /* Estilos para metadata badges */
    #last-updated .badge {
        vertical-align: middle;
    }

    /* Animaciones suaves */
    .content-wrapper>div {
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

<script>
    (function () {
        'use strict';

        console.log('📄 Vista: Privacy - Inicializando');

        /**
         * Cargar contenido de privacidad desde API
         */
        async function loadPrivacyContent() {
            try {
                // Mostrar loading
                document.getElementById('loading-state').style.display = 'block';
                document.getElementById('content-container').style.display = 'none';
                document.getElementById('error-state').style.display = 'none';

                // Llamar a API pública
                const response = await window.AppRouter.get('/routes/web/privacy.php');

                if (response.status === 'success' && response.data) {
                    renderPrivacyContent(response.data);
                } else {
                    throw new Error(response.message || 'Error al cargar contenido');
                }
            } catch (error) {
                console.error('❌ Error al cargar privacidad:', error);
                showErrorState();
            }
        }

        /**
         * Renderizar contenido de privacidad
         */
        function renderPrivacyContent(data) {
            const container = document.getElementById('privacy-content');
            const { metadata, sections } = data;

            // Actualizar fecha
            if (metadata && metadata.effective_date) {
                const date = new Date(metadata.effective_date);
                const formattedDate = date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById('last-updated').innerHTML = `
                <i class="bx bx-time me-1"></i>
                <span>Última actualización: ${formattedDate}</span>
                ${metadata.version ? `<span class="badge bg-primary ms-2">v${metadata.version}</span>` : ''}
            `;
            }

            // Renderizar secciones
            let html = '';
            sections.forEach((section, index) => {
                html += `
                <div class="mb-5" data-aos="fade-up" data-aos-delay="${index * 100}">
                    <h2 class="h3">${section.section_number}. ${section.section_title}</h2>
            `;

                // Renderizar párrafos
                section.paragraphs.forEach(paragraph => {
                    const content = paragraph.content;

                    // Detectar si es una subsección (empieza con número.número)
                    if (/^(\d+\.\d+)/.test(content)) {
                        html += `<h3 class="h5">${content}</h3>`;
                    } else if (content.length < 100 && !content.endsWith('.')) {
                        // Probablemente es un item de lista
                        html += `<li>${content}</li>`;
                    } else {
                        html += `<p class="text-muted">${content}</p>`;
                    }
                });

                html += `</div>`;
            });

            container.innerHTML = html;

            // Ocultar loading, mostrar contenido
            document.getElementById('loading-state').style.display = 'none';
            document.getElementById('content-container').style.display = 'block';

            // Reinicializar AOS para nuevos elementos
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }

            console.log('✅ Contenido de privacidad cargado:', sections.length, 'secciones');
        }

        /**
         * Mostrar estado de error
         */
        function showErrorState() {
            document.getElementById('loading-state').style.display = 'none';
            document.getElementById('content-container').style.display = 'none';
            document.getElementById('error-state').style.display = 'block';
        }

        // Exponer función globalmente
        window.loadPrivacyContent = loadPrivacyContent;

        // Cargar contenido al inicializar
        document.addEventListener('DOMContentLoaded', function () {
            console.log('📄 Privacy View: DOM cargado, iniciando carga de contenido');

            // Esperar a que AppRouter esté disponible
            const checkRouter = setInterval(() => {
                if (window.AppRouter) {
                    clearInterval(checkRouter);
                    loadPrivacyContent();
                }
            }, 100);
        });

    })();
</script>

<?php
$content = ob_get_clean();

// CRÍTICO: Pasar NULL como vista para evitar bucle infinito
AppLayout::render(null, ['content' => $content], $pageConfig);
?>