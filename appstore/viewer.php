<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Viewer - HomeLab AR</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        :root {
            --primary-color: #0088ff;
            --bg-color: #f8f9fa;
        }
        
        body {
            background: var(--bg-color);
            min-height: 100vh;
        }
        
        .app-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .app-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            z-index: 100;
        }
        
        .app-header .brand {
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .app-header .app-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }
        
        .app-frame-container {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        
        #appFrame {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            z-index: 50;
        }
        
        .loading-overlay.hidden {
            display: none;
        }
        
        .error-container {
            padding: 2rem;
            text-align: center;
        }
        
        .error-container i {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        
        .btn-action {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    
    <!-- App Container -->
    <div class="app-container">
        
        <!-- Header -->
        <div class="app-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    
                    <!-- Brand & Title -->
                    <div class="d-flex align-items-center gap-4">
                        <a href="/" class="brand">
                            <i class='bx bx-cube-alt bx-md'></i>
                            <span>HomeLab AR</span>
                        </a>
                        <div class="app-title" id="appTitle">
                            <span class="spinner-border spinner-border-sm me-2"></span>
                            Cargando...
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-action" onclick="reloadApp()" title="Recargar">
                            <i class='bx bx-refresh'></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-action" onclick="toggleFullscreen()" title="Pantalla completa">
                            <i class='bx bx-fullscreen'></i>
                        </button>
                        <a href="/appstore" class="btn btn-outline-primary btn-action">
                            <i class='bx bx-arrow-back me-1'></i>
                            Volver
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- App Frame Container -->
        <div class="app-frame-container">
            
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                <p class="text-muted">Cargando aplicación...</p>
            </div>
            
            <!-- Error Container -->
            <div class="error-container d-none" id="errorContainer">
                <i class='bx bx-error-circle'></i>
                <h3>Error al cargar la aplicación</h3>
                <p class="text-muted mb-3" id="errorMessage">No se pudo cargar la aplicación solicitada.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary btn-action" onclick="retryLoad()">
                        <i class='bx bx-refresh me-2'></i>
                        Reintentar
                    </button>
                    <a href="/appstore" class="btn btn-outline-secondary btn-action">
                        <i class='bx bx-arrow-back me-2'></i>
                        Volver al AppStore
                    </a>
                </div>
            </div>
            
            <!-- App Frame -->
            <iframe id="appFrame" class="d-none"></iframe>
            
        </div>
        
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ===================================
        // CONFIGURACIÓN
        // ===================================
        const appId = new URLSearchParams(window.location.search).get('id');
        const appFrame = document.getElementById('appFrame');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const errorContainer = document.getElementById('errorContainer');
        const errorMessage = document.getElementById('errorMessage');
        const appTitle = document.getElementById('appTitle');
        
        // ===================================
        // CARGAR APP
        // ===================================
        async function loadApp() {
            if (!appId) {
                showError('No se especificó una aplicación');
                return;
            }
            
            try {
                // Obtener datos de la app
                const response = await fetch(`/appstore/reader.php?action=get&id=${appId}`);
                const data = await response.json();
                
                if (!data.success) {
                    showError(data.error || 'Aplicación no encontrada');
                    return;
                }
                
                const app = data.app;
                
                // Actualizar título
                appTitle.innerHTML = `<i class='bx ${app.icon} me-2'></i>${app.name}`;
                document.title = `${app.name} - HomeLab AR`;
                
                // Cargar app en iframe
                appFrame.src = app.entry;
                
                // Evento de carga
                appFrame.onload = function() {
                    loadingOverlay.classList.add('hidden');
                    appFrame.classList.remove('d-none');
                    console.log('✅ App cargada:', app.name);
                };
                
                // Evento de error
                appFrame.onerror = function() {
                    showError('Error al cargar el contenido de la aplicación');
                };
                
            } catch (error) {
                console.error('❌ Error:', error);
                showError('Error al cargar los datos de la aplicación');
            }
        }
        
        // ===================================
        // FUNCIONES
        // ===================================
        
        function showError(message) {
            loadingOverlay.classList.add('hidden');
            errorMessage.textContent = message;
            errorContainer.classList.remove('d-none');
            appTitle.textContent = 'Error';
        }
        
        function reloadApp() {
            loadingOverlay.classList.remove('hidden');
            errorContainer.classList.add('d-none');
            appFrame.classList.add('d-none');
            appFrame.src = appFrame.src;
        }
        
        function retryLoad() {
            loadingOverlay.classList.remove('hidden');
            errorContainer.classList.add('d-none');
            loadApp();
        }
        
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }
        
        // ===================================
        // INICIALIZAR
        // ===================================
        loadApp();
        
        // Listener para mensajes del iframe (opcional)
        window.addEventListener('message', function(event) {
            // Aquí puedes manejar mensajes desde las apps
            console.log('📨 Mensaje de app:', event.data);
        });
    </script>
    
</body>
</html>
