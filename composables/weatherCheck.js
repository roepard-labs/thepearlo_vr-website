/**
 * WeatherCheck.js - OpenWeatherMap API Integration
 * HomeLab VR - Roepard Labs
 * 
 * @description Cliente para consultar datos meteorológicos usando OpenWeatherMap API
 * @version 1.0.0
 * @requires router.js (AppRouter con Axios)
 */

// ============================================
// CONFIGURACIÓN DE LA API
// ============================================

/**
 * Configuración de OpenWeatherMap API
 * @constant
 */
const WEATHER_CONFIG = {
    // ⚠️ API Key - En producción, mover a .env y generar con build:config
    API_KEY: '5f6eea57b7cbb427f5362ab9efe5bce3',

    // URL base de la API
    BASE_URL: 'https://api.openweathermap.org/data/2.5',

    // Ciudad por defecto
    DEFAULT_CITY: 'Manizales',
    DEFAULT_COUNTRY: 'CO',

    // Unidades de medida
    UNITS: {
        METRIC: 'metric',      // Celsius, m/s
        IMPERIAL: 'imperial',  // Fahrenheit, mph
        STANDARD: 'standard'   // Kelvin, m/s (default API)
    },

    // Idiomas disponibles
    LANGUAGES: {
        ES: 'es',  // Español
        EN: 'en',  // English
        FR: 'fr',  // Français
        DE: 'de',  // Deutsch
        PT: 'pt'   // Português
    },

    // Timeout para requests (ms)
    TIMEOUT: 10000,

    // Cache duration (ms) - 10 minutos
    CACHE_DURATION: 10 * 60 * 1000
};

// ============================================
// CLASE WEATHERSERVICE
// ============================================

/**
 * Servicio para consultar datos meteorológicos
 * @class
 */
class WeatherService {
    constructor() {
        this.config = WEATHER_CONFIG;
        this.cache = new Map(); // Cache de consultas

        console.log('🌦️ WeatherService inicializado');
        console.log('📍 Ciudad por defecto:', `${this.config.DEFAULT_CITY}, ${this.config.DEFAULT_COUNTRY}`);
    }

    /**
     * Verificar si AppRouter está disponible
     * @private
     * @returns {boolean}
     */
    isRouterReady() {
        if (typeof window.AppRouter === 'undefined') {
            console.error('❌ AppRouter no está disponible. Asegúrate de cargar router.js antes de weatherCheck.js');
            return false;
        }
        return true;
    }

    /**
     * Construir URL para consulta de clima actual
     * @private
     * @param {string} city - Nombre de la ciudad
     * @param {string} country - Código de país (ISO 3166)
     * @param {string} units - Unidades de medida
     * @param {string} lang - Idioma de respuesta
     * @returns {string} URL completa
     */
    buildWeatherURL(city, country = '', units = 'metric', lang = 'es') {
        const location = country ? `${city},${country}` : city;
        const params = new URLSearchParams({
            q: location,
            appid: this.config.API_KEY,
            units: units,
            lang: lang
        });

        return `${this.config.BASE_URL}/weather?${params.toString()}`;
    }

    /**
     * Construir clave de cache
     * @private
     * @param {string} city
     * @param {string} country
     * @param {string} units
     * @returns {string}
     */
    getCacheKey(city, country, units) {
        return `${city}-${country}-${units}`.toLowerCase();
    }

    /**
     * Obtener datos del cache si están disponibles y válidos
     * @private
     * @param {string} cacheKey
     * @returns {object|null}
     */
    getCachedData(cacheKey) {
        const cached = this.cache.get(cacheKey);

        if (!cached) return null;

        const now = Date.now();
        if (now - cached.timestamp > this.config.CACHE_DURATION) {
            // Cache expirado
            this.cache.delete(cacheKey);
            return null;
        }

        console.log('📦 Datos del clima obtenidos del cache');
        return cached.data;
    }

    /**
     * Guardar datos en cache
     * @private
     * @param {string} cacheKey
     * @param {object} data
     */
    setCachedData(cacheKey, data) {
        this.cache.set(cacheKey, {
            data: data,
            timestamp: Date.now()
        });
    }

    /**
     * Obtener unidades de temperatura desde localStorage
     * @private
     * @returns {string} 'metric' (C), 'imperial' (F), o 'standard' (K)
     */
    getTempUnits() {
        const savedUnit = localStorage.getItem('widget_prefs_temp_unit');
        if (savedUnit === 'C') {
            return 'metric';
        } else if (savedUnit === 'F') {
            return 'imperial';
        } else if (savedUnit === 'K') {
            return 'standard';
        }
        // Default: Celsius
        return 'metric';
    }

    /**
     * Obtener clima actual de una ciudad
     * @param {object} options - Opciones de consulta
     * @param {string} options.city - Nombre de la ciudad
     * @param {string} options.country - Código de país (opcional)
     * @param {string} options.units - Unidades (metric|imperial|standard) - si no se especifica, lee de localStorage
     * @param {string} options.lang - Idioma (es|en|fr|de|pt)
     * @param {boolean} options.useCache - Usar cache (default: true)
     * @returns {Promise<object>} Datos meteorológicos procesados
     */
    async getCurrentWeather(options = {}) {
        // Valores por defecto (unidades desde localStorage)
        const {
            city = this.config.DEFAULT_CITY,
            country = this.config.DEFAULT_COUNTRY,
            units = this.getTempUnits(),  // Lee preferencias del usuario
            lang = 'es',
            useCache = true
        } = options;

        if (!this.isRouterReady()) {
            return Promise.reject('AppRouter no disponible');
        }

        // Verificar cache
        const cacheKey = this.getCacheKey(city, country, units);
        if (useCache) {
            const cachedData = this.getCachedData(cacheKey);
            if (cachedData) return cachedData;
        }

        // Construir URL
        const url = this.buildWeatherURL(city, country, units, lang);

        console.log(`🌦️ Consultando clima para: ${city}, ${country}`);

        try {
            // Usar fetch directo en lugar de AppRouter para APIs externas
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                timeout: this.config.TIMEOUT
            });

            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status} - ${response.statusText}`);
            }

            const rawData = await response.json();
            console.log('📥 Datos recibidos de OpenWeatherMap API');

            // Procesar datos
            const processedData = this.processWeatherData(rawData, units);

            // Guardar en cache
            if (useCache) {
                this.setCachedData(cacheKey, processedData);
            }

            return processedData;

        } catch (error) {
            console.error('❌ Error al consultar clima:', error.message);
            throw error;
        }
    }

    /**
     * Procesar datos crudos de la API a formato amigable
     * @private
     * @param {object} rawData - Datos crudos de la API
     * @param {string} units - Unidades usadas
     * @returns {object} Datos procesados
     */
    processWeatherData(rawData, units) {
        // Determinar símbolos según unidades
        const tempSymbol = units === 'metric' ? '°C' : units === 'imperial' ? '°F' : 'K';
        const speedSymbol = units === 'imperial' ? 'mph' : 'm/s';

        return {
            // Ubicación
            location: {
                city: rawData.name,
                country: rawData.sys.country,
                coordinates: {
                    lat: rawData.coord.lat,
                    lon: rawData.coord.lon
                },
                timezone: rawData.timezone // Offset en segundos
            },

            // Clima actual
            weather: {
                main: rawData.weather[0].main,
                description: rawData.weather[0].description,
                icon: rawData.weather[0].icon,
                iconURL: `https://openweathermap.org/img/wn/${rawData.weather[0].icon}@2x.png`,
                id: rawData.weather[0].id
            },

            // Temperatura
            temperature: {
                current: rawData.main.temp,
                feelsLike: rawData.main.feels_like,
                min: rawData.main.temp_min,
                max: rawData.main.temp_max,
                unit: tempSymbol
            },

            // Atmósfera
            atmosphere: {
                pressure: rawData.main.pressure, // hPa
                humidity: rawData.main.humidity, // %
                visibility: rawData.visibility, // metros
                seaLevel: rawData.main.sea_level || rawData.main.pressure,
                groundLevel: rawData.main.grnd_level || rawData.main.pressure
            },

            // Viento
            wind: {
                speed: rawData.wind.speed,
                direction: rawData.wind.deg, // grados (0-360)
                directionText: this.getWindDirection(rawData.wind.deg),
                gust: rawData.wind.gust || 0,
                unit: speedSymbol
            },

            // Nubes
            clouds: {
                all: rawData.clouds.all // % de cobertura
            },

            // Lluvia (si existe)
            rain: rawData.rain ? {
                '1h': rawData.rain['1h'] || 0, // mm última hora
                '3h': rawData.rain['3h'] || 0  // mm últimas 3 horas
            } : null,

            // Nieve (si existe)
            snow: rawData.snow ? {
                '1h': rawData.snow['1h'] || 0,
                '3h': rawData.snow['3h'] || 0
            } : null,

            // Sol
            sun: {
                sunrise: new Date(rawData.sys.sunrise * 1000),
                sunset: new Date(rawData.sys.sunset * 1000),
                sunriseTime: this.formatTime(rawData.sys.sunrise),
                sunsetTime: this.formatTime(rawData.sys.sunset)
            },

            // Metadata
            metadata: {
                timestamp: new Date(rawData.dt * 1000),
                timestampUnix: rawData.dt,
                base: rawData.base
            },

            // Datos originales (por si se necesitan)
            _raw: rawData
        };
    }

    /**
     * Convertir grados de viento a dirección cardinal
     * @private
     * @param {number} degrees - Grados (0-360)
     * @returns {string} Dirección cardinal
     */
    getWindDirection(degrees) {
        const directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
        const index = Math.round(degrees / 45) % 8;
        return directions[index];
    }

    /**
     * Formatear timestamp Unix a hora legible
     * @private
     * @param {number} timestamp - Unix timestamp
     * @returns {string} Hora en formato HH:MM
     */
    formatTime(timestamp) {
        const date = new Date(timestamp * 1000);
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    /**
     * Limpiar cache
     */
    clearCache() {
        this.cache.clear();
        console.log('🗑️ Cache del clima limpiado');
    }

    /**
     * Obtener clima de múltiples ciudades en paralelo
     * @param {Array<object>} cities - Array de objetos {city, country}
     * @param {object} commonOptions - Opciones comunes (units, lang)
     * @returns {Promise<Array>} Array de datos meteorológicos
     */
    async getMultipleWeather(cities, commonOptions = {}) {
        const promises = cities.map(location =>
            this.getCurrentWeather({
                ...commonOptions,
                city: location.city,
                country: location.country
            })
        );

        try {
            return await Promise.all(promises);
        } catch (error) {
            console.error('❌ Error al obtener clima de múltiples ciudades:', error);
            throw error;
        }
    }
}

// ============================================
// INSTANCIA GLOBAL
// ============================================

// Crear instancia global del servicio
window.WeatherService = new WeatherService();

// ============================================
// FUNCIONES DE UTILIDAD
// ============================================

/**
 * Helper rápido para obtener clima de ciudad por defecto (Manizales)
 * @returns {Promise<object>}
 */
window.getDefaultWeather = async function () {
    return await window.WeatherService.getCurrentWeather();
};

/**
 * Helper rápido para obtener clima de cualquier ciudad
 * @param {string} city - Nombre de la ciudad
 * @param {string} country - Código de país (opcional)
 * @returns {Promise<object>}
 */
window.getWeather = async function (city, country = '') {
    return await window.WeatherService.getCurrentWeather({ city, country });
};

// Log de confirmación
console.log('✅ WeatherService configurado y listo para usar');
console.log('📚 Ejemplos de uso:');
console.log('  - await getDefaultWeather() // Manizales, CO');
console.log('  - await getWeather("Bogotá", "CO")');
console.log('  - await WeatherService.getCurrentWeather({ city: "Paris", country: "FR", units: "metric" })');
console.log('  - await WeatherService.getMultipleWeather([{city: "Manizales", country: "CO"}, {city: "Bogotá", country: "CO"}])');
