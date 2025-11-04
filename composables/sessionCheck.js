/**
 * SessionCheck.js - Verificación de sesión de usuario
 * HomeLab VR - Roepard Labs
 * 
 * @description Verifica si hay una sesión activa y proporciona datos del usuario
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
            await this._waitForRouter();
        }

        try {
            const response = await AppRouter.get('/routes/user/check_session.php');

            // Actualizar estado global
            window.SessionStatus.isAuthenticated = response.logged === true;
            window.SessionStatus.userData = response.user_data || null;
            window.SessionStatus.checking = false;
            window.SessionStatus.lastCheck = new Date();
            window.SessionStatus.error = null;

            console.log('✅ SessionService: Sesión verificada');
            console.log('👤 Usuario:', window.SessionStatus.userData);

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
        return new Promise((resolve) => {
            const checkInterval = setInterval(() => {
                if (window.AppRouter && window.AppRouter.axiosInstance) {
                    clearInterval(checkInterval);
                    console.log('✅ SessionService: AppRouter disponible');
                    resolve();
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

// Auto-ejecutar verificación al cargar
(async function autoCheckSession() {
    // Disparar evento inicial con estado "checking"
    window.SessionService._dispatchChange();

    // Ejecutar verificación
    await window.SessionService.check();
})();

// Verificación periódica (cada 5 minutos)
setInterval(async function () {
    if (window.AppRouter && window.AppRouter.axiosInstance) {
        await window.SessionService.check();
    }
}, 300000); // 5 minutos

console.log('✅ SessionService inicializado y disponible globalmente');
