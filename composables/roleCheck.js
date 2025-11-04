/**
 * RoleCheck.js - Verificación de rol y permisos de usuario
 * HomeLab VR - Roepard Labs
 * 
 * @description Verifica el rol del usuario y sus permisos
 * @requires AppRouter (debe estar cargado antes)
 * @requires SessionService (opcional, mejora la experiencia)
 * @usage:
 *   - Verificar rol: await RoleService.check()
 *   - Es admin: RoleService.isAdmin()
 *   - Tiene permisos: RoleService.hasPermission('dashboard')
 *   - Escuchar cambios: window.addEventListener('roleChanged', handler)
 */

// Estado global de rol
window.RoleStatus = {
    checking: true,
    lastCheck: null,
    roleId: null,
    roleName: null,
    isAdmin: false,
    canAccessDashboard: false,
    permissions: [],
    error: null
};

// Servicio de rol reutilizable
window.RoleService = {
    /**
     * Verificar rol del usuario actual
     * @returns {Promise<Object>} Estado del rol
     */
    async check() {
        console.log('🔍 RoleService: Verificando rol de usuario...');

        // Esperar a que AppRouter esté listo
        if (!window.AppRouter || !window.AppRouter.axiosInstance) {
            console.warn('⚠️ RoleService: AppRouter no disponible, esperando...');
            await this._waitForRouter();
        }

        try {
            const response = await AppRouter.get('/routes/user/check_role.php');

            // Actualizar estado global
            window.RoleStatus.roleId = response.role_id || null;
            window.RoleStatus.roleName = response.role_name || null;
            window.RoleStatus.isAdmin = response.is_admin === true;
            window.RoleStatus.canAccessDashboard = response.can_access_dashboard === true;
            window.RoleStatus.checking = false;
            window.RoleStatus.lastCheck = new Date();
            window.RoleStatus.error = null;

            // Definir permisos según el rol
            window.RoleStatus.permissions = this._getPermissionsByRole(response.role_id);

            console.log('✅ RoleService: Rol verificado');
            console.log('👔 Rol:', window.RoleStatus.roleName, `(ID: ${window.RoleStatus.roleId})`);
            console.log('🔐 Permisos:', window.RoleStatus.permissions);

            // Disparar evento de cambio
            this._dispatchChange();

            return window.RoleStatus;
        } catch (error) {
            console.warn('⚠️ RoleService: No se pudo verificar el rol');
            console.warn('Error:', error.message);

            // Actualizar estado global
            window.RoleStatus.roleId = null;
            window.RoleStatus.roleName = null;
            window.RoleStatus.isAdmin = false;
            window.RoleStatus.canAccessDashboard = false;
            window.RoleStatus.permissions = [];
            window.RoleStatus.checking = false;
            window.RoleStatus.lastCheck = new Date();
            window.RoleStatus.error = error.message || 'Error desconocido';

            // Disparar evento de cambio
            this._dispatchChange();

            return window.RoleStatus;
        }
    },

    /**
     * Verificar si el usuario es administrador
     * @returns {boolean}
     */
    isAdmin() {
        return window.RoleStatus.isAdmin === true;
    },

    /**
     * Verificar si el usuario tiene un permiso específico
     * @param {string} permission - Nombre del permiso
     * @returns {boolean}
     */
    hasPermission(permission) {
        return window.RoleStatus.permissions.includes(permission);
    },

    /**
     * Verificar si el usuario puede acceder al dashboard
     * @returns {boolean}
     */
    canAccessDashboard() {
        return window.RoleStatus.canAccessDashboard === true;
    },

    /**
     * Obtener ID del rol actual
     * @returns {number|null}
     */
    getRoleId() {
        return window.RoleStatus.roleId;
    },

    /**
     * Obtener nombre del rol actual
     * @returns {string|null}
     */
    getRoleName() {
        return window.RoleStatus.roleName;
    },

    /**
     * Redirigir según el rol del usuario
     * @param {Object} routes - Rutas por rol {admin: '/admin', user: '/user', default: '/'}
     */
    redirectByRole(routes = {}) {
        const defaultRoutes = {
            admin: '/admin',
            user: '/user',
            supervisor: '/supervisor',
            default: '/'
        };

        const finalRoutes = { ...defaultRoutes, ...routes };

        if (this.isAdmin()) {
            window.location.href = finalRoutes.admin;
        } else if (window.RoleStatus.roleName === 'supervisor') {
            window.location.href = finalRoutes.supervisor;
        } else if (window.RoleStatus.roleName === 'user') {
            window.location.href = finalRoutes.user;
        } else {
            window.location.href = finalRoutes.default;
        }
    },

    /**
     * Obtener permisos según el rol (definición local)
     * @private
     * @param {number} roleId - ID del rol
     * @returns {Array<string>} Lista de permisos
     */
    _getPermissionsByRole(roleId) {
        const permissionMap = {
            1: ['read', 'profile'], // user
            2: ['read', 'write', 'delete', 'admin', 'dashboard', 'users', 'settings'], // admin
            3: ['read', 'write', 'supervise'] // supervisor
        };

        return permissionMap[roleId] || [];
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
                    console.log('✅ RoleService: AppRouter disponible');
                    resolve();
                }
            }, 100);
        });
    },

    /**
     * Disparar evento de cambio de rol
     * @private
     */
    _dispatchChange() {
        window.dispatchEvent(new CustomEvent('roleChanged', {
            detail: window.RoleStatus
        }));
    }
};

// Auto-ejecutar verificación si hay sesión activa
(async function autoCheckRole() {
    // Disparar evento inicial con estado "checking"
    window.RoleService._dispatchChange();

    // Esperar a que SessionService verifique primero (si está disponible)
    if (window.SessionService) {
        // Escuchar evento de sesión verificada
        window.addEventListener('sessionChanged', async function (event) {
            if (event.detail.isAuthenticated && !window.RoleStatus.roleId) {
                // Solo verificar rol si hay sesión y no se ha verificado aún
                await window.RoleService.check();
            }
        }, { once: true }); // Solo escuchar una vez
    } else {
        // Si SessionService no está disponible, verificar directamente
        setTimeout(async () => {
            await window.RoleService.check();
        }, 500); // Dar tiempo para que cargue SessionService
    }
})();

console.log('✅ RoleService inicializado y disponible globalmente');
