/**
 * Dashboard Check Service
 * Funciones auxiliares para el dashboard
 * HomeLab AR - Roepard Labs
 */

(function () {
    'use strict';

    // ===================================
    // DASHBOARD CHECK SERVICE
    // ===================================
    window.DashboardCheckService = {

        /**
         * Verificar acceso al dashboard
         * @returns {Promise<boolean>}
         */
        async canAccessDashboard() {
            try {
                if (!window.SessionService || !window.RoleService) {
                    console.warn('⚠️ Services no disponibles para verificar acceso');
                    return false;
                }

                const session = await window.SessionService.check();
                if (!session.isAuthenticated) {
                    console.log('❌ Usuario no autenticado');
                    return false;
                }

                const role = await window.RoleService.check();
                if (role.can_access_dashboard) {
                    console.log('✅ Usuario puede acceder al dashboard');
                    return true;
                } else {
                    console.log('❌ Usuario no tiene permisos de dashboard');
                    return false;
                }
            } catch (error) {
                console.error('❌ Error al verificar acceso:', error);
                return false;
            }
        },

        /**
         * Verificar si es administrador
         * @returns {Promise<boolean>}
         */
        async isAdmin() {
            try {
                if (!window.RoleService) {
                    console.warn('⚠️ RoleService no disponible');
                    return false;
                }

                const role = await window.RoleService.check();
                return role.is_admin === true;
            } catch (error) {
                console.error('❌ Error al verificar rol admin:', error);
                return false;
            }
        },

        /**
         * Redirigir a login si no está autenticado
         */
        async redirectIfNotAuthenticated() {
            const canAccess = await this.canAccessDashboard();
            if (!canAccess) {
                console.log('🔄 Redirigiendo a home...');
                window.location.href = '/';
            }
        },

        /**
         * Verificar estado del backend
         * @returns {Promise<object>}
         */
        async checkBackendStatus() {
            try {
                if (!window.AppRouter) {
                    throw new Error('AppRouter no disponible');
                }

                const data = await window.AppRouter.get('/routes/web/status.php');
                return {
                    online: data.status === 'success',
                    message: data.message,
                    timestamp: data.timestamp
                };
            } catch (error) {
                return {
                    online: false,
                    message: error.message,
                    timestamp: new Date().toISOString()
                };
            }
        }
    };

    console.log('✅ DashboardCheckService inicializado');

})();
