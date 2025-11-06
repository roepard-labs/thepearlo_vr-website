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
                    <i class="bx bx-bar-chart text-primary me-2"></i>
                    Estadísticas
                </h6>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Último acceso</small>
                        <strong id="lastAccessTime">Cargando...</strong>
                    </div>
                    <i class="bx bx-time-five fs-4 text-primary"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Miembro desde</small>
                        <strong id="memberSince">Cargando...</strong>
                    </div>
                    <i class="bx bx-calendar fs-4 text-primary"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block">Sesiones activas</small>
                        <strong id="activeSessions">Cargando...</strong>
                    </div>
                    <i class="bx bx-devices fs-4 text-primary"></i>
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
                        <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions"
                            type="button" role="tab">
                            <i class="bx bx-shield-quarter me-2"></i>
                            Sesiones
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

                    <!-- Sesiones Activas -->
                    <div class="tab-pane fade" id="sessions" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Sesiones Activas</h5>
                            <button class="btn btn-warning btn-sm" id="closeAllSessionsBtn">
                                <i class="bx bx-exit me-1"></i>
                                Cerrar Todas
                            </button>
                        </div>

                        <div class="alert alert-info border-0 mb-4">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Seguridad:</strong> Verifica que reconozcas todos los dispositivos con sesión
                            activa.
                            Si detectas actividad sospechosa, cierra las sesiones inmediatamente.
                        </div>

                        <!-- Contenedor de sesiones -->
                        <div id="sessionsContainer">
                            <!-- Las sesiones se cargarán dinámicamente aquí -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando sesiones...</span>
                                </div>
                                <p class="text-muted mt-3">Cargando sesiones activas...</p>
                            </div>
                        </div>

                        <!-- Estadísticas de sesiones -->
                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <div class="card session-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="bx bx-time fs-2 text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <small class="text-muted d-block">Última Actividad</small>
                                                <strong id="lastActivityStat">Cargando...</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card session-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="bx bx-devices fs-2 text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <small class="text-muted d-block">Dispositivos Conectados</small>
                                                <strong id="devicesConnectedStat">Cargando...</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        // VARIABLES GLOBALES
        // ===================================
        let currentUserData = null;
        let activeSessions = [];

        // ===================================
        // CARGAR DATOS DEL USUARIO
        // ===================================
        async function loadUserData() {
            try {
                console.log('📊 Cargando datos del usuario...');

                // Verificar que AppRouter esté disponible
                if (!window.AppRouter || !window.AppRouter.isReady()) {
                    console.warn('⏳ AppRouter no está listo, esperando...');
                    await new Promise(resolve => setTimeout(resolve, 500));
                    return loadUserData(); // Reintentar
                }

                const response = await window.AppRouter.get('/routes/user/user_data.php');

                if (response.status === 'success') {
                    currentUserData = response.data;
                    updateProfileUI(currentUserData);
                    console.log('✅ Datos del usuario cargados:', currentUserData);
                } else {
                    throw new Error(response.message || 'Error al cargar datos');
                }
            } catch (error) {
                console.error('❌ Error al cargar datos del usuario:', error);

                const notyf = new Notyf({ duration: 4000 });
                notyf.error('No se pudieron cargar los datos del perfil');
            }
        }

        // ===================================
        // ACTUALIZAR UI CON DATOS DEL USUARIO
        // ===================================
        function updateProfileUI(userData) {
            // Nombre en header
            const displayName = document.getElementById('profileDisplayName');
            if (displayName) {
                displayName.textContent = userData.full_name || 'Usuario';
            }

            // Username
            const username = document.getElementById('profileUsername');
            if (username) {
                username.textContent = '@' + (userData.username || 'username');
            }

            // Badge de Rol (Administrador/Usuario)
            const roleBadge = document.getElementById('profileRole');
            if (roleBadge) {
                const isAdmin = userData.role_id === 2;
                roleBadge.textContent = isAdmin ? 'Administrador' : 'Usuario';
                roleBadge.className = isAdmin ? 'badge bg-primary' : 'badge bg-info';
            }

            // Badge de Estado (Activo/Inactivo/Suspendido/Baneado)
            const statusBadge = roleBadge?.nextElementSibling;
            if (statusBadge) {
                const statusMap = {
                    1: { text: 'Activo', class: 'badge bg-success' },
                    2: { text: 'Inactivo', class: 'badge bg-secondary' },
                    3: { text: 'Suspendido', class: 'badge bg-warning' },
                    4: { text: 'Baneado', class: 'badge bg-danger' }
                };

                const status = statusMap[userData.status_id] || statusMap[1];
                statusBadge.textContent = status.text;
                statusBadge.className = status.class;
            }

            // Último acceso (usar last_login del usuario)
            const lastAccess = document.getElementById('lastAccessTime');
            if (lastAccess && userData.last_login) {
                const lastLoginDate = new Date(userData.last_login);
                const now = new Date();
                const diffMinutes = Math.floor((now - lastLoginDate) / 60000);

                let timeText = '';
                if (diffMinutes < 1) {
                    timeText = 'Ahora mismo';
                } else if (diffMinutes < 60) {
                    timeText = `Hace ${diffMinutes} ${diffMinutes === 1 ? 'minuto' : 'minutos'}`;
                } else if (diffMinutes < 1440) {
                    const hours = Math.floor(diffMinutes / 60);
                    timeText = `Hace ${hours} ${hours === 1 ? 'hora' : 'horas'}`;
                } else {
                    const days = Math.floor(diffMinutes / 1440);
                    timeText = `Hace ${days} ${days === 1 ? 'día' : 'días'}`;
                }

                lastAccess.textContent = timeText;
            }

            // Miembro desde
            const memberSince = document.getElementById('memberSince');
            if (memberSince) {
                memberSince.textContent = userData.member_since || 'Reciente';
            }
        }

        // ===================================
        // CARGAR SESIONES ACTIVAS
        // ===================================
        async function loadActiveSessions() {
            try {
                console.log('🔐 Cargando sesiones activas...');

                // Verificar que AppRouter esté disponible
                if (!window.AppRouter || !window.AppRouter.isReady()) {
                    console.warn('⏳ AppRouter no está listo para sesiones, esperando...');
                    await new Promise(resolve => setTimeout(resolve, 500));
                    return loadActiveSessions(); // Reintentar
                }

                activeSessions = await window.SessionsService.getActiveSessions();

                // Actualizar contador en estadísticas
                const activeSessionsCount = document.getElementById('activeSessions');
                if (activeSessionsCount) {
                    const count = activeSessions.length;
                    activeSessionsCount.textContent = `${count} ${count === 1 ? 'dispositivo' : 'dispositivos'}`;
                }

                // Renderizar sesiones en el contenedor
                window.SessionsService.renderSessionCards(activeSessions, 'sessionsContainer');

                // Actualizar estadísticas de sesiones
                updateSessionStats(activeSessions);

                console.log('✅ Sesiones activas cargadas:', activeSessions.length);
            } catch (error) {
                console.error('❌ Error al cargar sesiones:', error);

                const container = document.getElementById('sessionsContainer');
                if (container) {
                    container.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bx bx-error-circle me-2"></i>
                            No se pudieron cargar las sesiones activas. Intenta nuevamente.
                        </div>
                    `;
                }
            }
        }

        // ===================================
        // ACTUALIZAR ESTADÍSTICAS DE SESIONES
        // ===================================
        function updateSessionStats(sessions) {
            // Última actividad
            const lastActivityStat = document.getElementById('lastActivityStat');
            if (lastActivityStat && sessions.length > 0) {
                const mostRecent = sessions.reduce((latest, session) => {
                    const sessionDate = new Date(session.last_activity);
                    const latestDate = new Date(latest.last_activity);
                    return sessionDate > latestDate ? session : latest;
                });

                const lastActivity = new Date(mostRecent.last_activity);
                const now = new Date();
                const diffMinutes = Math.floor((now - lastActivity) / 60000);

                let timeText = '';
                if (diffMinutes < 1) {
                    timeText = 'Ahora mismo';
                } else if (diffMinutes < 60) {
                    timeText = `Hace ${diffMinutes} min`;
                } else {
                    const hours = Math.floor(diffMinutes / 60);
                    timeText = `Hace ${hours} h`;
                }

                lastActivityStat.textContent = timeText;
            }

            // Dispositivos conectados
            const devicesConnected = document.getElementById('devicesConnectedStat');
            if (devicesConnected) {
                const count = sessions.length;
                devicesConnected.textContent = `${count} ${count === 1 ? 'dispositivo' : 'dispositivos'}`;
            }
        }

        // ===================================
        // CERRAR TODAS LAS SESIONES
        // ===================================
        const closeAllBtn = document.getElementById('closeAllSessionsBtn');
        if (closeAllBtn) {
            closeAllBtn.addEventListener('click', async function () {
                await window.SessionsService.confirmCloseAllSessions(async () => {
                    // Recargar sesiones después de cerrar
                    await loadActiveSessions();
                });
            });
        }

        // ===================================
        // EVENTOS DE SESIONES
        // ===================================
        function initSessionEvents() {
            window.SessionsService.initSessionEvents('sessionsContainer', async () => {
                // Recargar sesiones después de cerrar una
                await loadActiveSessions();
            });
        }

        // ===================================
        // GUARDAR PERFIL
        // ===================================
        document.getElementById('saveProfile')?.addEventListener('click', function () {
            console.log('💾 Guardando perfil...');

            this.disabled = true;
            this.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Guardando...';

            // Simulación de guardado (implementar lógica real)
            setTimeout(() => {
                const notyf = new Notyf({ duration: 3000 });
                notyf.success('Perfil actualizado exitosamente');

                this.disabled = false;
                this.innerHTML = '<i class="bx bx-save me-1"></i>Guardar Cambios';
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
                console.log('🗑️ Eliminar cuenta solicitado');
                // Implementar lógica de eliminación
            });
        }

        // ===================================
        // TAB CHANGE EVENT - Cargar sesiones al abrir tab
        // ===================================
        const sessionsTab = document.getElementById('sessions-tab');
        if (sessionsTab) {
            sessionsTab.addEventListener('shown.bs.tab', function () {
                console.log('📑 Tab de sesiones activado');
                loadActiveSessions();
                initSessionEvents();
            });
        }

        // ===================================
        // ESPERAR A QUE APPROUTER ESTÉ LISTO
        // ===================================
        async function waitForAppRouter() {
            let attempts = 0;
            const maxAttempts = 20; // 10 segundos máximo

            while (attempts < maxAttempts) {
                if (window.AppRouter && typeof window.AppRouter.isReady === 'function' && window.AppRouter.isReady()) {
                    console.log('✅ AppRouter está listo para usar');
                    return true;
                }

                console.log(`⏳ Esperando a AppRouter... Intento ${attempts + 1}/${maxAttempts}`);
                await new Promise(resolve => setTimeout(resolve, 500));
                attempts++;
            }

            console.error('❌ Timeout esperando a AppRouter');
            return false;
        }

        // ===================================
        // INICIALIZACIÓN
        // ===================================
        async function init() {
            console.log('🚀 Inicializando perfil...');

            // Esperar a que AppRouter esté disponible
            const isReady = await waitForAppRouter();

            if (!isReady) {
                console.error('❌ No se pudo inicializar el perfil: AppRouter no disponible');
                const notyf = new Notyf({ duration: 5000 });
                notyf.error('Error al cargar el perfil. Por favor, recarga la página.');
                return;
            }

            // Cargar datos del usuario
            await loadUserData();

            // Cargar sesiones activas inicialmente
            await loadActiveSessions();
            initSessionEvents();

            console.log('✅ Perfil inicializado completamente');
        }

        // Ejecutar inicialización cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

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

    /* ===================================
       ESTILOS PARA ESTADÍSTICAS DE SESIONES
       =================================== */

    /* Modo Claro (por defecto) */
    [data-bs-theme="light"] .session-stat-card {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
    }

    [data-bs-theme="light"] .session-stat-card .card-body {
        color: #212529;
    }

    [data-bs-theme="light"] .session-stat-card .text-muted {
        color: #6c757d !important;
    }

    /* Modo Oscuro */
    [data-bs-theme="dark"] .session-stat-card {
        background-color: #2d3748 !important;
        border: 1px solid #4a5568 !important;
    }

    [data-bs-theme="dark"] .session-stat-card .card-body {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .session-stat-card .text-muted {
        color: #a0aec0 !important;
    }

    /* Transición suave entre temas */
    .session-stat-card {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }
</style>