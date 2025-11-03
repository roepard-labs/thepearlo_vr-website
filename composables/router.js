/**
 * Router.js - HTTP Client with Axios for API communication
 * HomeLab VR - Roepard Labs
 * 
 * @description Cliente HTTP reutilizable basado en Axios para comunicación con backend API
 * @version 2.0.0
 * @requires axios (cargado vía NPM)
 */

// ============================================
// CONFIGURATION FROM .ENV
// ============================================

/**
 * La configuración se carga desde config.js (generado desde .env)
 * 
 * Para actualizar la configuración:
 * 1. Edita el archivo .env en la raíz del proyecto
 * 2. Ejecuta: npm run build:config
 * 3. Recarga la página
 * 
 * En producción, ejecuta build:config antes del deploy
 */

// Verificar que config.js se haya cargado
if (typeof window.ENV_CONFIG === 'undefined') {
    console.error('❌ ERROR: config.js no está cargado');
    console.error('Ejecuta: npm run build:config');

    // Fallback para desarrollo
    window.ENV_CONFIG = {
        API_URL: 'http://localhost:3000',
        BACKEND_URL: 'http://localhost:3000',
        APP_NAME: 'Roepard Homelab (Fallback)'
    };
}

// ============================================
// AXIOS HTTP CLIENT
// ============================================

/**
 * Clase Router - Cliente HTTP con Axios
 * @class
 */
class Router {
    constructor() {
        this.baseURL = window.ENV_CONFIG.API_URL || window.ENV_CONFIG.BACKEND_URL;
        this.appName = window.ENV_CONFIG.APP_NAME;
        this.axiosInstance = null;

        // Log de configuración
        console.log('🚀 Router inicializado con Axios');
        console.log('📡 API URL:', this.baseURL);
        console.log('🏷️  App Name:', this.appName);
        console.log('🔐 Config source:', typeof window.ENV_CONFIG._generated !== 'undefined' ? 'Generated from .env' : 'Fallback');

        // Inicializar Axios cuando esté disponible
        this.initAxios();
    }

    /**
     * Inicializar instancia de Axios con configuración predeterminada
     * @private
     */
    initAxios() {
        // Esperar a que Axios esté disponible
        if (typeof axios === 'undefined') {
            console.warn('⚠️ Axios no está cargado aún. Esperando...');
            setTimeout(() => this.initAxios(), 100);
            return;
        }

        this.axiosInstance = axios.create({
            baseURL: this.baseURL,
            timeout: 30000, // 30 segundos
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            withCredentials: true // Para enviar cookies de sesión
        });

        // Interceptor de request (para logging y modificaciones)
        this.axiosInstance.interceptors.request.use(
            (config) => {
                console.log(`📤 ${config.method.toUpperCase()}: ${config.url}`);
                if (config.data) {
                    console.log('📦 Data:', config.data);
                }
                return config;
            },
            (error) => {
                console.error('❌ Request Error:', error);
                return Promise.reject(error);
            }
        );

        // Interceptor de response (para logging y manejo de errores)
        this.axiosInstance.interceptors.response.use(
            (response) => {
                console.log(`📥 Response [${response.status}]:`, response.data);
                return response;
            },
            (error) => {
                if (error.response) {
                    // Error con respuesta del servidor
                    console.error('❌ Response Error:', error.response.status, error.response.data);
                } else if (error.request) {
                    // Error sin respuesta (timeout, network error)
                    console.error('❌ Network Error:', error.message);
                } else {
                    // Error en la configuración del request
                    console.error('❌ Request Setup Error:', error.message);
                }
                return Promise.reject(error);
            }
        );

        console.log('✅ Axios inicializado correctamente');
    }

    /**
     * Verificar si Axios está inicializado
     * @private
     * @returns {boolean}
     */
    isReady() {
        if (!this.axiosInstance) {
            console.error('❌ Axios no está inicializado. Usa router.initAxios() primero.');
            return false;
        }
        return true;
    }

    /**
     * Construir URL completa para endpoint
     * @param {string} endpoint - Ruta del endpoint (ej: '/routes/user/auth_user.php')
     * @returns {string} URL completa
     */
    buildURL(endpoint) {
        // Si el endpoint ya incluye http/https, retornarlo directamente
        if (endpoint.startsWith('http://') || endpoint.startsWith('https://')) {
            return endpoint;
        }

        // Asegurar que el endpoint comience con /
        const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`;
        return `${this.baseURL}${cleanEndpoint}`;
    }

    /**
     * Realizar petición GET
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} config - Configuración adicional de Axios
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async get(endpoint, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            const response = await this.axiosInstance.get(endpoint, config);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar petición POST
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} data - Datos a enviar
     * @param {object} config - Configuración adicional de Axios
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async post(endpoint, data = {}, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            const response = await this.axiosInstance.post(endpoint, data, config);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar petición PUT
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} data - Datos a enviar
     * @param {object} config - Configuración adicional de Axios
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async put(endpoint, data = {}, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            const response = await this.axiosInstance.put(endpoint, data, config);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar petición PATCH
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} data - Datos a enviar
     * @param {object} config - Configuración adicional de Axios
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async patch(endpoint, data = {}, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            const response = await this.axiosInstance.patch(endpoint, data, config);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar petición DELETE
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} config - Configuración adicional de Axios
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async delete(endpoint, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            const response = await this.axiosInstance.delete(endpoint, config);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar petición con FormData (para uploads de archivos)
     * @param {string} endpoint - Ruta del endpoint
     * @param {FormData} formData - FormData con archivos
     * @param {object} config - Configuración adicional
     * @returns {Promise<any>} Promesa con la respuesta
     */
    async upload(endpoint, formData, config = {}) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        const uploadConfig = {
            ...config,
            headers: {
                'Content-Type': 'multipart/form-data',
                ...config.headers
            },
            onUploadProgress: (progressEvent) => {
                const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                console.log(`📤 Upload progress: ${percentCompleted}%`);
                if (config.onUploadProgress) {
                    config.onUploadProgress(percentCompleted);
                }
            }
        };

        try {
            const response = await this.axiosInstance.post(endpoint, formData, uploadConfig);
            return response.data;
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Realizar múltiples peticiones en paralelo
     * @param {Array<Promise>} requests - Array de promesas de peticiones
     * @returns {Promise<Array>} Array con todas las respuestas
     */
    async all(requests) {
        if (!this.isReady()) return Promise.reject('Axios no inicializado');

        try {
            return await axios.all(requests);
        } catch (error) {
            this.handleError(error);
            throw error;
        }
    }

    /**
     * Manejo centralizado de errores
     * @private
     * @param {Error} error - Error de Axios
     */
    handleError(error) {
        if (error.response) {
            // Error con respuesta del servidor (4xx, 5xx)
            const status = error.response.status;
            const message = error.response.data?.message || error.response.statusText;

            switch (status) {
                case 400:
                    console.error('❌ Bad Request:', message);
                    break;
                case 401:
                    console.error('❌ No autorizado:', message);
                    // Redirigir a login si es necesario
                    // window.location.href = '/login';
                    break;
                case 403:
                    console.error('❌ Acceso denegado:', message);
                    break;
                case 404:
                    console.error('❌ Recurso no encontrado:', message);
                    break;
                case 500:
                    console.error('❌ Error del servidor:', message);
                    break;
                default:
                    console.error(`❌ Error ${status}:`, message);
            }
        } else if (error.request) {
            // Error sin respuesta (timeout, network error)
            console.error('❌ Error de red o timeout:', error.message);
        } else {
            // Error en la configuración
            console.error('❌ Error de configuración:', error.message);
        }
    }

    /**
     * Actualizar baseURL dinámicamente
     * @param {string} newBaseURL - Nueva URL base
     */
    setBaseURL(newBaseURL) {
        this.baseURL = newBaseURL;
        if (this.axiosInstance) {
            this.axiosInstance.defaults.baseURL = newBaseURL;
            console.log('✅ Base URL actualizada:', newBaseURL);
        }
    }

    /**
     * Actualizar headers dinámicamente
     * @param {object} headers - Headers a agregar/actualizar
     */
    setHeaders(headers) {
        if (this.axiosInstance) {
            Object.assign(this.axiosInstance.defaults.headers, headers);
            console.log('✅ Headers actualizados');
        }
    }

    /**
     * Obtener instancia de Axios para usos avanzados
     * @returns {AxiosInstance|null}
     */
    getAxiosInstance() {
        return this.axiosInstance;
    }
}

// ============================================
// INSTANCIA GLOBAL
// ============================================

// Crear instancia global del router
window.AppRouter = new Router();

// Alias para compatibilidad
window.apiClient = window.AppRouter;

// Log de confirmación
console.log('✅ Router (Axios) configurado y listo para usar');
console.log('📚 Ejemplos de uso:');
console.log('  - AppRouter.get("/routes/user/check_session.php")');
console.log('  - AppRouter.post("/routes/user/auth_user.php", { username, password })');
console.log('  - AppRouter.put("/routes/admin/update_user.php", { user_id, data })');
console.log('  - AppRouter.delete("/routes/admin/delete_user.php", { params: { id: 1 } })');
console.log('  - AppRouter.upload("/routes/admin/upload_file.php", formData)');

// ============================================
// LEGACY SUPPORT (jQuery AJAX)
// ============================================

/**
 * Wrapper para compatibilidad con código legacy que usa jQuery
 * @deprecated Usar AppRouter.get/post/etc en su lugar
 */
window.legacyAjax = {
    get: function (endpoint, callback, dataType = 'json') {
        console.warn('⚠️ legacyAjax está obsoleto. Usa AppRouter.get() en su lugar');
        return $.get(window.AppRouter.buildURL(endpoint), callback, dataType);
    },
    post: function (endpoint, data, callback, dataType = 'json') {
        console.warn('⚠️ legacyAjax está obsoleto. Usa AppRouter.post() en su lugar');
        return $.post(window.AppRouter.buildURL(endpoint), data, callback, dataType);
    }
};

