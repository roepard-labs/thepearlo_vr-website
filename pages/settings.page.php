<?php
/**
 * Página: Configuración
 * Ruta: /dashboard/settings
 * Descripción: Configuración del sistema para administradores
 * HomeLab AR - Roepard Labs
 */

// Esta página solo se incluye desde dashboard.view.php
// No debe accederse directamente
?>

<!-- Header de la Página -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">
            <i class="bx bx-cog me-2 text-primary"></i>
            Configuración
        </h2>
        <p class="text-muted mb-0">Personaliza tu experiencia en HomeLab AR</p>
    </div>
</div>

<!-- Tabs de Configuración -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs nav-fill border-bottom" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy-content"
                    type="button" role="tab">
                    <i class="bx bx-shield me-2"></i>
                    Política de Privacidad
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms-content"
                    type="button" role="tab">
                    <i class="bx bx-file-blank me-2"></i>
                    Términos y Condiciones
                </button>
            </li>
        </ul> <!-- Tab Content -->
        <div class="tab-content p-4" id="settingsTabContent">

            <!-- Privacy Policy Content (Admin Only) -->
            <div class="tab-pane fade show active" id="privacy-content" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">
                            <i class="bx bx-shield me-2 text-primary"></i>
                            Política de Privacidad
                        </h5>
                        <p class="text-muted mb-0">Gestiona el contenido de la política de privacidad del sitio web</p>
                    </div>
                    <a href="/privacy" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-link-external me-1"></i>
                        Ver Pública
                    </a>
                </div>

                <!-- Loading State -->
                <div id="privacy-loading" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="text-muted">Cargando contenido de privacidad...</p>
                </div>

                <!-- Editor Container -->
                <div id="privacy-editor-container"></div>
            </div>

            <!-- Terms and Conditions Content (Admin Only) -->
            <div class="tab-pane fade" id="terms-content" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">
                            <i class="bx bx-file-blank me-2 text-primary"></i>
                            Términos y Condiciones
                        </h5>
                        <p class="text-muted mb-0">Gestiona el contenido de los términos y condiciones del sitio web</p>
                    </div>
                    <a href="/terms" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-link-external me-1"></i>
                        Ver Pública
                    </a>
                </div>

                <!-- Loading State -->
                <div id="terms-loading" class="text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="text-muted">Cargando contenido de términos...</p>
                </div>

                <!-- Editor Container -->
                <div id="terms-editor-container"></div>
            </div>

        </div>
    </div>
</div>

<!-- Modal: Cambiar Contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-lock me-2"></i>
                    Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                        <small class="form-text text-muted">Mínimo 8 caracteres, incluye mayúsculas, minúsculas y
                            números</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i>
                    Actualizar Contraseña
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    console.log('⚙️ Página: Configuración - Inicializando');

    // ===================================
    // FONT SIZE RANGE
    // ===================================
    const fontSizeRange = document.getElementById('fontSizeRange');
    const fontSizeValue = document.getElementById('fontSizeValue');

    if (fontSizeRange && fontSizeValue) {
        fontSizeRange.addEventListener('input', function() {
            fontSizeValue.textContent = this.value + 'px';
        });
    }

    // ===================================
    // THEME SWITCHER
    // ===================================
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const theme = this.value;
            console.log('Cambiando tema a:', theme);

            if (theme === 'auto') {
                // Detectar preferencia del sistema
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-bs-theme', prefersDark ? 'dark' :
                    'light');
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme);
            }

            // Guardar preferencia
            localStorage.setItem('theme-preference', theme);

            // Mostrar notificación
            if (typeof Notyf !== 'undefined') {
                const notyf = new Notyf();
                notyf.success('Tema actualizado correctamente');
            }
        });
    });

    // ===================================
    // GUARDAR CONFIGURACIÓN
    // ===================================
    document.getElementById('saveAllSettings')?.addEventListener('click', function() {
        // Aquí iría la lógica para guardar en el backend
        console.log('💾 Guardando configuración...');

        // Simulación de guardado
        this.disabled = true;
        this.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Guardando...';

        setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="bx bx-save me-1"></i>Guardar Cambios';

            if (typeof Notyf !== 'undefined') {
                const notyf = new Notyf();
                notyf.success('Configuración guardada exitosamente');
            }
        }, 1500);
    });

    // ===================================
    // CARGAR CONFIGURACIÓN GUARDADA
    // ===================================
    function loadSavedSettings() {
        // Cargar tema guardado
        const savedTheme = localStorage.getItem('theme-preference') || 'light';
        const themeRadio = document.getElementById(
            `theme${savedTheme.charAt(0).toUpperCase() + savedTheme.slice(1)}`);
        if (themeRadio) {
            themeRadio.checked = true;
        }
    }

    // ===================================
    // INICIALIZACIÓN
    // ===================================
    document.addEventListener('DOMContentLoaded', function() {
        loadSavedSettings();
        console.log('✅ Configuración inicializada');
    });

})();
</script>

<!-- Legal Content Editor (Admin Only) -->
<script src="../js/legal-editor.js"></script>

<style>
.nav-tabs .nav-link {
    color: var(--bs-secondary);
    border: none;
    padding: 1rem 1.5rem;
    transition: all 0.2s ease;
}

.nav-tabs .nav-link:hover {
    color: var(--bs-primary);
    background-color: var(--bs-light);
}

.nav-tabs .nav-link.active {
    color: var(--bs-primary);
    background-color: transparent;
    border-bottom: 3px solid var(--bs-primary);
    font-weight: 600;
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}

.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

/* ===================================
       ESTILOS DE MODALES SWEETALERT2 - MODO OSCURO
    =================================== */

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

/* ===================================
       ESTILOS DE MODALES SWEETALERT2 - MODO CLARO (mejoras)
    =================================== */

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