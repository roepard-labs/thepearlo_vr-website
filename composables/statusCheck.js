/**
 * StatusCheck.js - Verificación de estado del backend
 * HomeLab VR - Roepard Labs
 * 
 * @description Verifica la conexión con el backend API
 * @requires AppRouter (debe estar cargado antes)
 */

(async function statusCheck() {
    console.log('🔍 Verificando estado del backend...');
    console.log('📡 Backend URL:', AppRouter.baseURL);

    try {
        // Intentar petición al backend
        const response = await AppRouter.get('/routes/web/status.php');
R
        console.log('✅ Backend conectado correctamente');
        console.log('📦 Respuesta:', response);

    } catch (error) {
        // Manejar error de conexión
        console.warn('⚠️ No se pudo conectar al backend');
        console.warn('📍 URL intentada:', `${AppRouter.baseURL}/routes/web/status.php`);

        if (error.code === 'ERR_NETWORK') {
            console.warn('💡 Soluciones posibles:');
            console.warn('   1. Verifica que el backend esté corriendo en:', AppRouter.baseURL);
            console.warn('   2. Verifica que la ruta /routes/web/status.php exista');
        }

        // No lanzar el error para no detener la carga de la página
        // throw error;
    }

    // Log de instancia de AppRouter para debugging
    console.log('🛠️ AppRouter instance:', AppRouter);
})();