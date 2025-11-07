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
        hour12: false       // Formato 24 horas (por defecto)
    },

    // Idioma
    LOCALE: 'es-ES',

    // Intervalo de actualización (ms)
    UPDATE_INTERVAL: 1000,  // 1 segundo

    // Formato de hora preferido (12 o 24)
    HOUR_FORMAT: 24         // 24 horas por defecto
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
     * Obtener formato de hora desde localStorage
     * @private
     * @returns {boolean} true para AM/PM, false para 24h
     */
    getHourFormat() {
        const savedFormat = localStorage.getItem('widget_prefs_time_format');
        if (savedFormat === 'AM/PM') {
            return true; // hour12: true
        } else if (savedFormat === '24h') {
            return false; // hour12: false
        }
        // Default: 24h
        return false;
    }

    /**
     * Formatear fecha según preferencias del usuario
     * @private
     * @param {Date} date - Objeto Date
     * @returns {string} Fecha formateada
     */
    formatDateWithPreferences(date) {
        const savedFormat = localStorage.getItem('widget_prefs_date_format') || 'DD/MM/YYYY';

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();

        // Nombres de meses en español (abreviados)
        const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        const monthNamesEn = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthAbbr = monthNames[date.getMonth()];
        const monthAbbrEn = monthNamesEn[date.getMonth()];

        // Nombres de días en español (abreviados)
        const weekdayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const weekday = weekdayNames[date.getDay()];

        // Aplicar formato según preferencias
        switch (savedFormat) {
            case 'DD/MM/YYYY':
                return `${weekday}, ${day}/${month}/${year}`;
            case 'MM/DD/YYYY':
                return `${weekday}, ${month}/${day}/${year}`;
            case 'YYYY-MM-DD':
                return `${weekday}, ${year}-${month}-${day}`;
            case 'DD-MM-YYYY':
                return `${weekday}, ${day}-${month}-${year}`;
            case 'YYYY/MM/DD':
                return `${weekday}, ${year}/${month}/${day}`;
            case 'DD MMM YYYY':
                return `${weekday}, ${day} ${monthAbbr} ${year}`;
            case 'MMM DD, YYYY':
                return `${weekday}, ${monthAbbrEn} ${day}, ${year}`;
            default:
                return `${weekday}, ${day}/${month}/${year}`;
        }
    }

    /**
     * Actualizar fecha y hora actual
     * @private
     */
    updateDateTime() {
        const now = new Date();

        // Obtener formato de hora desde preferencias
        const useAmPm = this.getHourFormat();

        // Formatear fecha según preferencias del usuario
        const dateStr = this.formatDateWithPreferences(now);

        // Configurar formato de hora según preferencia
        const timeOptions = {
            ...this.config.TIME_OPTIONS,
            hour12: useAmPm  // true = AM/PM, false = 24h
        };

        // Formatear hora: 14:30:45 (24h) o 02:30:45 PM (12h)
        const timeStr = now.toLocaleTimeString(this.config.LOCALE, timeOptions);

        // Actualizar estado
        this.currentDateTime = {
            date: dateStr,
            time: timeStr,
            timestamp: now.getTime(),
            hour12: this.config.HOUR_FORMAT === 12
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

        // Configurar formato de hora según preferencia
        const timeOptions = {
            ...this.config.TIME_OPTIONS,
            hour12: this.config.HOUR_FORMAT === 12
        };

        return {
            date: dateObj.toLocaleDateString(this.config.LOCALE, this.config.DATE_OPTIONS),
            time: dateObj.toLocaleTimeString(this.config.LOCALE, timeOptions),
            timestamp: dateObj.getTime(),
            hour12: this.config.HOUR_FORMAT === 12
        };
    }

    /**
     * Cambiar formato de hora entre 12 y 24 horas
     * @param {number} format - 12 o 24
     */
    setHourFormat(format) {
        if (format !== 12 && format !== 24) {
            console.error('❌ Formato inválido. Use 12 o 24');
            return;
        }

        this.config.HOUR_FORMAT = format;
        console.log(`🕐 Formato de hora cambiado a ${format}h`);

        // Actualizar inmediatamente si está corriendo
        if (this.isRunning) {
            this.updateDateTime();
        }
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
console.log('  - ClockService.setHourFormat(12) // Cambiar a formato 12 horas');
console.log('  - ClockService.setHourFormat(24) // Cambiar a formato 24 horas');
console.log('  - getCurrentDateTime() // Obtener fecha/hora actual');
console.log('  - formatDateTime(new Date()) // Formatear fecha específica');
console.log('');
console.log('📡 Eventos disponibles:');
console.log('  - "clockUpdated" // Se dispara cada segundo con nueva fecha/hora');
console.log('    Ejemplo: window.addEventListener("clockUpdated", (e) => console.log(e.detail))');
console.log('');
console.log('⚙️ Configuración actual: Formato de hora ' + CLOCK_CONFIG.HOUR_FORMAT + 'h');
