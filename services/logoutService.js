/**
 * LogoutService.js - Servicio de cierre de sesión
 * HomeLab VR - Roepard Labs
 * 
 * @description Maneja el cierre de sesión del usuario
 * @requires AppRouter (debe estar cargado antes)
 * @requires SweetAlert2 (opcional, para confirmaciones elegantes)
 * @requires Notyf (opcional, para notificaciones)
 * @usage:
 *   - Logout con confirmación: await LogoutService.logout()
 *   - Logout sin confirmación: await LogoutService.logout({ confirm: false })
 *   - Logout silencioso: await LogoutService.logoutSilent()
 */

window.LogoutService = {
    /**
     * Cerrar sesión del usuario con confirmación
     * @param {Object} options - Opciones de configuración
     * @param {boolean} options.confirm - Mostrar confirmación (default: true)
     * @param {boolean} options.redirect - Redirigir después del logout (default: true)
     * @param {string} options.redirectUrl - URL de redirección (default: '/')
     * @param {boolean} options.notification - Mostrar notificación (default: true)
     * @returns {Promise<boolean>} true si logout exitoso, false si cancelado
     */
    async logout(options = {}) {
        const config = {
            confirm: true,
            redirect: true,
            redirectUrl: '/',
            notification: true,
            ...options
        };

        console.log('🚪 LogoutService: Iniciando proceso de logout...');

        // Mostrar confirmación si está habilitada
        if (config.confirm) {
            const confirmed = await this._showConfirmation();
            if (!confirmed) {
                console.log('ℹ️ LogoutService: Logout cancelado por el usuario');
                return false;
            }
        }

        // Ejecutar logout
        const success = await this._performLogout();

        if (success) {
            // Mostrar notificación si está habilitada
            if (config.notification) {
                this._showNotification('success', 'Sesión cerrada correctamente');
            }

            // Limpiar estados globales
            this._clearGlobalStates();

            // Redirigir si está habilitado
            if (config.redirect) {
                console.log('🔄 LogoutService: Redirigiendo a', config.redirectUrl);
                setTimeout(() => {
                    window.location.href = config.redirectUrl;
                }, 1000);
            }

            return true;
        } else {
            // Mostrar error
            this._showNotification('error', 'Error al cerrar sesión');
            return false;
        }
    },

    /**
     * Cerrar sesión silenciosamente (sin confirmación ni notificaciones)
     * @param {string} redirectUrl - URL de redirección (default: '/')
     * @returns {Promise<boolean>}
     */
    async logoutSilent(redirectUrl = '/') {
        console.log('🚪 LogoutService: Logout silencioso...');

        const success = await this._performLogout();

        if (success) {
            this._clearGlobalStates();
            window.location.href = redirectUrl;
        }

        return success;
    },

    /**
     * Ejecutar logout en el backend
     * @private
     * @returns {Promise<boolean>}
     */
    async _performLogout() {
        // Esperar a que AppRouter esté listo
        if (!window.AppRouter || !window.AppRouter.axiosInstance) {
            console.warn('⚠️ LogoutService: AppRouter no disponible');
            // Intentar logout básico sin AppRouter
            return this._basicLogout();
        }

        try {
            console.log('📤 LogoutService: Enviando petición de logout...');

            const response = await AppRouter.post('/routes/user/logout_user.php', {});

            console.log('✅ LogoutService: Logout exitoso');
            console.log('📥 Respuesta:', response);

            return true;
        } catch (error) {
            console.error('❌ LogoutService: Error en logout', error);

            // Intentar logout básico como fallback
            return this._basicLogout();
        }
    },

    /**
     * Logout básico sin AppRouter (fallback)
     * @private
     * @returns {Promise<boolean>}
     */
    async _basicLogout() {
        console.log('🔄 LogoutService: Intentando logout con fetch...');

        const apiUrl = window.ENV_CONFIG?.API_URL || 'http://localhost:3000';

        try {
            const response = await fetch(apiUrl + '/routes/user/logout_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include' // Importante para sesiones CORS
            });

            if (response.ok) {
                console.log('✅ LogoutService: Logout básico exitoso');
                return true;
            } else {
                console.warn('⚠️ LogoutService: Logout básico falló');
                return false;
            }
        } catch (error) {
            console.error('❌ LogoutService: Error en logout básico', error);
            return false;
        }
    },

    /**
     * Mostrar confirmación de logout
     * @private
     * @returns {Promise<boolean>}
     */
    async _showConfirmation() {
        // Usar SweetAlert2 si está disponible
        if (typeof Swal !== 'undefined') {
            const result = await Swal.fire({
                title: '¿Cerrar sesión?',
                text: '¿Estás seguro de que deseas cerrar tu sesión?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            });

            return result.isConfirmed;
        } else {
            // Fallback a confirmación nativa
            return confirm('¿Estás seguro de que deseas cerrar tu sesión?');
        }
    },

    /**
     * Mostrar notificación
     * @private
     * @param {string} type - Tipo de notificación ('success'|'error'|'warning')
     * @param {string} message - Mensaje a mostrar
     */
    _showNotification(type, message) {
        // Usar Notyf si está disponible
        if (typeof Notyf !== 'undefined') {
            const notyf = new Notyf({
                duration: 3000,
                position: { x: 'right', y: 'top' }
            });

            if (type === 'success') {
                notyf.success(message);
            } else if (type === 'error') {
                notyf.error(message);
            } else {
                notyf.open({ type: 'warning', message: message });
            }
        } else if (typeof Swal !== 'undefined') {
            // Fallback a SweetAlert2
            Swal.fire({
                icon: type,
                title: message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            // Fallback a console
            console.log(`[${type.toUpperCase()}] ${message}`);
        }
    },

    /**
     * Limpiar estados globales después del logout
     * @private
     */
    _clearGlobalStates() {
        console.log('🧹 LogoutService: Limpiando estados globales...');

        // Limpiar SessionStatus
        if (window.SessionStatus) {
            window.SessionStatus.isAuthenticated = false;
            window.SessionStatus.userData = null;
            window.SessionStatus.error = null;
        }

        // Limpiar RoleStatus
        if (window.RoleStatus) {
            window.RoleStatus.roleId = null;
            window.RoleStatus.roleName = null;
            window.RoleStatus.isAdmin = false;
            window.RoleStatus.canAccessDashboard = false;
            window.RoleStatus.permissions = [];
            window.RoleStatus.error = null;
        }

        // Disparar eventos de cambio
        if (window.SessionService) {
            window.SessionService._dispatchChange();
        }
        if (window.RoleService) {
            window.RoleService._dispatchChange();
        }

        console.log('✅ LogoutService: Estados globales limpiados');
    },

    /**
     * Agregar botón de logout automáticamente
     * @param {string} selector - Selector CSS del elemento del botón
     * @param {Object} options - Opciones del logout
     */
    attachToButton(selector, options = {}) {
        const button = document.querySelector(selector);

        if (!button) {
            console.warn(`⚠️ LogoutService: Botón ${selector} no encontrado`);
            return;
        }

        button.addEventListener('click', async (e) => {
            e.preventDefault();
            await this.logout(options);
        });

        console.log(`✅ LogoutService: Handler agregado a ${selector}`);
    }
};

// Auto-adjuntar a botones de logout comunes al cargar
document.addEventListener('DOMContentLoaded', function () {
    console.log('🔍 LogoutService: Buscando botones de logout...');

    // Buscar botones de logout comunes
    const logoutButtons = [
        '#logoutBtn',                    // Header
        '#logoutBtnSidebar',            // Sidebar expandido
        '#logoutBtnSidebarCollapsed',   // Sidebar colapsado
        '.logout-btn',
        '[data-logout]'
    ];

    logoutButtons.forEach(selector => {
        const button = document.querySelector(selector);
        if (button && !button.hasAttribute('data-logout-attached')) {
            window.LogoutService.attachToButton(selector, {
                confirm: true,
                redirect: true,
                redirectUrl: '/'
            });
            button.setAttribute('data-logout-attached', 'true');
            console.log(`✅ LogoutService adjuntado a: ${selector}`);
        }
    });

    // Si no se encontraron botones, intentar de nuevo después de un delay
    // (útil para vistas que cargan dinámicamente)
    setTimeout(() => {
        logoutButtons.forEach(selector => {
            const button = document.querySelector(selector);
            if (button && !button.hasAttribute('data-logout-attached')) {
                window.LogoutService.attachToButton(selector, {
                    confirm: true,
                    redirect: true,
                    redirectUrl: '/'
                });
                button.setAttribute('data-logout-attached', 'true');
                console.log(`✅ LogoutService adjuntado (delayed) a: ${selector}`);
            }
        });
    }, 1000);
});

console.log('✅ LogoutService inicializado y disponible globalmente');
