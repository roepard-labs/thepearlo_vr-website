<?php
/**
 * Página: Configuración
 * Ruta: /dashboard/settings
 * Descripción: Configuración del sistema y preferencias del usuario
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
    <button class="btn btn-primary" id="saveAllSettings">
        <i class="bx bx-save me-1"></i>
        Guardar Cambios
    </button>
</div>

<!-- Tabs de Configuración -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs nav-fill border-bottom" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                    type="button" role="tab">
                    <i class="bx bx-cog me-2"></i>
                    General
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance"
                    type="button" role="tab">
                    <i class="bx bx-palette me-2"></i>
                    Apariencia
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications"
                    type="button" role="tab">
                    <i class="bx bx-bell me-2"></i>
                    Notificaciones
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button"
                    role="tab">
                    <i class="bx bx-shield me-2"></i>
                    Seguridad
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content p-4" id="settingsTabContent">

            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <h5 class="mb-4">Configuración General</h5>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre de la Aplicación</label>
                        <input type="text" class="form-control" value="HomeLab AR" placeholder="Nombre de tu HomeLab">
                        <small class="form-text text-muted">Este nombre aparecerá en el dashboard y
                            notificaciones</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Idioma</label>
                        <select class="form-select">
                            <option value="es" selected>Español</option>
                            <option value="en">English</option>
                            <option value="pt">Português</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Zona Horaria</label>
                        <select class="form-select">
                            <option value="America/Mexico_City" selected>Ciudad de México (GMT-6)</option>
                            <option value="America/New_York">Nueva York (GMT-5)</option>
                            <option value="Europe/Madrid">Madrid (GMT+1)</option>
                            <option value="America/Sao_Paulo">São Paulo (GMT-3)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Formato de Fecha</label>
                        <select class="form-select">
                            <option value="DD/MM/YYYY" selected>DD/MM/YYYY</option>
                            <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                            <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enableAutoSave" checked>
                            <label class="form-check-label" for="enableAutoSave">
                                <span class="fw-semibold">Guardado Automático</span>
                                <br>
                                <small class="text-muted">Guardar cambios automáticamente sin necesidad de hacer clic en
                                    guardar</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enableAnalytics">
                            <label class="form-check-label" for="enableAnalytics">
                                <span class="fw-semibold">Análisis de Uso</span>
                                <br>
                                <small class="text-muted">Ayúdanos a mejorar compartiendo datos anónimos de uso</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appearance Settings -->
            <div class="tab-pane fade" id="appearance" role="tabpanel">
                <h5 class="mb-4">Personalización de Apariencia</h5>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tema</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="theme" id="themeLight" value="light" checked>
                            <label class="btn btn-outline-primary" for="themeLight">
                                <i class="bx bx-sun me-2"></i>Claro
                            </label>

                            <input type="radio" class="btn-check" name="theme" id="themeDark" value="dark">
                            <label class="btn btn-outline-primary" for="themeDark">
                                <i class="bx bx-moon me-2"></i>Oscuro
                            </label>

                            <input type="radio" class="btn-check" name="theme" id="themeAuto" value="auto">
                            <label class="btn btn-outline-primary" for="themeAuto">
                                <i class="bx bx-desktop me-2"></i>Auto
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Color Principal</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="form-control form-control-color" value="#00ff88"
                                title="Elegir color">
                            <input type="text" class="form-control" value="#00ff88" placeholder="#00ff88">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Tamaño de Fuente</label>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted">A</span>
                            <input type="range" class="form-range flex-grow-1" min="12" max="18" value="14" step="1"
                                id="fontSizeRange">
                            <span class="fw-bold">A</span>
                            <span class="badge bg-primary" id="fontSizeValue">14px</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enableAnimations" checked>
                            <label class="form-check-label" for="enableAnimations">
                                <span class="fw-semibold">Animaciones</span>
                                <br>
                                <small class="text-muted">Habilitar animaciones y transiciones en la interfaz</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="compactMode">
                            <label class="form-check-label" for="compactMode">
                                <span class="fw-semibold">Modo Compacto</span>
                                <br>
                                <small class="text-muted">Reducir el espaciado para mostrar más información en
                                    pantalla</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Vista Previa del Tema</label>
                        <div class="card bg-light">
                            <div class="card-body text-center py-5">
                                <h4>Ejemplo de Tarjeta</h4>
                                <p class="text-muted">Este es un ejemplo de cómo se verá tu dashboard con la
                                    configuración actual</p>
                                <button class="btn btn-primary">Botón de Ejemplo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div class="tab-pane fade" id="notifications" role="tabpanel">
                <h5 class="mb-4">Preferencias de Notificaciones</h5>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bx bx-info-circle fs-4 me-3"></i>
                            <div>
                                Controla qué notificaciones quieres recibir y cómo prefieres ser notificado
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">Notificaciones del Sistema</h6>

                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Actualizaciones del Sistema</div>
                                    <small class="text-muted">Recibe notificaciones sobre nuevas versiones y
                                        mejoras</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Alertas de Seguridad</div>
                                    <small class="text-muted">Notificaciones importantes sobre la seguridad de tu
                                        cuenta</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                </div>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Mantenimiento Programado</div>
                                    <small class="text-muted">Avisos sobre mantenimientos y tiempos de
                                        inactividad</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">Notificaciones de Actividad</h6>

                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Nuevos Usuarios</div>
                                    <small class="text-muted">Cuando un nuevo usuario se registra en el sistema</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Cambios en Configuración</div>
                                    <small class="text-muted">Cuando se modifica la configuración del sistema</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">Resumen Diario</div>
                                    <small class="text-muted">Recibe un resumen de actividad al final del día</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Método de Notificación</label>
                        <select class="form-select">
                            <option value="all" selected>Todas (Email + Push + In-App)</option>
                            <option value="email-push">Email + Push</option>
                            <option value="push-only">Solo Push</option>
                            <option value="in-app-only">Solo In-App</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Frecuencia de Emails</label>
                        <select class="form-select">
                            <option value="instant">Instantáneo</option>
                            <option value="hourly" selected>Cada Hora</option>
                            <option value="daily">Diario</option>
                            <option value="weekly">Semanal</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="tab-pane fade" id="security" role="tabpanel">
                <h5 class="mb-4">Seguridad y Privacidad</h5>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bx bx-shield fs-4 me-3"></i>
                            <div>
                                Protege tu cuenta con opciones de seguridad adicionales
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Cambiar Contraseña</h6>
                                        <small class="text-muted">Última actualización: hace 3 meses</small>
                                    </div>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal">
                                        <i class="bx bx-lock me-1"></i>
                                        Cambiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable2FA">
                            <label class="form-check-label" for="enable2FA">
                                <span class="fw-semibold">Autenticación de Dos Factores (2FA)</span>
                                <br>
                                <small class="text-muted">Agrega una capa extra de seguridad a tu cuenta</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                            <label class="form-check-label" for="sessionTimeout">
                                <span class="fw-semibold">Cerrar Sesión Automáticamente</span>
                                <br>
                                <small class="text-muted">Cierra la sesión después de 30 minutos de inactividad</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="loginNotifications" checked>
                            <label class="form-check-label" for="loginNotifications">
                                <span class="fw-semibold">Notificar Inicios de Sesión</span>
                                <br>
                                <small class="text-muted">Recibe un email cada vez que alguien inicie sesión en tu
                                    cuenta</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">Sesiones Activas</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-laptop fs-4 text-primary me-2"></i>
                                            <span class="fw-semibold">Windows - Chrome</span>
                                            <span class="badge bg-success ms-2">Actual</span>
                                        </div>
                                        <small class="text-muted">Ciudad de México, México • Ahora</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-mobile fs-4 text-info me-2"></i>
                                            <span class="fw-semibold">Android - Firefox</span>
                                        </div>
                                        <small class="text-muted">Ciudad de México, México • Hace 2 horas</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-x"></i>
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-outline-danger">
                            <i class="bx bx-log-out me-2"></i>
                            Cerrar Todas las Sesiones
                        </button>
                    </div>
                </div>
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
    (function () {
        'use strict';

        console.log('⚙️ Página: Configuración - Inicializando');

        // ===================================
        // FONT SIZE RANGE
        // ===================================
        const fontSizeRange = document.getElementById('fontSizeRange');
        const fontSizeValue = document.getElementById('fontSizeValue');

        if (fontSizeRange && fontSizeValue) {
            fontSizeRange.addEventListener('input', function () {
                fontSizeValue.textContent = this.value + 'px';
            });
        }

        // ===================================
        // THEME SWITCHER
        // ===================================
        document.querySelectorAll('input[name="theme"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const theme = this.value;
                console.log('Cambiando tema a:', theme);

                if (theme === 'auto') {
                    // Detectar preferencia del sistema
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    document.documentElement.setAttribute('data-bs-theme', prefersDark ? 'dark' : 'light');
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
        document.getElementById('saveAllSettings')?.addEventListener('click', function () {
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
            const themeRadio = document.getElementById(`theme${savedTheme.charAt(0).toUpperCase() + savedTheme.slice(1)}`);
            if (themeRadio) {
                themeRadio.checked = true;
            }
        }

        // ===================================
        // INICIALIZACIÓN
        // ===================================
        document.addEventListener('DOMContentLoaded', function () {
            loadSavedSettings();
            console.log('✅ Configuración inicializada');
        });

    })();
</script>

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
</style>