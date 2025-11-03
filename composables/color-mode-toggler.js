/*!
 * Color Mode Toggler for Bootstrap 5.3+
 * HomeLab VR - Roepard Labs
 * Soporte para light/dark mode con localStorage
 */

(function() {
    'use strict';

    // ============================================
    // FUNCIONES CORE
    // ============================================

    /**
     * Obtener tema preferido del usuario
     * Prioridad: localStorage > preferencia del sistema > default (dark)
     */
    const getPreferredTheme = () => {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme) {
            return storedTheme;
        }
        // Detectar preferencia del sistema
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    };

    /**
     * Aplicar tema al documento
     * @param {string} theme - 'light' o 'dark'
     */
    const setTheme = (theme) => {
        document.documentElement.setAttribute('data-bs-theme', theme);
        
        // Actualizar estado del toggle si existe
        updateToggleUI(theme);
        
        // Emitir evento personalizado para otros componentes
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme } 
        }));
    };

    /**
     * Guardar tema en localStorage
     * @param {string} theme - 'light' o 'dark'
     */
    const storeTheme = (theme) => {
        localStorage.setItem('theme', theme);
    };

    /**
     * Actualizar UI del toggle según tema activo
     * @param {string} theme - 'light' o 'dark'
     */
    const updateToggleUI = (theme) => {
        // Toggle switch
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.checked = theme === 'dark';
        }

        // Botones de selección (si existen)
        document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
            const btnTheme = btn.getAttribute('data-bs-theme-value');
            if (btnTheme === theme) {
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-pressed', 'false');
            }
        });

        // Actualizar iconos si existen
        const themeIcon = document.getElementById('theme-icon');
        if (themeIcon) {
            themeIcon.className = theme === 'dark' 
                ? 'bx bx-moon text-warning' 
                : 'bx bx-sun text-warning';
        }
    };

    // ============================================
    // INICIALIZACIÓN
    // ============================================

    // Aplicar tema inmediatamente (antes de DOMContentLoaded)
    setTheme(getPreferredTheme());

    // Escuchar cambios en la preferencia del sistema
    window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', (e) => {
            const storedTheme = localStorage.getItem('theme');
            // Solo cambiar si el usuario no tiene preferencia guardada
            if (!storedTheme) {
                const newTheme = e.matches ? 'dark' : 'light';
                setTheme(newTheme);
            }
        });

    // ============================================
    // EVENT LISTENERS
    // ============================================

    window.addEventListener('DOMContentLoaded', () => {
        // Toggle Switch
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.checked = getPreferredTheme() === 'dark';
            
            darkModeToggle.addEventListener('change', () => {
                const newTheme = darkModeToggle.checked ? 'dark' : 'light';
                storeTheme(newTheme);
                setTheme(newTheme);
                
                // Notificación opcional (si Notyf está cargado)
                if (window.notyf) {
                    const message = newTheme === 'dark' 
                        ? '🌙 Modo oscuro activado' 
                        : '☀️ Modo claro activado';
                    window.notyf.success(message);
                }
            });
        }

        // Botones de selección de tema
        document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
            btn.addEventListener('click', () => {
                const theme = btn.getAttribute('data-bs-theme-value');
                storeTheme(theme);
                setTheme(theme);
            });
        });

        // Mostrar tema actual al cargar
        console.log(`🎨 Tema activo: ${getPreferredTheme()}`);
    });

    // ============================================
    // API PÚBLICA
    // ============================================

    // Exponer funciones globalmente para uso externo
    window.ThemeManager = {
        getTheme: getPreferredTheme,
        setTheme: (theme) => {
            storeTheme(theme);
            setTheme(theme);
        },
        toggleTheme: () => {
            const currentTheme = getPreferredTheme();
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            storeTheme(newTheme);
            setTheme(newTheme);
            return newTheme;
        }
    };

})();
