/**
 * Router.js - Client-side routing and API configuration
 * HomeLab VR - Roepard Labs
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
        APP_NAME: 'Roepard Homelab (Fallback)'
    };
}

// ============================================
// API ROUTER
// ============================================

class Router {
    constructor() {
        this.baseURL = window.ENV_CONFIG.API_URL;
        this.appName = window.ENV_CONFIG.APP_NAME;
        
        // Log de configuración
        console.log('🚀 Router inicializado');
        console.log('📡 API URL:', this.baseURL);
        console.log('🏷️  App Name:', this.appName);
        console.log('🔐 Config source:', typeof window.ENV_CONFIG._generated !== 'undefined' ? 'Generated from .env' : 'Fallback');
    }

    /**
     * Construir URL completa para endpoint
     * @param {string} endpoint - Ruta del endpoint (ej: '/api/users')
     * @returns {string} URL completa
     */
    buildURL(endpoint) {
        return `${this.baseURL}${endpoint}`;
    }

    /**
     * Realizar petición GET
     * @param {string} endpoint - Ruta del endpoint
     * @returns {Promise} Promesa con la respuesta
     */
    async get(endpoint) {
        const url = this.buildURL(endpoint);
        console.log('GET:', url);
        
        try {
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error('Error en GET:', error);
            throw error;
        }
    }

    /**
     * Realizar petición POST
     * @param {string} endpoint - Ruta del endpoint
     * @param {object} data - Datos a enviar
     * @returns {Promise} Promesa con la respuesta
     */
    async post(endpoint, data) {
        const url = this.buildURL(endpoint);
        console.log('POST:', url, data);
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Error en POST:', error);
            throw error;
        }
    }
}

// ============================================
// INSTANCIA GLOBAL
// ============================================

// Crear instancia global del router
window.AppRouter = new Router();

// Log de confirmación
console.log('✅ Router configurado y listo para usar');
console.log('Ejemplo de uso: AppRouter.get("/api/users")');

