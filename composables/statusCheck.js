/**
 * StatusCheck.js - Verificación de estado del backend
 * HomeLab VR - Roepard Labs
 * 
 * @description Verifica la conexión con el backend API
 * @requires AppRouter (debe estar cargado antes)
 */

// Estado global del backend
window.BackendStatus = {
    isConnected: false,
    lastCheck: null,
    message: 'Verificando...',
    checking: true
};

// Disparar evento inmediatamente con estado inicial
setTimeout(function () {
    window.dispatchEvent(new CustomEvent('backendStatusChanged', {
        detail: window.BackendStatus
    }));
}, 0);

/**
 * Esperar a que Axios esté inicializado
 */
function waitForAxios() {
    return new Promise((resolve) => {
        if (AppRouter && AppRouter.axiosInstance) {
            console.log('✅ Axios ya está listo');
            resolve();
        } else {
            console.log('⏳ Esperando a que Axios se inicialice...');
            const checkInterval = setInterval(() => {
                if (AppRouter && AppRouter.axiosInstance) {
                    clearInterval(checkInterval);
                    console.log('✅ Axios inicializado, continuando...');
                    resolve();
                }
            }, 100); // Verificar cada 100ms
        }
    });
}

(async function statusCheck() {
    // Esperar a que Axios esté listo antes de continuar
    await waitForAxios();

    console.log('🔍 Verificando estado del backend...');
    console.log('📡 Backend URL:', AppRouter.baseURL);

    try {
        // Intentar petición al backend
        const response = await AppRouter.get('/routes/web/status.php');

        // Actualizar estado global
        window.BackendStatus.isConnected = true;
        window.BackendStatus.lastCheck = new Date();
        window.BackendStatus.message = 'Backend conectado';
        window.BackendStatus.checking = false;

        console.log('✅ Backend conectado correctamente');
        console.log('📦 Respuesta:', response);

        // Disparar evento para actualizar UI
        window.dispatchEvent(new CustomEvent('backendStatusChanged', {
            detail: window.BackendStatus
        }));

    } catch (error) {
        // Actualizar estado global
        window.BackendStatus.isConnected = false;
        window.BackendStatus.lastCheck = new Date();
        window.BackendStatus.message = 'Backend desconectado';
        window.BackendStatus.checking = false;

        // Manejar error de conexión
        console.warn('⚠️ No se pudo conectar al backend');
        console.warn('📍 URL intentada:', `${AppRouter.baseURL}/routes/web/status.php`);

        if (error.code === 'ERR_NETWORK') {
            console.warn('💡 Soluciones posibles:');
            console.warn('   1. Verifica que el backend esté corriendo en:', AppRouter.baseURL);
            console.warn('   2. Verifica que la ruta /routes/web/status.php exista');
            window.BackendStatus.message = 'Error de red';
        }

        // Disparar evento para actualizar UI
        window.dispatchEvent(new CustomEvent('backendStatusChanged', {
            detail: window.BackendStatus
        }));

        // No lanzar el error para no detener la carga de la página
        // throw error;
    }

    // Log de instancia de AppRouter para debugging
    console.log('🛠️ AppRouter instance:', AppRouter);
})();

// Función para verificar el estado periódicamente (cada 30 segundos)
setInterval(async function () {
    // Verificar que Axios esté listo antes de hacer la petición
    if (!AppRouter || !AppRouter.axiosInstance) {
        console.warn('⏳ Axios no disponible, saltando verificación...');
        return;
    }

    try {
        const response = await AppRouter.get('/routes/web/status.php');

        if (!window.BackendStatus.isConnected) {
            window.BackendStatus.isConnected = true;
            window.BackendStatus.message = 'Backend reconectado';
            window.dispatchEvent(new CustomEvent('backendStatusChanged', {
                detail: window.BackendStatus
            }));
        }

        window.BackendStatus.lastCheck = new Date();
    } catch (error) {
        if (window.BackendStatus.isConnected) {
            window.BackendStatus.isConnected = false;
            window.BackendStatus.message = 'Backend desconectado';
            window.dispatchEvent(new CustomEvent('backendStatusChanged', {
                detail: window.BackendStatus
            }));
        }

        window.BackendStatus.lastCheck = new Date();
    }
}, 120000); // 2 minutos