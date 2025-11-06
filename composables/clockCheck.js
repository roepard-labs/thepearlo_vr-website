/**
 * ClockCheck.js - Servicio de Reloj en Tiempo Real
 * HomeLab VR - Roepard Labs
 * 
 * @description Servicio para mostrar fecha y hora en tiempo real con formato español
 * @version 1.0.0
 */

// ============================================
// CONFIGURACIÓN DEL SERVICIO DE RELOJ
// ============================================

/**
 * Configuración del servicio de reloj
 * @constant
 */
const CLOCK_CONFIG = {
    // Formato de fecha
    DATE_OPTIONS: {
        weekday: 'short',   // Lun, Mar, Mié
        day: 'numeric',     // 1, 2, 3
        month: 'short',     // Ene, Feb, Mar
        year: 'numeric'     // 2025
    },

    // Formato de hora
    TIME_OPTIONS: {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false       // Formato 24 horas
    },

    // Idioma
    LOCALE: 'es-ES',

    // Intervalo de actualización (ms)
    UPDATE_INTERVAL: 1000  // 1 segundo
};

// ============================================
// CLASE CLOCKSERVICE
// ============================================

/**
 * Servicio para gestionar la visualización de fecha y hora
 * @class
 */
class ClockService {
    constructor() {
        this.config = CLOCK_CONFIG;
        this.updateInterval = null;
        this.isRunning = false;

        // Estado actual
        this.currentDateTime = {
            date: '',
            time: '',
            timestamp: null
        };

        console.log('🕐 ClockService inicializado');
    }

    /**
     * Actualizar fecha y hora actual
     * @private
     */
    updateDateTime() {
        const now = new Date();

        // Formatear fecha: Lun, 3 Nov 2025
        const dateStr = now.toLocaleDateString(this.config.LOCALE, this.config.DATE_OPTIONS);

        // Formatear hora: 14:30:45
        const timeStr = now.toLocaleTimeString(this.config.LOCALE, this.config.TIME_OPTIONS);

        // Actualizar estado
        this.currentDateTime = {
            date: dateStr,
            time: timeStr,
            timestamp: now.getTime()
        };

        // Disparar evento personalizado para que los componentes lo escuchen
        window.dispatchEvent(new CustomEvent('clockUpdated', {
            detail: this.currentDateTime
        }));

        return this.currentDateTime;
    }

    /**
     * Iniciar actualización automática del reloj
     * @returns {object} Datos actuales de fecha/hora
     */
    start() {
        if (this.isRunning) {
            console.warn('⚠️ ClockService ya está en ejecución');
            return this.currentDateTime;
        }

        console.log('▶️ ClockService iniciado');
        this.isRunning = true;

        // Primera actualización inmediata
        this.updateDateTime();

        // Actualizar cada segundo
        this.updateInterval = setInterval(() => {
            this.updateDateTime();
        }, this.config.UPDATE_INTERVAL);

        return this.currentDateTime;
    }

    /**
     * Detener actualización automática del reloj
     */
    stop() {
        if (!this.isRunning) {
            console.warn('⚠️ ClockService no está en ejecución');
            return;
        }

        console.log('⏸️ ClockService detenido');
        this.isRunning = false;

        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }

    /**
     * Obtener fecha y hora actual sin iniciar actualización automática
     * @returns {object} Datos actuales de fecha/hora
     */
    getCurrentDateTime() {
        return this.updateDateTime();
    }

    /**
     * Formatear una fecha específica
     * @param {Date|number|string} date - Fecha a formatear
     * @returns {object} Fecha y hora formateadas
     */
    formatDate(date) {
        const dateObj = new Date(date);

        return {
            date: dateObj.toLocaleDateString(this.config.LOCALE, this.config.DATE_OPTIONS),
            time: dateObj.toLocaleTimeString(this.config.LOCALE, this.config.TIME_OPTIONS),
            timestamp: dateObj.getTime()
        };
    }

    /**
     * Cambiar configuración del reloj
     * @param {object} newConfig - Nueva configuración
     */
    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        console.log('⚙️ Configuración actualizada:', this.config);

        // Si está corriendo, actualizar inmediatamente con nueva configuración
        if (this.isRunning) {
            this.updateDateTime();
        }
    }

    /**
     * Obtener estado del servicio
     * @returns {object} Estado actual
     */
    getStatus() {
        return {
            isRunning: this.isRunning,
            currentDateTime: this.currentDateTime,
            config: this.config
        };
    }
}

// ============================================
// INSTANCIA GLOBAL
// ============================================

// Crear instancia global del servicio
window.ClockService = new ClockService();

// ============================================
// AUTO-INICIO (Opcional)
// ============================================

// Iniciar automáticamente cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    console.log('🕐 Iniciando ClockService automáticamente...');
    window.ClockService.start();
});

// ============================================
// FUNCIONES DE UTILIDAD
// ============================================

/**
 * Helper rápido para obtener fecha y hora actual
 * @returns {object} Datos actuales de fecha/hora
 */
window.getCurrentDateTime = function () {
    return window.ClockService.getCurrentDateTime();
};

/**
 * Helper para formatear fecha específica
 * @param {Date|number|string} date - Fecha a formatear
 * @returns {object} Fecha y hora formateadas
 */
window.formatDateTime = function (date) {
    return window.ClockService.formatDate(date);
};

// Log de confirmación
console.log('✅ ClockService configurado y listo para usar');
console.log('📚 Ejemplos de uso:');
console.log('  - ClockService.start() // Iniciar actualización automática');
console.log('  - ClockService.stop() // Detener actualización');
console.log('  - getCurrentDateTime() // Obtener fecha/hora actual');
console.log('  - formatDateTime(new Date()) // Formatear fecha específica');
console.log('');
console.log('📡 Eventos disponibles:');
console.log('  - "clockUpdated" // Se dispara cada segundo con nueva fecha/hora');
console.log('    Ejemplo: window.addEventListener("clockUpdated", (e) => console.log(e.detail))');
