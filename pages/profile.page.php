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

<!-- ===================================== -->
<!-- CARGAR DEPENDENCIAS DE FILEPOND -->
<!-- ===================================== -->

<!-- FilePond CSS -->
<link href="/node_modules/filepond/dist/filepond.min.css" rel="stylesheet">
<link href="/node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">

<!-- FilePond JS Core -->
<script src="/node_modules/filepond/dist/filepond.min.js"></script>

<!-- FilePond Plugins -->
<script src="/node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="/node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
<script src="/node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="/node_modules/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js"></script>
<script src="/node_modules/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js"></script>
<script src="/node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js"></script>
<script src="/node_modules/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js">
</script>

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
                    <!-- Avatar con imagen de perfil -->
                    <div id="profileAvatarContainer"
                        class="avatar-xl bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden"
                        style="width: 120px; height: 120px;">
                        <img id="profileAvatarImg" src="/assets/img/default-avatar.png" alt="Foto de perfil"
                            class="w-100 h-100 object-fit-cover" style="display: block;">
                        <i id="profileAvatarIcon" class="bx bx-user text-white"
                            style="font-size: 60px; display: none;"></i>
                    </div>
                    <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0"
                        title="Cambiar foto" style="width: 35px; height: 35px;" data-bs-toggle="modal"
                        data-bs-target="#uploadProfilePictureModal">
                        <i class="bx bx-camera"></i>
                    </button>
                </div>
                <h4 class="mb-1" id="profileDisplayName">Cargando...</h4>
                <p class="text-muted mb-3" id="profileUsername">@usuario</p>
                <div class="d-flex gap-2 justify-content-center">
                    <span class="badge bg-primary" id="profileRole">Usuario</span>
                    <span class="badge bg-success">Activo</span>
                </div>
                <!-- Botón para eliminar foto -->
                <button class="btn btn-outline-danger btn-sm mt-2 d-none" id="deleteProfilePictureBtn">
                    <i class="bx bx-trash me-1"></i>
                    Eliminar foto
                </button>
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
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                            type="button" role="tab">
                            <i class="bx bx-share-alt me-2"></i>
                            Social
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <!-- Contenido de los Tabs -->
                <div class="tab-content p-4" id="profileTabsContent">

                    <!-- Tab: Personal -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <h5 class="mb-4">
                            <i class="bx bx-user-circle me-2 text-primary"></i>
                            Información Personal
                        </h5>

                        <form id="personalForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">Nombre <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="firstName" name="first_name"
                                        placeholder="Tu nombre" required minlength="2" maxlength="50">
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Apellido <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastName" name="last_name"
                                        placeholder="Tu apellido" required minlength="2" maxlength="50">
                                </div>
                                <div class="col-12">
                                    <label for="bio" class="form-label">
                                        Biografía
                                        <small class="text-muted">(<span id="bioCounter">0</span>/255
                                            caracteres)</small>
                                    </label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3" maxlength="255"
                                        placeholder="Escribe una breve descripción sobre ti"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Género <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="gender" name="gender_id" required>
                                        <option value="1">Prefiero no decirlo</option>
                                        <option value="2">Masculino</option>
                                        <option value="3">Femenino</option>
                                        <option value="4">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate"
                                        max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="country" class="form-label">País</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        placeholder="Tu país" maxlength="100">
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="Tu ciudad" maxlength="100">
                                </div>
                            </div>
                        </form>
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
                        <h5 class="mb-4">
                            <i class="bx bx-envelope me-2 text-primary"></i>
                            Información de Contacto
                        </h5>

                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="tu@email.com" readonly disabled>
                                    <small class="text-muted">No puedes cambiar tu email desde aquí</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="Tu número de teléfono" maxlength="20">
                                </div>
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="tu_usuario" readonly disabled>
                                    <small class="text-muted">No puedes cambiar tu username</small>
                                </div>
                            </div>
                        </form>
                    </div> <!-- Redes Sociales -->
                    <div class="tab-pane fade" id="social" role="tabpanel">
                        <h5 class="mb-4">
                            <i class="bx bx-share-alt me-2 text-primary"></i>
                            Redes Sociales
                        </h5>

                        <form id="socialForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="github" class="form-label">
                                        <i class="bx bxl-github me-1"></i> GitHub
                                    </label>
                                    <input type="text" class="form-control" id="github" name="github_username"
                                        placeholder="Tu usuario de GitHub" maxlength="39">
                                </div>
                                <div class="col-md-6">
                                    <label for="linkedin" class="form-label">
                                        <i class="bx bxl-linkedin me-1"></i> LinkedIn
                                    </label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin_username"
                                        placeholder="Tu usuario de LinkedIn" maxlength="100">
                                </div>
                                <div class="col-md-6">
                                    <label for="twitter" class="form-label">
                                        <i class="bx bxl-twitter me-1"></i> Twitter/X
                                    </label>
                                    <input type="text" class="form-control" id="twitter" name="twitter_username"
                                        placeholder="Tu usuario de Twitter/X" maxlength="15">
                                </div>
                                <div class="col-md-6">
                                    <label for="discord" class="form-label">
                                        <i class="bx bxl-discord me-1"></i> Discord
                                    </label>
                                    <input type="text" class="form-control" id="discord" name="discord_tag"
                                        placeholder="usuario#1234" maxlength="37">
                                </div>
                                <div class="col-12">
                                    <label for="website" class="form-label">
                                        <i class="bx bx-globe me-1"></i> Sitio Web Personal
                                    </label>
                                    <input type="url" class="form-control" id="website" name="personal_website"
                                        placeholder="https://tusitio.com" maxlength="255">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="showSocialPublic"
                                            name="show_social_public">
                                        <label class="form-check-label" for="showSocialPublic">
                                            Mostrar mis redes sociales públicamente
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal: Subir Foto de Perfil -->
<div class="modal fade" id="uploadProfilePictureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-image-add me-2 text-primary"></i>
                    Cambiar Foto de Perfil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-0 mb-3">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>Requisitos:</strong> Máximo 5MB. Formatos: JPG, PNG, GIF, WEBP.
                </div>

                <!-- FilePond Container -->
                <input type="file" id="profilePictureFilePond" name="profile_picture" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="uploadProfilePictureBtn" disabled>
                    <i class="bx bx-upload me-1"></i>
                    Subir Foto
                </button>
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
(function() {
    'use strict';

    console.log('👤 Página: Perfil - Inicializando');

    // ===================================
    // VARIABLES GLOBALES
    // ===================================
    let currentUserData = null;
    let activeSessions = [];

    // Instancia de Notyf (se inicializa de forma lazy)
    let notyfInstance = null;

    // Instancia de FilePond para foto de perfil
    let profilePicturePond = null;

    /**
     * Obtener instancia de Notyf (inicialización lazy)
     * Espera a que Notyf esté disponible antes de crear la instancia
     */
    function getNotyf() {
        if (!notyfInstance && typeof Notyf !== 'undefined') {
            notyfInstance = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top'
                },
                ripple: true,
                dismissible: true
            });
            console.log('✅ Notyf inicializado correctamente (lazy)');
        }

        // Si aún no está disponible, usar fallback
        if (!notyfInstance) {
            console.warn('⚠️ Notyf aún no disponible, usando fallback alert');
            return {
                success: (msg) => alert('✅ ' + (typeof msg === 'string' ? msg : msg.message)),
                error: (msg) => alert('❌ ' + (typeof msg === 'string' ? msg : msg.message))
            };
        }

        return notyfInstance;
    }

    // ===================================
    // CARGAR DATOS DEL USUARIO
    // ===================================
    async function loadUserData() {
        try {
            console.log('� Cargando datos completos del perfil...');

            // Obtener perfil completo con bio, género y redes sociales
            const response = await window.AppRouter.get('/routes/profile/det_user.php');

            if (response && response.status === 'success') {
                console.log('✅ Perfil completo cargado:', response.data);
                currentUserData = response.data;

                // Actualizar UI con los datos
                updateProfileUI(currentUserData);

                // Llenar formularios con datos del backend
                fillFormData(currentUserData);
            } else {
                throw new Error(response?.message || 'Error al cargar perfil');
            }
        } catch (error) {
            console.error('❌ Error al cargar perfil:', error);
            getNotyf().error('Error al cargar información del perfil');
        }
    }

    // ===================================
    // LLENAR FORMULARIOS CON DATOS
    // ===================================
    function fillFormData(userData) {
        console.log('📝 Llenando formularios con datos del usuario');

        // Tab Personal
        document.getElementById('firstName').value = userData.first_name || '';
        document.getElementById('lastName').value = userData.last_name || '';
        document.getElementById('bio').value = userData.bio || '';
        updateBioCounter(); // Actualizar contador
        document.getElementById('gender').value = userData.gender_id || 1;
        document.getElementById('birthdate').value = userData.birthdate || '';
        document.getElementById('country').value = userData.country || '';
        document.getElementById('city').value = userData.city || '';

        // Tab Contacto
        document.getElementById('email').value = userData.email || '';
        document.getElementById('phone').value = userData.phone || '';
        document.getElementById('username').value = userData.username || '';

        // Tab Social
        if (userData.social) {
            document.getElementById('github').value = userData.social.github_username || '';
            document.getElementById('linkedin').value = userData.social.linkedin_username || '';
            document.getElementById('twitter').value = userData.social.twitter_username || '';
            document.getElementById('discord').value = userData.social.discord_tag || '';
            document.getElementById('website').value = userData.social.personal_website || '';
            document.getElementById('showSocialPublic').checked = userData.social.show_social_public || false;
        }

        console.log('✅ Formularios llenados correctamente');
    }

    // ===================================
    // CONTADOR DE CARACTERES PARA BIO
    // ===================================
    function updateBioCounter() {
        const bioInput = document.getElementById('bio');
        const bioCounter = document.getElementById('bioCounter');
        if (bioInput && bioCounter) {
            bioCounter.textContent = bioInput.value.length;
        }
    }

    // Event listener para bio
    const bioInput = document.getElementById('bio');
    if (bioInput) {
        bioInput.addEventListener('input', updateBioCounter);
    } // ===================================
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

        // Foto de perfil
        updateProfilePicture(userData.profile_picture);

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
                1: {
                    text: 'Activo',
                    class: 'badge bg-success'
                },
                2: {
                    text: 'Inactivo',
                    class: 'badge bg-secondary'
                },
                3: {
                    text: 'Suspendido',
                    class: 'badge bg-warning'
                },
                4: {
                    text: 'Baneado',
                    class: 'badge bg-danger'
                }
            };

            const status = statusMap[userData.status_id] || statusMap[1];
            statusBadge.textContent = status.text;
            statusBadge.className = status.class;
        }

        // Último acceso (usar last_login del usuario)
        const lastAccess = document.getElementById('lastAccessTime');
        if (lastAccess) {
            if (userData.last_login) {
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
                console.log(`🕒 Último acceso actualizado: ${timeText} (${userData.last_login})`);
            } else {
                lastAccess.textContent = 'No disponible';
                console.warn('⚠️ last_login no está disponible en userData');
            }
        } else {
            console.error('❌ Elemento lastAccessTime no encontrado');
        }

        // Miembro desde
        const memberSince = document.getElementById('memberSince');
        if (memberSince) {
            memberSince.textContent = userData.member_since || 'Reciente';
            console.log(`📅 Miembro desde actualizado: ${userData.member_since || 'Reciente'}`);
        }

        // Sesiones activas (actualizar contador)
        const activeSessions = document.getElementById('activeSessions');
        if (activeSessions && userData.active_sessions_count !== undefined) {
            const count = userData.active_sessions_count;
            activeSessions.textContent = `${count} ${count === 1 ? 'dispositivo' : 'dispositivos'}`;
            console.log(`📱 Sesiones activas actualizadas: ${count}`);
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
        closeAllBtn.addEventListener('click', async function() {
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
    document.getElementById('saveProfile')?.addEventListener('click', async function() {
        console.log('💾 Guardando perfil...');

        const saveBtn = this;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Guardando...';

        try {
            // ===================================
            // VALIDAR CAMPOS REQUERIDOS
            // ===================================

            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const bio = document.getElementById('bio').value.trim();
            const genderIdValue = document.getElementById('gender').value;

            // Validar campos obligatorios
            if (!firstName || firstName.length === 0) {
                throw new Error('El nombre es requerido');
            }

            if (!lastName || lastName.length === 0) {
                throw new Error('El apellido es requerido');
            }

            // Validar longitud de biografía
            if (bio && bio.length > 255) {
                throw new Error(`La biografía no puede exceder 255 caracteres (actual: ${bio.length})`);
            }

            // Validar gender_id
            const genderId = parseInt(genderIdValue);
            if (isNaN(genderId) || genderId < 1 || genderId > 4) {
                throw new Error('Debe seleccionar un género válido');
            }

            // Validar fecha de nacimiento (si se proporciona)
            const birthdate = document.getElementById('birthdate').value;
            if (birthdate) {
                const birthdateObj = new Date(birthdate);
                const today = new Date();
                if (birthdateObj > today) {
                    throw new Error('La fecha de nacimiento no puede ser futura');
                }

                // Validar edad mínima (13 años)
                const age = today.getFullYear() - birthdateObj.getFullYear();
                if (age < 13) {
                    throw new Error('Debes tener al menos 13 años para usar este servicio');
                }
            }

            // Validar personal website (si se proporciona)
            const personalWebsite = document.getElementById('website').value.trim();
            if (personalWebsite) {
                try {
                    new URL(personalWebsite);
                    if (!personalWebsite.startsWith('http://') && !personalWebsite.startsWith(
                            'https://')) {
                        throw new Error('');
                    }
                } catch (e) {
                    throw new Error(
                        'La URL del sitio web personal debe ser válida (debe comenzar con http:// o https://)'
                    );
                }
            }

            // ===================================
            // RECOPILAR DATOS VALIDADOS
            // ===================================

            const profileData = {
                // Datos personales (validados)
                first_name: firstName,
                last_name: lastName,
                bio: bio,
                gender_id: genderId,
                birthdate: birthdate,
                country: document.getElementById('country').value.trim(),
                city: document.getElementById('city').value.trim(),

                // Contacto
                phone: document.getElementById('phone').value.trim(),

                // Redes sociales
                social: {
                    github_username: document.getElementById('github').value.trim(),
                    linkedin_username: document.getElementById('linkedin').value.trim(),
                    twitter_username: document.getElementById('twitter').value.trim(),
                    discord_tag: document.getElementById('discord').value.trim(),
                    personal_website: personalWebsite,
                    show_social_public: document.getElementById('showSocialPublic').checked
                }
            };

            console.log('📤 Enviando datos al backend:', profileData);

            // Enviar al backend
            const response = await window.AppRouter.put('/routes/profile/up_user.php', profileData);

            if (response && response.status === 'success') {
                console.log('✅ Perfil actualizado:', response.data);

                getNotyf().success({
                    message: `Perfil actualizado correctamente. ${response.data.total_updates} campo(s) modificado(s).`,
                    duration: 5000
                });

                // Recargar datos del perfil
                await loadUserData();

                // Actualizar header si cambió el nombre
                if (response.data.updated_fields.includes('first_name') ||
                    response.data.updated_fields.includes('last_name')) {
                    console.log('🔄 Nombre actualizado, recargando header...');
                    // El header se actualizará con los nuevos datos en loadUserData()
                }
            } else {
                throw new Error(response?.message || 'Error al actualizar perfil');
            }

        } catch (error) {
            console.error('❌ Error al guardar perfil:', error);

            let errorMessage = 'Error al guardar los cambios';

            // Verificar si es un error de validación
            if (error.message) {
                errorMessage = error.message;
            }
            // Verificar si es un error del backend
            else if (error.response && error.response.data && error.response.data.message) {
                errorMessage = error.response.data.message;

                // Agregar detalles si existen
                if (error.response.data.details) {
                    console.error('Detalles del error:', error.response.data.details);
                }
            }
            // Verificar si Axios tiene el error en otra estructura
            else if (error.data && error.data.message) {
                errorMessage = error.data.message;
            }

            getNotyf().error({
                message: errorMessage,
                duration: 5000
            });
        } finally {
            // Restaurar botón
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="bx bx-save me-1"></i>Guardar Cambios';
        }
    }); // ===================================
    // CONFIRMACIÓN PARA ELIMINAR CUENTA
    // ===================================
    const deleteInput = document.getElementById('deleteConfirmation');
    const deleteButton = document.getElementById('confirmDelete');

    if (deleteInput && deleteButton) {
        deleteInput.addEventListener('input', function() {
            deleteButton.disabled = this.value !== 'ELIMINAR';
        });

        deleteButton.addEventListener('click', function() {
            console.log('🗑️ Eliminar cuenta solicitado');
            // Implementar lógica de eliminación
        });
    }

    // ===================================
    // TAB CHANGE EVENT - Cargar sesiones al abrir tab
    // ===================================
    const sessionsTab = document.getElementById('sessions-tab');
    if (sessionsTab) {
        sessionsTab.addEventListener('shown.bs.tab', function() {
            console.log('📑 Tab de sesiones activado');
            loadActiveSessions();
            initSessionEvents();
        });
    }

    // ===================================
    // ACTUALIZAR FOTO DE PERFIL EN UI
    // ===================================
    function updateProfilePicture(profilePicture) {
        const avatarImg = document.getElementById('profileAvatarImg');
        const avatarIcon = document.getElementById('profileAvatarIcon');
        const deleteBtn = document.getElementById('deleteProfilePictureBtn');

        console.log('📷 updateProfilePicture llamado con:', profilePicture);

        // Normalizar rutas incorrectas del backend (defensivo)
        if (profilePicture && !profilePicture.startsWith('/')) {
            // Si es solo el nombre del archivo sin ruta, agregar ruta correcta
            if (profilePicture === 'default-avatar.png' || profilePicture === 'default-profile.png') {
                profilePicture = '/assets/img/default-avatar.png';
                console.log('🔧 Ruta normalizada a:', profilePicture);
            }
        }

        // Si no hay foto o es null/undefined
        if (!profilePicture) {
            console.log('⚠️ Sin foto de perfil, mostrando icono por defecto');
            avatarImg.style.display = 'none';
            avatarIcon.style.display = 'block';
            deleteBtn?.classList.add('d-none');
            return;
        }

        // Construir URL completa según el tipo de imagen
        let imageUrl;

        if (profilePicture === '/assets/img/default-avatar.png') {
            // Foto por defecto: Cargar desde frontend
            imageUrl = profilePicture;
            console.log('🖼️ Cargando imagen por defecto:', imageUrl);
            deleteBtn?.classList.add('d-none'); // No mostrar botón eliminar para default
        } else if (profilePicture.startsWith('/uploads/')) {
            // Foto personalizada: Cargar desde BACKEND
            const backendUrl = window.ENV_CONFIG?.API_URL || 'http://localhost:3000';
            imageUrl = backendUrl + profilePicture; 
            console.log('📸 Cargando foto personalizada desde backend:', imageUrl);
            deleteBtn?.classList.remove('d-none'); // Mostrar botón eliminar
        } else {
            // Ruta relativa o desconocida
            imageUrl = profilePicture;
            console.log('⚠️ Ruta desconocida, usando tal cual:', imageUrl);
            deleteBtn?.classList.add('d-none');
        }

        // Actualizar imagen
        avatarImg.src = imageUrl;
        avatarImg.style.display = 'block';
        avatarIcon.style.display = 'none';
    }

    // ===================================
    // INICIALIZAR FILEPOND
    // ===================================
    function initFilePond() {
        if (typeof FilePond === 'undefined') {
            console.error('❌ FilePond no está cargado');
            return;
        }

        // Registrar plugins
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageExifOrientation
        );

        // Crear instancia de FilePond
        const inputElement = document.getElementById('profilePictureFilePond');
        if (!inputElement) {
            console.error('❌ Input de FilePond no encontrado');
            return;
        }

        profilePicturePond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
            maxFileSize: '5MB',
            maxFiles: 1,
            allowMultiple: false,
            credits: false,
            labelIdle: 'Arrastra tu foto de perfil aquí o <span class="filepond--label-action">Examinar</span>',
            labelInvalidField: 'Archivo inválido',
            labelFileWaitingForSize: 'Calculando tamaño',
            labelFileSizeNotAvailable: 'Tamaño no disponible',
            labelFileLoading: 'Cargando',
            labelFileLoadError: 'Error al cargar',
            labelFileProcessing: 'Subiendo',
            labelFileProcessingComplete: 'Subida completa',
            labelFileProcessingAborted: 'Subida cancelada',
            labelFileProcessingError: 'Error al subir',
            labelFileProcessingRevertError: 'Error al revertir',
            labelFileRemoveError: 'Error al eliminar',
            labelTapToCancel: 'toca para cancelar',
            labelTapToRetry: 'toca para reintentar',
            labelTapToUndo: 'toca para deshacer',
            labelButtonRemoveItem: 'Eliminar',
            labelButtonAbortItemLoad: 'Abortar',
            labelButtonRetryItemLoad: 'Reintentar',
            labelButtonAbortItemProcessing: 'Cancelar',
            labelButtonUndoItemProcessing: 'Deshacer',
            labelButtonRetryItemProcessing: 'Reintentar',
            labelButtonProcessItem: 'Subir',
            labelMaxFileSizeExceeded: 'Archivo muy grande',
            labelMaxFileSize: 'Tamaño máximo: {filesize}',
            labelMaxTotalFileSizeExceeded: 'Tamaño total excedido',
            labelMaxTotalFileSize: 'Tamaño total máximo: {filesize}',
            labelFileTypeNotAllowed: 'Tipo de archivo no permitido',
            fileValidateTypeLabelExpectedTypes: 'Permitidos: {allButLastType} o {lastType}',
            imagePreviewHeight: 150,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 400,
            imageResizeTargetHeight: 400,
            imageResizeMode: 'cover',
            imageTransformOutputQuality: 90,
            stylePanelLayout: 'compact',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom'
        });

        // Event listeners
        profilePicturePond.on('addfile', (error, file) => {
            if (!error) {
                console.log('📷 Imagen agregada:', file.filename);
                document.getElementById('uploadProfilePictureBtn').disabled = false;
            }
        });

        profilePicturePond.on('removefile', () => {
            console.log('🗑️ Imagen removida');
            document.getElementById('uploadProfilePictureBtn').disabled = true;
        });

        console.log('✅ FilePond inicializado para foto de perfil');
    }

    // ===================================
    // SUBIR FOTO DE PERFIL
    // ===================================
    async function uploadProfilePicture() {
        const uploadBtn = document.getElementById('uploadProfilePictureBtn');
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i>Subiendo...';

        try {
            const files = profilePicturePond.getFiles();
            if (files.length === 0) {
                throw new Error('No hay ninguna imagen seleccionada');
            }

            const file = files[0].file;

            // Crear FormData
            const formData = new FormData();
            formData.append('profile_picture', file);

            console.log('📤 Subiendo foto de perfil:', file.name);

            // Subir con AppRouter
            const response = await window.AppRouter.upload('/routes/profile/upload_picture.php', formData);

            if (response && response.status === 'success') {
                console.log('✅ Foto de perfil actualizada:', response.data);

                getNotyf().success('Foto de perfil actualizada exitosamente');

                // Actualizar UI
                updateProfilePicture(response.data.profile_picture);

                // Limpiar FilePond
                profilePicturePond.removeFiles();

                // Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('uploadProfilePictureModal'));
                modal?.hide();

                // Recargar datos completos del perfil
                await loadUserData();
            } else {
                throw new Error(response?.message || 'Error al subir foto de perfil');
            }

        } catch (error) {
            console.error('❌ Error al subir foto de perfil:', error);
            getNotyf().error(error.message || 'Error al subir la foto de perfil');
        } finally {
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bx bx-upload me-1"></i>Subir Foto';
        }
    }

    // ===================================
    // ELIMINAR FOTO DE PERFIL
    // ===================================
    async function deleteProfilePicture() {
        const result = await Swal.fire({
            title: '¿Eliminar foto de perfil?',
            text: 'Tu foto de perfil será reemplazada por la imagen por defecto',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (!result.isConfirmed) return;

        try {
            console.log('🗑️ Eliminando foto de perfil...');

            const response = await window.AppRouter.delete('/routes/profile/delete_picture.php');

            if (response && response.status === 'success') {
                console.log('✅ Foto de perfil eliminada');

                getNotyf().success('Foto de perfil eliminada exitosamente');

                // Actualizar UI
                updateProfilePicture(response.data.profile_picture);

                // Recargar datos completos del perfil
                await loadUserData();
            } else {
                throw new Error(response?.message || 'Error al eliminar foto de perfil');
            }

        } catch (error) {
            console.error('❌ Error al eliminar foto de perfil:', error);
            getNotyf().error(error.message || 'Error al eliminar la foto de perfil');
        }
    }

    // ===================================
    // EVENT LISTENERS - FOTO DE PERFIL
    // ===================================
    document.getElementById('uploadProfilePictureBtn')?.addEventListener('click', uploadProfilePicture);
    document.getElementById('deleteProfilePictureBtn')?.addEventListener('click', deleteProfilePicture);

    // Inicializar FilePond cuando se abre el modal
    document.getElementById('uploadProfilePictureModal')?.addEventListener('shown.bs.modal', function() {
        if (!profilePicturePond) {
            initFilePond();
        }
    });

    // ===================================
    // ESPERAR A QUE APPROUTER ESTÉ LISTO
    // ===================================
    async function waitForAppRouter() {
        let attempts = 0;
        const maxAttempts = 20; // 10 segundos máximo

        while (attempts < maxAttempts) {
            if (window.AppRouter && typeof window.AppRouter.isReady === 'function' && window.AppRouter
                .isReady()) {
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
            getNotyf().error('Error al cargar el perfil. Por favor, recarga la página.');
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

/* ===================================
       ESTILOS PARA FOTO DE PERFIL
       =================================== */

#profileAvatarContainer {
    position: relative;
    border: 3px solid rgba(var(--bs-primary-rgb), 0.2);
}

#profileAvatarImg {
    object-fit: cover;
    object-position: center;
}

#profileAvatarContainer:hover {
    border-color: var(--bs-primary);
    transform: scale(1.05);
    transition: all 0.3s ease;
}

/* FilePond customization para perfil */
#uploadProfilePictureModal .filepond--root {
    margin-bottom: 0;
}

#uploadProfilePictureModal .filepond--drop-label {
    min-height: 200px;
}
</style>