<?php
/**
 * Página: Perfil de Usuario
 * Ruta: /dashboard/profile
 * Descripción: Perfil personal del usuario con información editable
 * HomeLab AR - Roepard Labs
 */

// Esta página solo se incluye desde dashboard.view.php
// No debe accederse directamente
?>

<!-- Header de la Página -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">
            <i class="bx bx-user-circle me-2 text-primary"></i>
            Mi Perfil
        </h2>
        <p class="text-muted mb-0">Administra tu información personal</p>
    </div>
    <button class="btn btn-primary" id="saveProfile">
        <i class="bx bx-save me-1"></i>
        Guardar Cambios
    </button>
</div>

<div class="row g-4">

    <!-- Columna Izquierda: Foto de Perfil -->
    <div class="col-lg-4">

        <!-- Card: Avatar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                <div class="position-relative d-inline-block mb-3">
                    <div class="avatar-xl bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto"
                        style="width: 120px; height: 120px;">
                        <i class="bx bx-user text-white" style="font-size: 60px;"></i>
                    </div>
                    <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0"
                        title="Cambiar foto" style="width: 35px; height: 35px;">
                        <i class="bx bx-camera"></i>
                    </button>
                </div>
                <h4 class="mb-1" id="profileDisplayName">Juan Pérez</h4>
                <p class="text-muted mb-3" id="profileUsername">@juanperez</p>
                <div class="d-flex gap-2 justify-content-center">
                    <span class="badge bg-primary" id="profileRole">Administrador</span>
                    <span class="badge bg-success">Activo</span>
                </div>
            </div>
        </div>

        <!-- Card: Estadísticas Rápidas -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="bx bx-bar-chart me-2"></i>
                    Mi Actividad
                </h6>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Último acceso</small>
                        <span class="fw-semibold">Hace 5 minutos</span>
                    </div>
                    <i class="bx bx-time-five fs-4 text-primary"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Miembro desde</small>
                        <span class="fw-semibold">Enero 2024</span>
                    </div>
                    <i class="bx bx-calendar fs-4 text-success"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block">Sesiones activas</small>
                        <span class="fw-semibold">2 dispositivos</span>
                    </div>
                    <i class="bx bx-devices fs-4 text-info"></i>
                </div>
            </div>
        </div>

        <!-- Card: Insignias -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="bx bx-award me-2"></i>
                    Insignias
                </h6>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-warning text-dark" title="Usuario destacado">
                        <i class="bx bx-star me-1"></i>Destacado
                    </span>
                    <span class="badge bg-info" title="Early adopter">
                        <i class="bx bx-rocket me-1"></i>Early Bird
                    </span>
                    <span class="badge bg-success" title="100% de perfil completado">
                        <i class="bx bx-check-circle me-1"></i>Completo
                    </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Columna Derecha: Información del Perfil -->
    <div class="col-lg-8">

        <!-- Tabs de Información -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs nav-fill border-bottom" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                            data-bs-target="#personal" type="button" role="tab">
                            <i class="bx bx-user me-2"></i>
                            Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab">
                            <i class="bx bx-envelope me-2"></i>
                            Contacto
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                            type="button" role="tab">
                            <i class="bx bx-share-alt me-2"></i>
                            Social
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences"
                            type="button" role="tab">
                            <i class="bx bx-cog me-2"></i>
                            Preferencias
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content p-4" id="profileTabContent">

                    <!-- Información Personal -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <h5 class="mb-4">Información Personal</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre</label>
                                <input type="text" class="form-control" value="Juan" placeholder="Tu nombre">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellido</label>
                                <input type="text" class="form-control" value="Pérez" placeholder="Tu apellido">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" value="juanperez" placeholder="username">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" value="1990-01-15">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Género</label>
                                <select class="form-select">
                                    <option value="">Prefiero no decirlo</option>
                                    <option value="M" selected>Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="O">Otro</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">País</label>
                                <select class="form-select">
                                    <option value="MX" selected>México</option>
                                    <option value="US">Estados Unidos</option>
                                    <option value="ES">España</option>
                                    <option value="AR">Argentina</option>
                                    <option value="CO">Colombia</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Biografía</label>
                                <textarea class="form-control" rows="4"
                                    placeholder="Cuéntanos sobre ti...">Desarrollador apasionado por la realidad aumentada y la tecnología inmersiva. Administrador de HomeLab AR desde 2024.</textarea>
                                <small class="form-text text-muted">Máximo 500 caracteres</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <h5 class="mb-4">Información de Contacto</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Principal</label>
                                <input type="email" class="form-control" value="juan.perez@example.com"
                                    placeholder="tu@email.com">
                                <small class="form-text text-muted">
                                    <i class="bx bx-check-circle text-success"></i>
                                    Verificado
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Alternativo</label>
                                <input type="email" class="form-control" placeholder="alternativo@email.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Teléfono</label>
                                <input type="tel" class="form-control" value="+52 55 1234 5678"
                                    placeholder="+52 55 1234 5678">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Teléfono Alternativo</label>
                                <input type="tel" class="form-control" placeholder="+52 55 8765 4321">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" class="form-control" placeholder="Calle, número, colonia">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Ciudad</label>
                                <input type="text" class="form-control" value="Ciudad de México"
                                    placeholder="Tu ciudad">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Estado/Provincia</label>
                                <input type="text" class="form-control" value="CDMX" placeholder="Tu estado">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Código Postal</label>
                                <input type="text" class="form-control" value="01000" placeholder="CP">
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-start" role="alert">
                                    <i class="bx bx-info-circle fs-5 me-3 mt-1"></i>
                                    <div>
                                        <strong>Privacidad:</strong> Tu información de contacto solo será visible para
                                        administradores del sistema y se usará únicamente para comunicaciones
                                        importantes.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="tab-pane fade" id="social" role="tabpanel">
                        <h5 class="mb-4">Redes Sociales</h5>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bxl-github text-dark me-2"></i>
                                    GitHub
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">github.com/</span>
                                    <input type="text" class="form-control" value="juanperez" placeholder="username">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bxl-linkedin text-primary me-2"></i>
                                    LinkedIn
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">linkedin.com/in/</span>
                                    <input type="text" class="form-control" value="juanperez" placeholder="username">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bxl-twitter text-info me-2"></i>
                                    Twitter / X
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" value="juanperez" placeholder="username">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bxl-discord text-primary me-2"></i>
                                    Discord
                                </label>
                                <input type="text" class="form-control" value="juanperez#1234"
                                    placeholder="username#0000">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-globe text-success me-2"></i>
                                    Sitio Web Personal
                                </label>
                                <input type="url" class="form-control" placeholder="https://tusitio.com">
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="showSocialPublic" checked>
                                    <label class="form-check-label" for="showSocialPublic">
                                        <span class="fw-semibold">Mostrar redes sociales en mi perfil público</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferencias -->
                    <div class="tab-pane fade" id="preferences" role="tabpanel">
                        <h5 class="mb-4">Preferencias del Perfil</h5>

                        <div class="row g-4">
                            <div class="col-12">
                                <h6 class="fw-semibold mb-3">Visibilidad del Perfil</h6>

                                <div class="form-check mb-3">
                                    <input class="form-check-radio" type="radio" name="profileVisibility"
                                        id="visibilityPublic" checked>
                                    <label class="form-check-label" for="visibilityPublic">
                                        <div class="fw-semibold">Público</div>
                                        <small class="text-muted">Cualquiera puede ver tu perfil</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-radio" type="radio" name="profileVisibility"
                                        id="visibilityMembers">
                                    <label class="form-check-label" for="visibilityMembers">
                                        <div class="fw-semibold">Solo Miembros</div>
                                        <small class="text-muted">Solo usuarios registrados pueden ver tu perfil</small>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-radio" type="radio" name="profileVisibility"
                                        id="visibilityPrivate">
                                    <label class="form-check-label" for="visibilityPrivate">
                                        <div class="fw-semibold">Privado</div>
                                        <small class="text-muted">Solo tú puedes ver tu perfil completo</small>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12">
                                <h6 class="fw-semibold mb-3">Privacidad</h6>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="showEmail">
                                    <label class="form-check-label" for="showEmail">
                                        <span class="fw-semibold">Mostrar mi email en mi perfil</span>
                                    </label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="showLastSeen" checked>
                                    <label class="form-check-label" for="showLastSeen">
                                        <span class="fw-semibold">Mostrar última conexión</span>
                                    </label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="allowMessages" checked>
                                    <label class="form-check-label" for="allowMessages">
                                        <span class="fw-semibold">Permitir que otros usuarios me envíen mensajes</span>
                                    </label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="searchable" checked>
                                    <label class="form-check-label" for="searchable">
                                        <span class="fw-semibold">Aparecer en resultados de búsqueda</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-12">
                                <h6 class="fw-semibold mb-3 text-danger">Zona de Peligro</h6>

                                <div class="card bg-danger bg-opacity-10 border-danger">
                                    <div class="card-body">
                                        <h6 class="text-danger">Eliminar Cuenta</h6>
                                        <p class="text-muted mb-3">Una vez que elimines tu cuenta, no hay vuelta atrás.
                                            Por favor, ten cuidado.</p>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteAccountModal">
                                            <i class="bx bx-trash me-2"></i>
                                            Eliminar mi cuenta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal: Eliminar Cuenta -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bx bx-error me-2"></i>
                    Eliminar Cuenta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    <strong>¡Advertencia!</strong> Esta acción es irreversible.
                </div>
                <p>Al eliminar tu cuenta:</p>
                <ul>
                    <li>Perderás acceso a todos tus datos</li>
                    <li>Toda tu información será eliminada permanentemente</li>
                    <li>No podrás recuperar tu cuenta más tarde</li>
                </ul>
                <p class="mb-3">Para confirmar, escribe <strong>ELIMINAR</strong> en el campo de abajo:</p>
                <input type="text" class="form-control" id="deleteConfirmation" placeholder="ELIMINAR">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete" disabled>
                    <i class="bx bx-trash me-1"></i>
                    Sí, eliminar mi cuenta
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';

        console.log('👤 Página: Perfil - Inicializando');

        // ===================================
        // GUARDAR PERFIL
        // ===================================
        document.getElementById('saveProfile')?.addEventListener('click', function () {
            console.log('💾 Guardando perfil...');

            this.disabled = true;
            this.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Guardando...';

            // Simulación de guardado
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = '<i class="bx bx-save me-1"></i>Guardar Cambios';

                if (typeof Notyf !== 'undefined') {
                    const notyf = new Notyf();
                    notyf.success('Perfil actualizado exitosamente');
                }
            }, 1500);
        });

        // ===================================
        // CONFIRMACIÓN PARA ELIMINAR CUENTA
        // ===================================
        const deleteInput = document.getElementById('deleteConfirmation');
        const deleteButton = document.getElementById('confirmDelete');

        if (deleteInput && deleteButton) {
            deleteInput.addEventListener('input', function () {
                deleteButton.disabled = this.value !== 'ELIMINAR';
            });

            deleteButton.addEventListener('click', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '¿Estás completamente seguro?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Aquí iría la lógica de eliminación
                            console.log('Cuenta eliminada');
                            window.location.href = '/';
                        }
                    });
                }
            });
        }

        // ===================================
        // CARGAR DATOS DEL PERFIL
        // ===================================
        function loadProfileData() {
            // Aquí se cargarían los datos desde el backend
            console.log('Cargando datos del perfil...');
        }

        // ===================================
        // INICIALIZACIÓN
        // ===================================
        document.addEventListener('DOMContentLoaded', function () {
            loadProfileData();
            console.log('✅ Perfil inicializado');
        });

    })();
</script>

<style>
    .avatar-xl {
        font-size: 80px;
    }

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

    .form-check-radio {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.125rem;
        cursor: pointer;
    }

    .form-check-label {
        cursor: pointer;
        padding-left: 0.5rem;
    }
</style>