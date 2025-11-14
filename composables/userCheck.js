/**
 * userCheck.js - Servicio para obtener datos completos del usuario logueado
 * HomeLab AR - Roepard Labs
 *
 * Expone window.UserCheck.getUserData() que retorna una promesa con los datos del usuario
 * Los datos se guardan en window.currentUserData para acceso global
 */

(function (global) {
    const endpoint = '/routes/user/user_data.php';

    const UserCheck = {
        /**
         * Obtiene los datos completos del usuario logueado
         * @returns {Promise<object>} Promesa con los datos del usuario
         */
        async getUserData() {
            if (!window.AppRouter || typeof window.AppRouter.get !== 'function') {
                return Promise.reject('AppRouter no disponible');
            }
            try {
                const response = await window.AppRouter.get(endpoint);
                if (response.status === 'success' && response.data) {
                    global.currentUserData = response.data;
                    return response.data;
                } else {
                    return Promise.reject(response.message || 'No se pudo obtener datos de usuario');
                }
            } catch (err) {
                return Promise.reject(err);
            }
        }
    };

    global.UserCheck = UserCheck;
    // Inicializar variable global vacía
    global.currentUserData = null;
    console.log('✅ UserCheck inicializado');
})(window);