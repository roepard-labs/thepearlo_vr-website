/**
 * Sessions Management Service
 * Gestión completa de sesiones activas del usuario
 * HomeLab AR - Roepard Labs
 * 
 * @requires router.js (AppRouter con Axios)
 * @requires sweetalert2
 * @requires notyf
 */

(function () {
    'use strict';

    /**
     * Servicio de Gestión de Sesiones
     */
    window.SessionsService = {

        /**
         * Obtener todas las sesiones activas del usuario
         * @returns {Promise<Array>} Array de sesiones activas
         */
        async getActiveSessions() {
            try {
                // Verificar que AppRouter esté disponible
                if (!window.AppRouter) {
                    throw new Error('AppRouter no está disponible');
                }

                if (typeof window.AppRouter.isReady === 'function' && !window.AppRouter.isReady()) {
                    throw new Error('AppRouter no está inicializado');
                }

                const response = await window.AppRouter.get('/routes/user/list_sessions.php');

                if (response.status === 'success') {
                    return response.data.sessions || [];
                } else {
                    throw new Error(response.message || 'Error al obtener sesiones');
                }
            } catch (error) {
                console.error('❌ Error al obtener sesiones:', error);
                throw error;
            }
        },

        /**
         * Cerrar una sesión remota específica
         * @param {string} sessionId - ID de la sesión a cerrar
         * @returns {Promise<Object>} Resultado de la operación
         */
        async closeRemoteSession(sessionId) {
            try {
                const response = await window.AppRouter.post('/routes/user/close_remote_session.php', {
                    session_id: sessionId
                });

                return response;
            } catch (error) {
                console.error('❌ Error al cerrar sesión remota:', error);
                throw error;
            }
        },

        /**
         * Cerrar todas las sesiones excepto la actual
         * @returns {Promise<Object>} Resultado de la operación
         */
        async closeAllSessions() {
            try {
                const response = await window.AppRouter.post('/routes/user/close_all_sessions.php');

                return response;
            } catch (error) {
                console.error('❌ Error al cerrar todas las sesiones:', error);
                throw error;
            }
        },

        /**
         * Obtener historial de sesiones
         * @param {number} limit - Número máximo de registros (default: 20)
         * @returns {Promise<Array>} Array de sesiones históricas
         */
        async getSessionHistory(limit = 20) {
            try {
                const response = await window.AppRouter.get(`/routes/user/session_history.php?limit=${limit}`);

                if (response.status === 'success') {
                    return response.data.history || [];
                } else {
                    throw new Error(response.message || 'Error al obtener historial');
                }
            } catch (error) {
                console.error('❌ Error al obtener historial de sesiones:', error);
                throw error;
            }
        },

        /**
         * Renderizar tarjetas de sesiones activas en el DOM
         * @param {Array} sessions - Array de sesiones
         * @param {string} containerId - ID del contenedor donde renderizar
         */
        renderSessionCards(sessions, containerId) {
            const container = document.getElementById(containerId);

            if (!container) {
                console.error('❌ Contenedor no encontrado:', containerId);
                return;
            }

            if (!sessions || sessions.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bx bx-shield-x display-1 text-muted"></i>
                        <p class="text-muted mt-3">No hay sesiones activas</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = sessions.map(session => this.createSessionCard(session)).join('');
        },

        /**
         * Crear HTML de una tarjeta de sesión
         * @param {Object} session - Datos de la sesión
         * @returns {string} HTML de la tarjeta
         */
        createSessionCard(session) {
            // Iconos según el dispositivo
            const deviceIcons = {
                'desktop': 'bx-desktop',
                'mobile': 'bx-mobile',
                'tablet': 'bx-tablet',
                'unknown': 'bx-devices'
            };

            const deviceIcon = deviceIcons[session.device_type] || deviceIcons['unknown'];

            // Iconos según el navegador
            const browserIcons = {
                'Chrome': 'bxl-chrome',
                'Firefox': 'bxl-firefox',
                'Safari': 'bxl-safari',
                'Edge': 'bxl-edge',
                'Opera': 'bxl-opera'
            };

            const browserIcon = browserIcons[session.browser] || 'bx-globe';

            // Indicador de sesión actual
            const currentBadge = session.is_current
                ? '<span class="badge bg-success ms-2">Sesión Actual</span>'
                : '';

            // Formato de fecha de actividad
            const lastActivity = session.last_activity
                ? new Date(session.last_activity).toLocaleString('es-ES', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })
                : 'Desconocida';

            return `
                <div class="card border-0 shadow-sm mb-3 session-card" data-session-id="${session.session_id}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="session-icon me-3">
                                    <i class="bx ${deviceIcon} fs-2 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        ${session.device_type || 'Dispositivo desconocido'}
                                        ${currentBadge}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bx ${browserIcon} me-1"></i>
                                        ${session.browser || 'Navegador desconocido'} en ${session.os || 'Sistema desconocido'}
                                    </small>
                                </div>
                            </div>
                            ${!session.is_current ? `
                                <button class="btn btn-sm btn-outline-danger btn-close-session" 
                                        data-session-id="${session.session_id}"
                                        title="Cerrar esta sesión">
                                    <i class="bx bx-x"></i>
                                </button>
                            ` : ''}
                        </div>

                        <div class="row g-3 small text-muted">
                            <div class="col-md-6">
                                <i class="bx bx-map-pin me-1"></i>
                                <strong>IP:</strong> ${session.ip_address || 'Desconocida'}
                            </div>
                            <div class="col-md-6">
                                <i class="bx bx-time me-1"></i>
                                <strong>Última actividad:</strong> ${lastActivity}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        },

        /**
         * Confirmar y cerrar una sesión remota
         * @param {string} sessionId - ID de la sesión a cerrar
         * @param {Function} callback - Callback después de cerrar
         */
        async confirmCloseSession(sessionId, callback) {
            const result = await Swal.fire({
                title: '¿Cerrar esta sesión?',
                text: 'Esta acción cerrará la sesión remota inmediatamente',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                try {
                    const response = await this.closeRemoteSession(sessionId);

                    if (response.status === 'success') {
                        // Notificación de éxito
                        const notyf = new Notyf({ duration: 3000 });
                        notyf.success('Sesión cerrada exitosamente');

                        // Ejecutar callback
                        if (callback) callback();
                    } else {
                        throw new Error(response.message);
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'No se pudo cerrar la sesión',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }
            }
        },

        /**
         * Confirmar y cerrar todas las sesiones excepto la actual
         * @param {Function} callback - Callback después de cerrar
         */
        async confirmCloseAllSessions(callback) {
            const result = await Swal.fire({
                title: '¿Cerrar todas las sesiones?',
                text: 'Se cerrarán todas las sesiones activas excepto la actual',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cerrar todas',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                try {
                    const response = await this.closeAllSessions();

                    if (response.status === 'success') {
                        const sessionsCount = response.data?.sessions_closed || 0;

                        Swal.fire({
                            title: '¡Sesiones cerradas!',
                            text: `Se ${sessionsCount === 1 ? 'ha' : 'han'} cerrado ${sessionsCount} ${sessionsCount === 1 ? 'sesión' : 'sesiones'}`,
                            icon: 'success',
                            timer: 3000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                        // Ejecutar callback
                        if (callback) callback();
                    } else {
                        throw new Error(response.message);
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'No se pudieron cerrar las sesiones',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }
            }
        },

        /**
         * Inicializar eventos de botones de cerrar sesión
         * @param {string} containerId - ID del contenedor de sesiones
         * @param {Function} reloadCallback - Callback para recargar sesiones
         */
        initSessionEvents(containerId, reloadCallback) {
            const container = document.getElementById(containerId);

            if (!container) return;

            // Delegación de eventos para botones de cerrar sesión individual
            container.addEventListener('click', async (e) => {
                const closeBtn = e.target.closest('.btn-close-session');

                if (closeBtn) {
                    const sessionId = closeBtn.dataset.sessionId;
                    await this.confirmCloseSession(sessionId, reloadCallback);
                }
            });
        }
    };

    console.log('✅ SessionsService cargado correctamente');

})();
