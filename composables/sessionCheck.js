/**
 * SessionCheck.js - Verificación de sesión de usuario
 * HomeLab VR - Roepard Labs
 * 
 * @description Verifica si hay una sesión activa y proporciona datos del usuario
 * @features:
 *   - Verifica sesión PHP y estado en BD (user_sessions.is_active)
 *   - Cierra sesión automáticamente si is_active = 0 (sesión cerrada remotamente)
 *   - Verifica estado del usuario (activo/suspendido/baneado)
 *   - Redirige a home si sesión fue cerrada
 * @requires AppRouter (debe estar cargado antes)
 * @usage: 
 *   - Automático: Se ejecuta al cargar
 *   - Manual: await SessionService.check()
 *   - Escuchar cambios: window.addEventListener('sessionChanged', handler)
 */

// Estado global de sesión
window.SessionStatus = {
    isAuthenticated: false,
    checking: true,
    lastCheck: null,
    userData: null,
    error: null
};

// Servicio de sesión reutilizable
window.SessionService = {
    /**
     * Verificar sesión activa
     * @returns {Promise<Object>} Estado de la sesión
     */
    async check() {
        console.log('🔍 SessionService: Verificando sesión...');

        // Esperar a que AppRouter esté listo
        if (!window.AppRouter || !window.AppRouter.axiosInstance) {
            console.warn('⚠️ SessionService: AppRouter no disponible, esperando...');
            try {
                await this._waitForRouter();
            } catch (error) {
                console.error('❌ SessionService: Error esperando AppRouter:', error);
                window.SessionStatus.isAuthenticated = false;
                window.SessionStatus.checking = false;
                window.SessionStatus.error = error.message;
                this._dispatchChange();
                return window.SessionStatus;
            }
        }

        try {
            const response = await AppRouter.get('/routes/user/check_session.php');

            // ===================================
            // VERIFICAR SI SESIÓN FUE CERRADA REMOTAMENTE
            // ===================================
            if (response.session_active === false || response.user_active === false) {
                console.warn('⚠️ SessionService: Sesión cerrada remotamente o usuario inactivo');
                console.warn('📊 Estado:', {
                    session_active: response.session_active,
                    user_active: response.user_active,
                    message: response.message
                });

                // Actualizar estado global
                window.SessionStatus.isAuthenticated = false;
                window.SessionStatus.userData = null;
                window.SessionStatus.checking = false;
                window.SessionStatus.lastCheck = new Date();
                window.SessionStatus.error = response.message || 'Sesión cerrada';

                // Disparar evento de cambio
                this._dispatchChange();

                // ACCIÓN REQUERIDA: Cerrar sesión en frontend
                if (response.action_required === 'logout') {
                    console.log('🚪 SessionService: Cerrando sesión automáticamente...');

                    // Notificar al usuario
                    if (window.Notyf) {
                        const notyf = new Notyf({ duration: 5000 });
                        notyf.error(response.message || 'Tu sesión ha sido cerrada');
                    }

                    // Redirigir a home después de 2 segundos
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                }

                return window.SessionStatus;
            }

            // ===================================
            // SESIÓN VÁLIDA Y ACTIVA
            // ===================================

            // Actualizar estado global
            window.SessionStatus.isAuthenticated = response.logged === true;
            window.SessionStatus.userData = response.user_data || null;
            window.SessionStatus.checking = false;
            window.SessionStatus.lastCheck = new Date();
            window.SessionStatus.error = null;

            console.log('✅ SessionService: Sesión verificada');
            console.log('👤 Usuario:', window.SessionStatus.userData);
            console.log('🔒 Sesión activa en BD:', response.session_active);
            console.log('✅ Usuario activo:', response.user_active);

            // Disparar evento de cambio
            this._dispatchChange();

            return window.SessionStatus;
        } catch (error) {
            console.warn('⚠️ SessionService: No hay sesión activa o error de red');

            // Actualizar estado global
            window.SessionStatus.isAuthenticated = false;
            window.SessionStatus.userData = null;
            window.SessionStatus.checking = false;
            window.SessionStatus.lastCheck = new Date();
            window.SessionStatus.error = error.message || 'Error desconocido';

            // Disparar evento de cambio
            this._dispatchChange();

            return window.SessionStatus;
        }
    },

    /**
     * Obtener datos del usuario actual
     * @returns {Object|null} Datos del usuario o null
     */
    getUser() {
        return window.SessionStatus.userData;
    },

    /**
     * Verificar si está autenticado
     * @returns {boolean} Estado de autenticación
     */
    isAuthenticated() {
        return window.SessionStatus.isAuthenticated === true;
    },

    /**
     * Esperar a que AppRouter esté disponible
     * @private
     */
    _waitForRouter() {
        return new Promise((resolve, reject) => {
            let attempts = 0;
            const MAX_ATTEMPTS = 50; // 5 segundos máximo (50 * 100ms)

            const checkInterval = setInterval(() => {
                attempts++;

                if (window.AppRouter && window.AppRouter.axiosInstance) {
                    clearInterval(checkInterval);
                    console.log('✅ SessionService: AppRouter disponible');
                    resolve();
                } else if (attempts >= MAX_ATTEMPTS) {
                    clearInterval(checkInterval);
                    console.error('❌ SessionService: Timeout esperando AppRouter después de', attempts, 'intentos');
                    reject(new Error('AppRouter no disponible después de ' + (MAX_ATTEMPTS * 100) + 'ms'));
                }
            }, 100);
        });
    },

    /**
     * Disparar evento de cambio de sesión
     * @private
     */
    _dispatchChange() {
        window.dispatchEvent(new CustomEvent('sessionChanged', {
            detail: window.SessionStatus
        }));
    }
};

// DESACTIVADO: Auto-ejecución causa bucles infinitos cuando se carga múltiples veces
// Las vistas deben llamar explícitamente a SessionService.check() cuando estén listas
/*
(async function autoCheckSession() {
    // Disparar evento inicial con estado "checking"
    window.SessionService._dispatchChange();

    // Ejecutar verificación
    await window.SessionService.check();
})();
*/

// Verificación periódica (cada 5 minutos) - Solo si AppRouter está disponible
setInterval(async function () {
    if (window.AppRouter && window.AppRouter.axiosInstance) {
        await window.SessionService.check();
    }
}, 300000); // 5 minutos

console.log('✅ SessionService inicializado y disponible globalmente (sin auto-ejecución)');
