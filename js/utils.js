/**
 * Utils.js - Funciones Utilitarias
 * HomeLab AR - Roepard Labs
 */

const Utils = {

    // ===================================
    // FORMATEO
    // ===================================

    /**
     * Formatea un número con separadores de miles
     */
    formatNumber: function (num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },

    /**
     * Formatea una fecha
     */
    formatDate: function (date, format = 'DD/MM/YYYY') {
        const d = new Date(date);
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();

        const formats = {
            'DD/MM/YYYY': `${day}/${month}/${year}`,
            'MM/DD/YYYY': `${month}/${day}/${year}`,
            'YYYY-MM-DD': `${year}-${month}-${day}`
        };

        return formats[format] || formats['DD/MM/YYYY'];
    },

    /**
     * Formatea bytes a tamaño legible
     */
    formatBytes: function (bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    },

    // ===================================
    // VALIDACIÓN
    // ===================================

    /**
     * Valida email
     */
    validateEmail: function (email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    /**
     * Valida contraseña fuerte
     */
    validatePassword: function (password) {
        // Mínimo 8 caracteres, una mayúscula, una minúscula, un número
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/;
        return re.test(password);
    },

    /**
     * Valida URL
     */
    validateURL: function (url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    },

    // ===================================
    // STRINGS
    // ===================================

    /**
     * Trunca texto con ellipsis
     */
    truncate: function (str, length = 100) {
        if (str.length <= length) return str;
        return str.substring(0, length) + '...';
    },

    /**
     * Capitaliza primera letra
     */
    capitalize: function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    },

    /**
     * Convierte a slug
     */
    slugify: function (str) {
        return str
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    },

    // ===================================
    // ARRAYS
    // ===================================

    /**
     * Elimina duplicados de array
     */
    unique: function (arr) {
        return [...new Set(arr)];
    },

    /**
     * Agrupa array por propiedad
     */
    groupBy: function (arr, key) {
        return arr.reduce((result, item) => {
            const group = item[key];
            if (!result[group]) {
                result[group] = [];
            }
            result[group].push(item);
            return result;
        }, {});
    },

    /**
     * Ordena array de objetos
     */
    sortBy: function (arr, key, order = 'asc') {
        return arr.sort((a, b) => {
            if (order === 'asc') {
                return a[key] > b[key] ? 1 : -1;
            } else {
                return a[key] < b[key] ? 1 : -1;
            }
        });
    },

    // ===================================
    // DOM
    // ===================================

    /**
     * Espera a que un elemento exista
     */
    waitForElement: function (selector, timeout = 5000) {
        return new Promise((resolve, reject) => {
            const element = document.querySelector(selector);

            if (element) {
                resolve(element);
                return;
            }

            const observer = new MutationObserver((mutations, obs) => {
                const element = document.querySelector(selector);
                if (element) {
                    obs.disconnect();
                    resolve(element);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            setTimeout(() => {
                observer.disconnect();
                reject(new Error(`Element ${selector} not found`));
            }, timeout);
        });
    },

    /**
     * Scroll suave a elemento
     */
    scrollTo: function (selector, offset = 0) {
        const element = document.querySelector(selector);
        if (element) {
            const top = element.offsetTop - offset;
            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
        }
    },

    // ===================================
    // STORAGE
    // ===================================

    /**
     * Guarda en localStorage con expiración
     */
    setStorage: function (key, value, expiresInMinutes = null) {
        const item = {
            value: value,
            expires: expiresInMinutes ? Date.now() + (expiresInMinutes * 60000) : null
        };
        localStorage.setItem(key, JSON.stringify(item));
    },

    /**
     * Obtiene de localStorage verificando expiración
     */
    getStorage: function (key) {
        const itemStr = localStorage.getItem(key);

        if (!itemStr) return null;

        try {
            const item = JSON.parse(itemStr);

            // Verificar expiración
            if (item.expires && Date.now() > item.expires) {
                localStorage.removeItem(key);
                return null;
            }

            return item.value;
        } catch {
            return itemStr;
        }
    },

    // ===================================
    // CLIPBOARD
    // ===================================

    /**
     * Copia texto al portapapeles
     */
    copyToClipboard: async function (text) {
        try {
            await navigator.clipboard.writeText(text);

            if (typeof Notyf !== 'undefined') {
                const notyf = new Notyf();
                notyf.success('Copiado al portapapeles');
            }

            return true;
        } catch (err) {
            console.error('Error al copiar:', err);
            return false;
        }
    },

    // ===================================
    // ASYNC
    // ===================================

    /**
     * Debounce - retrasa ejecución
     */
    debounce: function (func, wait = 300) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    /**
     * Throttle - limita frecuencia
     */
    throttle: function (func, limit = 300) {
        let inThrottle;
        return function (...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    /**
     * Sleep - espera async
     */
    sleep: function (ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },

    // ===================================
    // RANDOM
    // ===================================

    /**
     * Genera ID único
     */
    generateId: function (prefix = 'id') {
        return `${prefix}_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    },

    /**
     * Número aleatorio entre min y max
     */
    randomNumber: function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },

    /**
     * Selecciona elemento aleatorio de array
     */
    randomElement: function (arr) {
        return arr[Math.floor(Math.random() * arr.length)];
    },

    // ===================================
    // DEVICE DETECTION
    // ===================================

    /**
     * Detecta tipo de dispositivo
     */
    device: {
        isMobile: function () {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        },
        isTablet: function () {
            return /iPad|Android(?!.*Mobile)/i.test(navigator.userAgent);
        },
        isDesktop: function () {
            return !this.isMobile() && !this.isTablet();
        },
        isIOS: function () {
            return /iPhone|iPad|iPod/i.test(navigator.userAgent);
        },
        isAndroid: function () {
            return /Android/i.test(navigator.userAgent);
        }
    },

    /**
     * Detecta características del navegador
     */
    browser: {
        supportsWebGL: function () {
            try {
                const canvas = document.createElement('canvas');
                return !!(canvas.getContext('webgl') || canvas.getContext('experimental-webgl'));
            } catch {
                return false;
            }
        },
        supportsWebXR: function () {
            return 'xr' in navigator;
        },
        supportsWebRTC: function () {
            return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
        }
    }
};

// Hacer disponible globalmente
window.Utils = Utils;

console.log('✅ Utils.js cargado');
