<?php
/**
 * Componente: Footer
 * Footer del sitio
 * HomeLab AR - Roepard Labs
 */
?>

<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <!-- Columna 1: Sobre nosotros -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">
                    <i class="bx bx-cube-alt text-primary"></i> HomeLab AR
                </h5>
                <p class="text-white-50">
                    Plataforma de realidad aumentada para gestión de infraestructura homelab.
                    Proyecto piloto para la UAM Manizales.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="https://github.com/roepard-labs" target="_blank" rel="noopener noreferrer"
                        class="btn btn-outline-light btn-sm" title="GitHub">
                        <i class="bx bxl-github"></i>
                    </a>
                </div>
            </div>

            <!-- Columna 2: Enlaces rápidos -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Enlaces</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/" class="text-white-50 text-decoration-none">Inicio</a>
                    </li>
                    <li class="mb-2">
                        <a href="#features" class="text-white-50 text-decoration-none">Características</a>
                    </li>
                    <li class="mb-2">
                        <a href="#about" class="text-white-50 text-decoration-none">Acerca de</a>
                    </li>
                    <li class="mb-2">
                        <a href="/homelab" class="text-white-50 text-decoration-none">VR/AR</a>
                    </li>
                </ul>
            </div>

            <!-- Columna 3: Recursos -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Recursos</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="https://docs.roepard.online" target="_blank" rel="noopener noreferrer"
                            class="text-white-50 text-decoration-none">Documentación</a>
                    </li>
                    <li class="mb-2">
                        <a href="https://api.roepard.online" target="_blank" rel="noopener noreferrer"
                            class="text-white-50 text-decoration-none">API</a>
                    </li>
                    <li class="mb-2">
                        <a href="https://appstore.roepard.online" target="_blank" rel="noopener noreferrer"
                            class="text-white-50 text-decoration-none">AppStore</a>
                    </li>
                </ul>
            </div>

            <!-- Columna 4: Legal -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/privacy" class="text-white-50 text-decoration-none">Privacidad</a>
                    </li>
                    <li class="mb-2">
                        <a href="/terms" class="text-white-50 text-decoration-none">Términos</a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <!-- Copyright -->
        <div class="row">
            <div class="col-md-4 text-center text-md-start">
                <p class="text-white-50 small mb-0">
                    © <?php echo date('Y'); ?> HomeLab AR - Roepard Labs. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <!-- Backend Status Indicator -->
                <div id="backendStatus" class="d-inline-flex align-items-center gap-2">
                    <span class="text-white-50 small">Estado:</span>
                    <span id="statusIndicator" class="d-inline-flex align-items-center gap-1">
                        <span class="status-dot status-checking"></span>
                        <span class="status-text small">Verificando...</span>
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <p class="text-white-50 small mb-0">
                    Hecho con <i class="bx bx-heart text-danger"></i> para la UAM
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer a:hover {
        color: var(--color-primary) !important;
    }

    footer .btn-outline-light:hover {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }

    /* Backend Status Indicator */
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 8px currentColor;
        animation: pulse 2s ease-in-out infinite;
    }

    .status-dot.status-connected {
        background-color: #00ff88;
        box-shadow: 0 0 8px #00ff88;
    }

    .status-dot.status-disconnected {
        background-color: #ff4444;
        box-shadow: 0 0 8px #ff4444;
    }

    .status-dot.status-checking {
        background-color: #ffaa00;
        box-shadow: 0 0 8px #ffaa00;
    }

    .status-text {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    #backendStatus {
        cursor: pointer;
        padding: 4px 12px;
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    #backendStatus:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

<script>
    // Actualizar indicador de estado del backend
    function updateBackendStatusIndicator(status) {
        const indicator = document.getElementById('statusIndicator');
        if (!indicator) return;

        const dot = indicator.querySelector('.status-dot');
        const text = indicator.querySelector('.status-text');

        if (status.checking) {
            dot.className = 'status-dot status-checking';
            text.textContent = 'Verificando...';
            text.style.color = '#ffaa00';
        } else if (status.isConnected) {
            dot.className = 'status-dot status-connected';
            text.textContent = 'Conectado';
            text.style.color = '#00ff88';
        } else {
            dot.className = 'status-dot status-disconnected';
            text.textContent = 'Desconectado';
            text.style.color = '#ff4444';
        }

        // Agregar título con información detallada
        const backendStatus = document.getElementById('backendStatus');
        if (backendStatus && status.lastCheck) {
            const lastCheckTime = new Date(status.lastCheck).toLocaleTimeString('es-MX');
            backendStatus.title = `${status.message}\nÚltima verificación: ${lastCheckTime}`;
        }
    }

    // Escuchar cambios en el estado del backend
    window.addEventListener('backendStatusChanged', function (event) {
        console.log('📊 Estado del backend actualizado:', event.detail);
        updateBackendStatusIndicator(event.detail);
    });

    // Inicializar el indicador
    document.addEventListener('DOMContentLoaded', function () {
        // Si BackendStatus ya existe, actualizar inmediatamente
        if (window.BackendStatus) {
            console.log('🔄 Actualizando indicador con estado actual:', window.BackendStatus);
            updateBackendStatusIndicator(window.BackendStatus);
        } else {
            // Si no existe aún, mostrar estado de verificación
            console.log('⏳ BackendStatus no disponible aún, mostrando estado inicial');
            updateBackendStatusIndicator({
                checking: true,
                isConnected: false,
                message: 'Verificando...',
                lastCheck: null
            });
        }

        // Click en el indicador para mostrar información
        const backendStatus = document.getElementById('backendStatus');
        if (backendStatus) {
            backendStatus.addEventListener('click', function () {
                if (!window.BackendStatus) return;

                const status = window.BackendStatus;
                const statusIcon = status.isConnected ? 'success' : 'error';
                const statusColor = status.isConnected ? '#00ff88' : '#ff4444';

                Swal.fire({
                    title: status.isConnected ? '✅ Backend Conectado' : '❌ Backend Desconectado',
                    html: `
                    <div style="text-align: left;">
                        <p><strong>Estado:</strong> ${status.message}</p>
                        <p><strong>URL:</strong> ${AppRouter.baseURL}</p>
                        <p><strong>Última verificación:</strong> ${status.lastCheck ? new Date(status.lastCheck).toLocaleString('es-MX') : 'N/A'}</p>
                    </div>
                `,
                    icon: statusIcon,
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: statusColor
                });
            });
        }
    });
</script>