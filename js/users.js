/**
 * Gestión de Usuarios - CRUD Completo
 * HomeLab AR - Roepard Labs
 * 
 * Rutas Backend:
 * - GET  /routes/admin/list_users.php - Listar usuarios
 * - POST /routes/admin/det_user.php - Detalles de usuario
 * - PUT  /routes/admin/up_user.php - Actualizar usuario
 */

(function () {
    'use strict';

    console.log('👥 Módulo: Gestión de Usuarios - Inicializando');

    // ===================================
    // VARIABLES GLOBALES
    // ===================================
    let usersDataTable = null;
    let currentUserData = null;
    let notyf = null; // Se inicializa después de verificar dependencias

    // ===================================
    // VERIFICAR DEPENDENCIAS
    // ===================================
    function checkDependencies() {
        // Verificar AppRouter (Axios wrapper)
        if (typeof window.AppRouter === 'undefined') {
            console.error('❌ AppRouter no está disponible');
            return false;
        }

        // Verificar jQuery
        if (typeof $ === 'undefined') {
            console.error('❌ jQuery no está disponible');
            return false;
        }

        // Verificar DataTables
        if (typeof $.fn.dataTable === 'undefined') {
            console.error('❌ DataTables no está disponible');
            return false;
        }

        // Verificar SweetAlert2
        if (typeof Swal === 'undefined') {
            console.error('❌ SweetAlert2 no está disponible');
            return false;
        }

        // Verificar Notyf
        if (typeof Notyf === 'undefined') {
            console.error('❌ Notyf no está disponible');
            return false;
        }

        console.log('✅ Todas las dependencias cargadas correctamente');
        return true;
    }

    // ===================================
    // INICIALIZAR NOTYF
    // ===================================
    function initializeNotyf() {
        if (!notyf && typeof Notyf !== 'undefined') {
            notyf = new Notyf({
                duration: 4000,
                position: { x: 'right', y: 'top' },
                dismissible: true
            });
            console.log('✅ Notyf inicializado correctamente');
        }
    }

    // ===================================
    // MOSTRAR NOTIFICACIÓN (SAFE)
    // ===================================
    function showNotification(type, message) {
        if (notyf) {
            notyf[type](message);
        } else {
            console.warn(`⚠️ Notyf no disponible: [${type}] ${message}`);
        }
    }

    // ===================================
    // HELPERS PARA BADGES DE ROL Y ESTADO
    // ===================================
    function getRoleBadgeClass(roleId) {
        const classes = {
            1: 'bg-info',        // user - azul claro
            2: 'bg-primary',     // admin - azul
            3: 'bg-warning'      // supervisor - amarillo
        };
        return classes[roleId] || 'bg-secondary';
    }

    function getStatusBadgeClass(statusId) {
        const classes = {
            1: 'bg-success',     // active - verde
            2: 'bg-secondary'    // inactive - gris
        };
        return classes[statusId] || 'bg-secondary';
    }

    // ===================================
    // CARGAR ESTADÍSTICAS
    // ===================================
    // CARGAR DATOS DE USUARIOS Y ESTADÍSTICAS
    // ===================================
    async function loadUserStats(retryCount = 0) {
        const MAX_RETRIES = 10;

        try {
            console.log('📊 Cargando estadísticas de usuarios...');

            // Verificar que AppRouter y Axios estén listos
            if (!window.AppRouter || !window.AppRouter.axiosInstance) {
                if (retryCount < MAX_RETRIES) {
                    console.log(`⏳ Esperando a que Axios se inicialice... (${retryCount + 1}/${MAX_RETRIES})`);
                    // Esperar 500ms y reintentar
                    await new Promise(resolve => setTimeout(resolve, 500));
                    return await loadUserStats(retryCount + 1);
                } else {
                    throw new Error('Timeout esperando inicialización de Axios');
                }
            }

            const response = await window.AppRouter.get('/routes/admin/list_users.php');

            if (response.success && response.data) {
                const users = response.data;

                // Calcular estadísticas (solo 2 estados: activo=1, inactivo=2)
                const stats = {
                    total: users.length,
                    active: users.filter(u => u.status_id === 1).length,
                    inactive: users.filter(u => u.status_id === 2).length,
                    // Calcular "pendientes" como usuarios sin última conexión o recién registrados
                    pending: users.filter(u => {
                        // Si no tiene last_access o fue registrado hace menos de 7 días y no ha iniciado sesión
                        if (!u.last_access) return true;
                        const lastAccess = new Date(u.last_access);
                        const registered = new Date(u.registered_at);
                        const daysSinceRegistration = (Date.now() - registered.getTime()) / (1000 * 60 * 60 * 24);
                        return daysSinceRegistration <= 7 && lastAccess.getTime() === registered.getTime();
                    }).length
                };

                // Actualizar UI con animación
                updateStatCounter('totalUsers', stats.total);
                updateStatCounter('activeUsers', stats.active);
                updateStatCounter('pendingUsers', stats.pending);
                updateStatCounter('inactiveUsers', stats.inactive);

                console.log('✅ Estadísticas cargadas:', stats);

                // Retornar los datos para que initDataTable los use
                return users;
            } else {
                console.error('❌ Respuesta del backend inválida:', response);
                throw new Error('Los datos recibidos no tienen el formato esperado');
            }
        } catch (error) {
            console.error('❌ Error al cargar estadísticas:', error);
            showNotification('error', 'Error al cargar estadísticas de usuarios');
            // Mostrar error en las estadísticas
            ['totalUsers', 'activeUsers', 'pendingUsers', 'inactiveUsers'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.innerHTML = '<i class="bx bx-error-circle text-danger"></i>';
                }
            });
            return null;
        }
    }

    // ===================================
    // ACTUALIZAR CONTADOR CON ANIMACIÓN
    // ===================================
    function updateStatCounter(elementId, targetValue) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.warn(`⚠️ Elemento ${elementId} no encontrado`);
            return;
        }

        // Animar el contador de 0 al valor objetivo
        const duration = 1000; // 1 segundo
        const startTime = performance.now();
        const startValue = 0;

        function animate(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function (ease-out)
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(startValue + (targetValue - startValue) * easedProgress);

            element.textContent = currentValue;

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.textContent = targetValue; // Asegurar valor final exacto
            }
        }

        requestAnimationFrame(animate);
    }

    // ===================================
    // INICIALIZAR DATATABLE
    // ===================================
    async function initDataTable(users) {
        try {
            console.log('📋 Inicializando DataTable de usuarios...');

            // Verificar que tenemos datos
            if (!users || !Array.isArray(users)) {
                console.error('❌ No se proporcionaron datos de usuarios para la tabla');
                return;
            }

            // Verificar que la tabla existe en el DOM
            if ($('#usersTable').length === 0) {
                console.error('❌ Tabla #usersTable no encontrada en DOM');
                return;
            }

            // Destruir instancia previa si existe
            if (usersDataTable) {
                usersDataTable.destroy();
                usersDataTable = null;
            }

            console.log('✅ Usando datos ya cargados:', users.length, 'usuarios');

            // Inicializar DataTable
            usersDataTable = $('#usersTable').DataTable({
                data: users,
                columns: [
                    {
                        data: 'user_id',
                        width: '5%'
                    },
                    {
                        data: null,
                        width: '25%',
                        render: function (data, type, row) {
                            const initials = (row.first_name[0] + row.last_name[0]).toUpperCase();
                            const profilePic = row.profile_picture && row.profile_picture !== '/assets/img/default-avatar.png'
                                ? `<img src="${window.ENV_CONFIG.BACKEND_URL}${row.profile_picture}" class="rounded-circle" width="35" height="35" alt="${row.first_name}">`
                                : `<div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.85rem;">${initials}</div>`;

                            return `
                                <div class="d-flex align-items-center">
                                    ${profilePic}
                                    <div class="ms-2">
                                        <div class="fw-semibold">${row.first_name} ${row.last_name}</div>
                                        <small class="text-muted">@${row.username}</small>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'email',
                        width: '20%'
                    },
                    {
                        data: null,
                        width: '12%',
                        render: function (data, type, row) {
                            const roleColors = {
                                1: 'info',      // user - azul claro
                                2: 'primary',   // admin - azul
                                3: 'warning'    // supervisor - amarillo
                            };
                            const color = roleColors[row.role_id] || 'secondary';
                            return `<span class="badge bg-${color}">${row.role_name}</span>`;
                        }
                    },
                    {
                        data: null,
                        width: '12%',
                        render: function (data, type, row) {
                            const statusColors = {
                                1: 'success',   // active - verde
                                2: 'secondary'  // inactive - gris
                            };
                            const color = statusColors[row.status_id] || 'secondary';
                            return `<span class="badge bg-${color}">${row.status_name}</span>`;
                        }
                    },
                    {
                        data: 'created_at',
                        width: '12%',
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('es-CO') : 'N/A';
                        }
                    },
                    {
                        data: null,
                        width: '14%',
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-outline-info view-user-btn" data-user-id="${row.user_id}" title="Ver Detalles">
                                    <i class="bx bx-show"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-primary edit-user-btn" data-user-id="${row.user_id}" title="Editar">
                                    <i class="bx bx-edit"></i>
                                </button>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']], // Ordenar por ID descendente
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                drawCallback: function () {
                    applyDataTableDarkMode();
                    attachRowEventListeners();
                }
            });

            console.log('✅ DataTable inicializado correctamente');

        } catch (error) {
            console.error('❌ Error al inicializar DataTable:', error);
            showNotification('error', 'Error al cargar la tabla de usuarios');
        }
    }

    // ===================================
    // APLICAR MODO OSCURO A DATATABLE
    // ===================================
    function applyDataTableDarkMode() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

        if (isDark) {
            $('#usersTable').addClass('table-dark');
            $('.dataTables_wrapper').addClass('text-light');
        } else {
            $('#usersTable').removeClass('table-dark');
            $('.dataTables_wrapper').removeClass('text-light');
        }
    }

    // ===================================
    // ADJUNTAR EVENT LISTENERS A FILAS
    // ===================================
    function attachRowEventListeners() {
        // Botón Ver Detalles
        $('.view-user-btn').off('click').on('click', function () {
            const userId = $(this).data('user-id');
            viewUserDetails(userId);
        });

        // Botón Editar
        $('.edit-user-btn').off('click').on('click', function () {
            const userId = $(this).data('user-id');
            editUser(userId);
        });
    }

    // ===================================
    // VER DETALLES DE USUARIO (MODAL)
    // ===================================
    async function viewUserDetails(userId) {
        try {
            console.log('👁️ Cargando detalles del usuario:', userId);

            // Mostrar loading
            Swal.fire({
                title: 'Cargando...',
                text: 'Obteniendo detalles del usuario',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Obtener detalles del usuario
            // IMPORTANTE: Enviar como URLSearchParams con Content-Type correcto
            const params = new URLSearchParams();
            params.append('user_id', userId);

            const response = await window.AppRouter.post('/routes/admin/det_user.php', params, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            Swal.close();

            if (!response.status === 'success' || !response.data) {
                throw new Error(response.message || 'Error al obtener detalles del usuario');
            }

            const user = response.data;
            currentUserData = user;

            // Construir HTML del modal
            const modalHtml = `
                <div class="text-center mb-4">
                    ${user.profile_picture && user.profile_picture !== '/assets/img/default-avatar.png'
                    ? `<img src="${window.ENV_CONFIG.BACKEND_URL}${user.profile_picture}" class="rounded-circle mb-3" width="120" height="120" alt="${user.first_name}">`
                    : `<div class="avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; font-size: 2.5rem;">${(user.first_name[0] + user.last_name[0]).toUpperCase()}</div>`
                }
                    <h4 class="mb-1">${user.first_name} ${user.last_name}</h4>
                    <p class="text-muted mb-0">@${user.username}</p>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-envelope me-1"></i> Email</label>
                        <p class="fw-semibold mb-0">${user.email}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-phone me-1"></i> Teléfono</label>
                        <p class="fw-semibold mb-0">${user.phone || 'No especificado'}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-cake me-1"></i> Fecha de Nacimiento</label>
                        <p class="fw-semibold mb-0">${user.birthdate ? new Date(user.birthdate).toLocaleDateString('es-CO') : 'No especificado'}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-map me-1"></i> Ubicación</label>
                        <p class="fw-semibold mb-0">${user.city ? `${user.city}, ${user.country}` : 'No especificado'}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-user-circle me-1"></i> Género</label>
                        <p class="fw-semibold mb-0">${user.gender_name || 'No especificado'}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-shield me-1"></i> Rol</label>
                        <p class="mb-0"><span class="badge ${getRoleBadgeClass(user.role_id)}">${user.role_name || 'Sin rol'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-check-circle me-1"></i> Estado</label>
                        <p class="mb-0"><span class="badge ${getStatusBadgeClass(user.status_id)}">${user.status_name || 'Sin estado'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-1"><i class="bx bx-calendar me-1"></i> Registro</label>
                        <p class="fw-semibold mb-0">${new Date(user.created_at).toLocaleDateString('es-CO')}</p>
                    </div>
                    ${user.bio ? `
                    <div class="col-12">
                        <label class="text-muted small mb-1"><i class="bx bx-info-circle me-1"></i> Biografía</label>
                        <p class="mb-0">${user.bio}</p>
                    </div>
                    ` : ''}
                </div>
            `;

            // Mostrar modal con SweetAlert2
            Swal.fire({
                title: 'Detalles del Usuario',
                html: modalHtml,
                width: '600px',
                showCloseButton: true,
                showCancelButton: false,
                confirmButtonText: '<i class="bx bx-edit me-1"></i> Editar Usuario',
                confirmButtonColor: '#0d6efd',
                customClass: {
                    popup: 'text-start'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    editUser(userId);
                }
            });

            console.log('✅ Detalles del usuario mostrados');

        } catch (error) {
            console.error('❌ Error al cargar detalles del usuario:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'No se pudieron cargar los detalles del usuario',
                confirmButtonColor: '#dc3545'
            });
        }
    }

    // ===================================
    // EDITAR USUARIO (MODAL)
    // ===================================
    async function editUser(userId) {
        try {
            console.log('✏️ Abriendo modal de edición para usuario:', userId);

            // Si no tenemos los datos cargados, obtenerlos
            if (!currentUserData || currentUserData.user_id !== userId) {
                Swal.fire({
                    title: 'Cargando...',
                    text: 'Obteniendo datos del usuario',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // IMPORTANTE: Enviar como URLSearchParams con Content-Type correcto
                const params = new URLSearchParams();
                params.append('user_id', userId);

                const response = await window.AppRouter.post('/routes/admin/det_user.php', params, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                Swal.close();

                if (!response.status === 'success' || !response.data) {
                    throw new Error(response.message || 'Error al obtener datos del usuario');
                }

                currentUserData = response.data;
            }

            const user = currentUserData;

            // Construir formulario de edición
            const formHtml = `
                <form id="editUserForm" class="text-start">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" class="form-control" name="first_name" value="${user.first_name}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Apellido</label>
                            <input type="text" class="form-control" name="last_name" value="${user.last_name}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" name="username" value="${user.username}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email" value="${user.email}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="tel" class="form-control" name="phone" value="${user.phone || ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="birthdate" value="${user.birthdate || ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">País</label>
                            <input type="text" class="form-control" name="country" value="${user.country || ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ciudad</label>
                            <input type="text" class="form-control" name="city" value="${user.city || ''}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Género</label>
                            <select class="form-select" name="gender_id">
                                <option value="1" ${user.gender_id === 1 ? 'selected' : ''}>Prefiero no decirlo</option>
                                <option value="2" ${user.gender_id === 2 ? 'selected' : ''}>Masculino</option>
                                <option value="3" ${user.gender_id === 3 ? 'selected' : ''}>Femenino</option>
                                <option value="4" ${user.gender_id === 4 ? 'selected' : ''}>Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rol</label>
                            <select class="form-select" name="role_id" required>
                                <option value="1" ${user.role_id === 1 ? 'selected' : ''}>Usuario</option>
                                <option value="2" ${user.role_id === 2 ? 'selected' : ''}>Administrador</option>
                                <option value="3" ${user.role_id === 3 ? 'selected' : ''}>Supervisor</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Estado</label>
                            <select class="form-select" name="status_id" required>
                                <option value="1" ${user.status_id === 1 ? 'selected' : ''}>Activo</option>
                                <option value="2" ${user.status_id === 2 ? 'selected' : ''}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Biografía</label>
                            <textarea class="form-control" name="bio" rows="3" maxlength="255">${user.bio || ''}</textarea>
                            <small class="text-muted">Máximo 255 caracteres</small>
                        </div>
                    </div>
                </form>
            `;

            // Mostrar modal de edición
            Swal.fire({
                title: `Editar Usuario: ${user.first_name} ${user.last_name}`,
                html: formHtml,
                width: '700px',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="bx bx-save me-1"></i> Guardar Cambios',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'text-start'
                },
                preConfirm: () => {
                    const form = document.getElementById('editUserForm');
                    const formData = new FormData(form);

                    // Validar formulario HTML5
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return false;
                    }

                    // ===================================
                    // VALIDACIÓN MANUAL DE CAMPOS CRÍTICOS
                    // ===================================

                    const firstName = formData.get('first_name')?.trim();
                    const lastName = formData.get('last_name')?.trim();
                    const username = formData.get('username')?.trim();
                    const email = formData.get('email')?.trim();
                    const roleId = formData.get('role_id');
                    const statusId = formData.get('status_id');
                    const bio = formData.get('bio')?.trim();

                    // Validar nombre
                    if (!firstName || firstName.length === 0) {
                        Swal.showValidationMessage('El nombre es requerido');
                        return false;
                    }

                    if (firstName.length < 2) {
                        Swal.showValidationMessage('El nombre debe tener al menos 2 caracteres');
                        return false;
                    }

                    // Validar apellido
                    if (!lastName || lastName.length === 0) {
                        Swal.showValidationMessage('El apellido es requerido');
                        return false;
                    }

                    if (lastName.length < 2) {
                        Swal.showValidationMessage('El apellido debe tener al menos 2 caracteres');
                        return false;
                    }

                    // Validar username
                    if (!username || username.length === 0) {
                        Swal.showValidationMessage('El username es requerido');
                        return false;
                    }

                    if (username.length < 3) {
                        Swal.showValidationMessage('El username debe tener al menos 3 caracteres');
                        return false;
                    }

                    // Validar email
                    if (!email || email.length === 0) {
                        Swal.showValidationMessage('El email es requerido');
                        return false;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        Swal.showValidationMessage('El email debe ser válido');
                        return false;
                    }

                    // Validar rol
                    if (!roleId || !['1', '2', '3'].includes(roleId)) {
                        Swal.showValidationMessage('Debe seleccionar un rol válido');
                        return false;
                    }

                    // Validar estado
                    if (!statusId || !['1', '2'].includes(statusId)) {
                        Swal.showValidationMessage('Debe seleccionar un estado válido');
                        return false;
                    }

                    // Validar biografía (máximo 255 caracteres)
                    if (bio && bio.length > 255) {
                        Swal.showValidationMessage(`La biografía no puede exceder 255 caracteres (actual: ${bio.length})`);
                        return false;
                    }

                    // Validar fecha de nacimiento si se proporciona
                    const birthdate = formData.get('birthdate');
                    if (birthdate) {
                        const birthdateObj = new Date(birthdate);
                        const today = new Date();

                        if (birthdateObj > today) {
                            Swal.showValidationMessage('La fecha de nacimiento no puede ser futura');
                            return false;
                        }

                        const age = today.getFullYear() - birthdateObj.getFullYear();
                        if (age < 13) {
                            Swal.showValidationMessage('El usuario debe tener al menos 13 años');
                            return false;
                        }
                    }

                    // Validar gender_id
                    const genderId = formData.get('gender_id');
                    if (genderId) {
                        const genderIdInt = parseInt(genderId);
                        if (isNaN(genderIdInt) || genderIdInt < 1 || genderIdInt > 4) {
                            Swal.showValidationMessage('Debe seleccionar un género válido');
                            return false;
                        }
                    }

                    // ===================================
                    // CONSTRUIR OBJETO DE ACTUALIZACIÓN
                    // ===================================

                    const updateData = {
                        user_id: userId,
                        first_name: firstName,
                        last_name: lastName,
                        username: username,
                        email: email,
                        role_id: parseInt(roleId),
                        status_id: parseInt(statusId)
                    };

                    // Agregar campos opcionales solo si tienen valor
                    const phone = formData.get('phone')?.trim();
                    if (phone) updateData.phone = phone;

                    if (birthdate) updateData.birthdate = birthdate;

                    const country = formData.get('country')?.trim();
                    if (country) updateData.country = country;

                    const city = formData.get('city')?.trim();
                    if (city) updateData.city = city;

                    if (genderId) updateData.gender_id = parseInt(genderId);

                    if (bio) updateData.bio = bio;

                    console.log('📋 Datos de actualización validados:', updateData);

                    return updateData;
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await updateUser(result.value);
                }
            });

        } catch (error) {
            console.error('❌ Error al abrir modal de edición:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'No se pudo abrir el formulario de edición',
                confirmButtonColor: '#dc3545'
            });
        }
    }

    // ===================================
    // ACTUALIZAR USUARIO
    // ===================================
    async function updateUser(userData) {
        try {
            console.log('💾 Actualizando usuario:', userData);

            // Mostrar loading
            Swal.fire({
                title: 'Guardando...',
                text: 'Actualizando información del usuario',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enviar datos al backend (método PUT)
            const response = await window.AppRouter.put('/routes/admin/up_user.php', userData);

            Swal.close();

            if (response.status === 'success') {
                // Notificación de éxito
                showNotification('success', 'Usuario actualizado exitosamente');

                // Recargar datos (una sola llamada) y actualizar tabla y estadísticas
                const users = await loadUserStats();
                if (users && Array.isArray(users)) {
                    await initDataTable(users);
                }

                // Limpiar datos en caché
                currentUserData = null;

                console.log('Usuario actualizado correctamente');
            } else {
                throw new Error(response.message || 'Error al actualizar usuario');
            }

        } catch (error) {
            console.error('❌ Error al actualizar usuario:', error);

            Swal.fire({
                icon: 'error',
                title: 'Error al Actualizar',
                text: error.message || 'No se pudo actualizar la información del usuario',
                confirmButtonColor: '#dc3545'
            });
        }
    }

    // ===================================
    // FILTROS
    // ===================================
    function setupFilters() {
        // Limpiar filtros
        $('#clearFilters').on('click', function () {
            $('#searchUser').val('');
            $('#filterStatus').val('');
            $('#filterRole').val('');

            if (usersDataTable) {
                usersDataTable.search('').columns().search('').draw();
            }
        });

        // Filtro de búsqueda
        $('#searchUser').on('keyup', function () {
            if (usersDataTable) {
                usersDataTable.search(this.value).draw();
            }
        });

        // Filtro de estado
        $('#filterStatus').on('change', function () {
            if (usersDataTable) {
                usersDataTable.column(4).search(this.value).draw();
            }
        });

        // Filtro de rol
        $('#filterRole').on('change', function () {
            if (usersDataTable) {
                usersDataTable.column(3).search(this.value).draw();
            }
        });
    }

    // ===================================
    // DETECTAR CAMBIOS DE TEMA
    // ===================================
    function setupThemeObserver() {
        const themeObserver = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'data-bs-theme') {
                    applyDataTableDarkMode();
                }
            });
        });

        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-bs-theme']
        });
    }

    // ===================================
    // INICIALIZACIÓN
    // ===================================
    async function initialize() {
        console.log('🚀 Inicializando módulo de gestión de usuarios...');

        // Verificar que el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initialize);
            return;
        }

        // Verificar dependencias
        if (!checkDependencies()) {
            console.error('❌ No se pueden inicializar usuarios: faltan dependencias');
            return;
        }

        // Inicializar Notyf después de verificar dependencias
        initializeNotyf();

        try {
            // Cargar datos de usuarios y estadísticas (una sola llamada al backend)
            // loadUserStats esperará a que Axios esté listo (hasta 10 intentos)
            const users = await loadUserStats();

            // Si se cargaron los datos correctamente, inicializar DataTable
            if (Array.isArray(users) && users.length >= 0) {
                await initDataTable(users);

                // Configurar filtros
                setupFilters();

                // Configurar observer de tema
                setupThemeObserver();

                console.log('✅ Módulo de gestión de usuarios inicializado correctamente');
            } else {
                throw new Error('Los datos de usuarios no tienen el formato esperado');
            }

        } catch (error) {
            console.error('❌ Error al inicializar módulo de usuarios:', error);
            showNotification('error', 'Error al inicializar el módulo de usuarios');
        }
    }

    // Ejecutar inicialización
    initialize();

})();
