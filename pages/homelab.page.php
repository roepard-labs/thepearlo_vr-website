<?php
/**
 * Página: HomeLab VR - ThePearlOS
 * Sistema operativo virtual para experiencias VR/AR
 * HomeLab AR - Roepard Labs
 */
?>

<div class="homelab-page">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="homelab-header p-4 rounded" data-aos="fade-down">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="homelab-logo">
                            <i class="bx bx-glasses" style="font-size: 3rem; color: var(--bs-primary);"></i>
                        </div>
                        <div>
                            <h2 class="mb-1 fw-bold">
                                <span class="gradient-text">ThePearlOS</span>
                            </h2>
                            <p class="text-muted mb-0">Sistema Operativo Virtual - HomeLab VR</p>
                        </div>
                    </div>
                    <div class="homelab-version">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="bx bx-info-circle me-1"></i>
                            v1.0.0-beta
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Stats -->
    <div class="row g-4 mb-4">
        <!-- Total Apps -->
        <div class="col-12 col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card-os h-100 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-os bg-gradient-1">
                        <i class="bx bx-grid-alt"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small">Apps</p>
                        <h3 class="mb-0 fw-bold" id="totalApps">
                            <span class="spinner-border spinner-border-sm"></span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="col-12 col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card-os h-100 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-os bg-gradient-2">
                        <i class="bx bx-user"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small">Usuarios Activos</p>
                        <h3 class="mb-0 fw-bold" id="activeUsers">
                            <span class="spinner-border spinner-border-sm"></span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-12 col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card-os h-100 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-os bg-gradient-3">
                        <i class="bx bx-check-shield"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small">Status del Sistema</p>
                        <h5 class="mb-0 fw-bold text-success" id="systemStatus">
                            <i class="bx bx-check-circle"></i> Operativo
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uptime -->
        <div class="col-12 col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-card-os h-100 p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-os bg-gradient-4">
                        <i class="bx bx-time"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small">Uptime</p>
                        <h5 class="mb-0 fw-bold" id="systemUptime">99.9%</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">

        <!-- Left Column: Your Session -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100" data-aos="fade-right">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bx bx-user-circle me-2 text-primary"></i>
                        Tu Sesión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">

                        <!-- User Profile Picture + Info -->
                        <div class="col-12 col-lg-6">
                            <div class="d-flex gap-4 align-items-start">
                                <!-- Profile Picture -->
                                <div class="profile-picture-wrapper">
                                    <div class="profile-picture" id="userProfilePicture">
                                        <img src="/assets/icons/user-default.png" alt="Foto de perfil"
                                            class="rounded-circle"
                                            style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--bs-primary); box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.3);">
                                    </div>
                                </div>

                                <!-- User Info -->
                                <div class="session-info flex-grow-1">
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Nombre</label>
                                        <p class="mb-0 fw-semibold" id="sessionName">Cargando...</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Rol</label>
                                        <p class="mb-0" id="sessionRole">
                                            <span class="badge bg-primary">Cargando...</span>
                                        </p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="text-muted small mb-1">Usuario</label>
                                        <p class="mb-0 text-muted" id="sessionUsername">@usuario</p>
                                    </div>
                                    <div class="info-item">
                                        <label class="text-muted small mb-1">Email</label>
                                        <p class="mb-0 text-muted" id="sessionEmail">email@example.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Experiencia VR Section -->
                        <div class="col-12 col-lg-6">
                            <div
                                class="enter-homelab-section h-100 d-flex flex-column justify-content-center align-items-center text-center p-4">
                                <div class="homelab-icon-large mb-3" id="homelabIcon">
                                    <i class="bx bx-glasses"></i>
                                </div>
                                <h5 class="mb-3 fw-bold">Experiencia VR</h5>
                                <p class="text-muted mb-4">Accede al entorno de realidad virtual inmersivo</p>
                                <a href="/homelab" class="btn btn-primary btn-lg px-4 py-3 enter-homelab-btn"
                                    id="enterHomelabBtn">
                                    <i class="bx bx-right-arrow-circle me-2"></i>
                                    Entrar a HomeLab
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Help & Info -->
        <div class="col-12 col-xl-4">

            <!-- Help & Recommendations -->
            <div class="card border-0 shadow-sm mb-4" data-aos="fade-left" data-aos-delay="100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bx bx-help-circle me-2 text-info"></i>
                        Ayuda y Recomendaciones
                    </h5>
                </div>
                <div class="card-body p-4">
                    <ul class="help-list list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="small">Usa audífonos para mejor experiencia</span>
                        </li>
                        <li class="mb-3">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="small">Asegúrate de tener buena iluminación</span>
                        </li>
                        <li class="mb-3">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="small">Permite el acceso a cámara y sensores</span>
                        </li>
                        <li class="mb-0">
                            <i class="bx bx-check-circle text-success me-2"></i>
                            <span class="small">Usa Chrome o Firefox para mejor compatibilidad</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- System Information -->
            <div class="card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="200">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bx bx-info-circle me-2 text-warning"></i>
                        Información
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="info-section">
                        <div class="info-row mb-3">
                            <span class="text-muted small">Versión</span>
                            <span class="fw-semibold small">1.0.0-beta</span>
                        </div>
                        <div class="info-row mb-3">
                            <span class="text-muted small">Repositorio</span>
                            <a href="https://github.com/roepard-labs/thepearlo_vr-appstore" target="_blank"
                                class="fw-semibold small text-decoration-none d-flex align-items-center gap-1">
                                <i class="bx bxl-github"></i>
                                GitHub
                            </a>
                        </div>
                        <div class="info-row">
                            <span class="text-muted small">Última actualización</span>
                            <span class="fw-semibold small">Nov 2025</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-outline-secondary w-100" id="diagnosticBtn">
                            <i class="bx bx-analyse me-2"></i>
                            Ejecutar Diagnóstico
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Estilos CSS -->
<style>
.homelab-page {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

/* Header */
.homelab-header {
    background: linear-gradient(135deg,
            rgba(var(--bs-primary-rgb), 0.1) 0%,
            rgba(var(--bs-info-rgb), 0.05) 100%);
    border: 1px solid var(--bs-border-color);
    transition: all 0.3s ease;
}

.homelab-header:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.gradient-text {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Stats Cards */
.stat-card-os {
    background-color: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-card-os:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stat-icon-os {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
}

.bg-gradient-1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-2 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-3 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-4 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

/* Profile Picture */
.profile-picture-wrapper {
    position: relative;
}

.profile-picture {
    position: relative;
    transition: all 0.3s ease;
}

.profile-picture:hover {
    transform: scale(1.05);
}

.profile-picture img {
    transition: all 0.3s ease;
}

.profile-picture:hover img {
    border-color: var(--bs-info) !important;
}

/* Enter HomeLab Section */
.enter-homelab-section {
    background: linear-gradient(135deg,
            rgba(var(--bs-primary-rgb), 0.05) 0%,
            rgba(var(--bs-info-rgb), 0.02) 100%);
    border-radius: 12px;
}

.homelab-icon-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-info) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
    box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.3);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.05);
    }
}

.enter-homelab-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    border-radius: 12px;
    font-weight: 600;
}

.enter-homelab-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.4);
}

.enter-homelab-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.enter-homelab-btn:hover::before {
    left: 100%;
}

/* Help List */
.help-list li {
    padding: 8px 0;
    border-bottom: 1px solid var(--bs-border-color);
}

.help-list li:last-child {
    border-bottom: none;
}

/* Info Section */
.info-section .info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--bs-border-color);
}

.info-section .info-row:last-child {
    border-bottom: none;
}

/* Responsive */
@media (max-width: 767.98px) {
    .homelab-header {
        text-align: center;
    }

    .homelab-header .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .stat-icon-os {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .homelab-icon-large {
        width: 80px;
        height: 80px;
        font-size: 2.5rem;
    }

    /* Profile picture más pequeña en móvil */
    .profile-picture img {
        width: 80px !important;
        height: 80px !important;
    }

    /* Alinear info de sesión en móvil */
    .d-flex.gap-4 {
        flex-direction: column;
        align-items: center !important;
        text-align: center;
    }

    .session-info {
        text-align: center;
    }
}
</style>

<!-- JavaScript -->
<script>
(function() {
    'use strict';

    console.log('🥽 ThePearlOS: Inicializando página HomeLab');

    // ===================================
    // CARGAR DATOS DEL USUARIO
    // ===================================
    async function loadUserSession() {
        try {
            const response = await window.AppRouter.get('/routes/user/check_session.php');

            if (response.logged === true && response.user_data) {
                const userData = response.user_data;

                // Actualizar información de sesión
                document.getElementById('sessionName').textContent =
                    `${userData.first_name} ${userData.last_name}`;
                document.getElementById('sessionUsername').textContent =
                    `@${userData.username || userData.user_id}`;
                document.getElementById('sessionEmail').textContent = userData.email;

                // Actualizar foto de perfil
                const profilePictureContainer = document.querySelector('#userProfilePicture img');
                if (profilePictureContainer && userData.profile_picture) {
                    const backendUrl = window.ENV_CONFIG?.BACKEND_URL || 'http://localhost:3000';
                    profilePictureContainer.src = `${backendUrl}${userData.profile_picture}`;
                    profilePictureContainer.onerror = function() {
                        // Si la imagen falla, usar avatar por defecto
                        this.src = '/assets/icons/user-default.png';
                    };
                    console.log('✅ Foto de perfil actualizada:', userData.profile_picture);
                }

                // Rol con badge
                const roleNames = {
                    1: 'Usuario',
                    2: 'Administrador',
                    3: 'Supervisor'
                };
                const roleColors = {
                    1: 'primary',
                    2: 'danger',
                    3: 'warning'
                };
                const roleName = roleNames[userData.role_id] || 'Usuario';
                const roleColor = roleColors[userData.role_id] || 'primary';
                document.getElementById('sessionRole').innerHTML =
                    `<span class="badge bg-${roleColor}">${roleName}</span>`;

                console.log('✅ Datos de sesión cargados:', userData);
            }
        } catch (error) {
            console.error('❌ Error al cargar sesión:', error);
        }
    }

    // ===================================
    // CARGAR ESTADÍSTICAS DEL SISTEMA
    // ===================================
    async function loadSystemStats() {
        try {
            // TODO: Implementar endpoint real cuando backend esté listo
            // Por ahora usar datos de ejemplo

            // Simular carga de datos
            setTimeout(() => {
                // Apps instaladas (ejemplo)
                document.getElementById('totalApps').textContent = '24';

                // Usuarios activos (podemos obtener de sesiones)
                window.AppRouter.get('/routes/admin/get_dashboard_stats.php')
                    .then(data => {
                        if (data.status === 'success') {
                            document.getElementById('activeUsers').textContent = data.stats
                                ?.active_sessions || '0';
                        }
                    })
                    .catch(() => {
                        document.getElementById('activeUsers').textContent = '1';
                    });

                console.log('✅ Estadísticas del sistema cargadas');
            }, 500);

        } catch (error) {
            console.error('❌ Error al cargar estadísticas:', error);
            document.getElementById('totalApps').textContent = '--';
            document.getElementById('activeUsers').textContent = '--';
        }
    }

    // ===================================
    // ANIMACIÓN DEL ICONO HOMELAB
    // ===================================
    function animateHomelabIcon() {
        if (typeof anime === 'undefined') {
            console.warn('⚠️ Anime.js no disponible');
            return;
        }

        const icon = document.getElementById('homelabIcon');

        anime({
            targets: icon,
            scale: [1, 1.1, 1],
            rotate: [0, 5, -5, 0],
            duration: 3000,
            easing: 'easeInOutQuad',
            loop: true
        });
    }

    // ===================================
    // DIAGNÓSTICO DEL SISTEMA
    // ===================================
    function runDiagnostic() {
        const btn = document.getElementById('diagnosticBtn');
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Analizando...';

        // Simular diagnóstico
        setTimeout(() => {
            // Verificaciones
            const checks = {
                'WebXR Support': 'xr' in navigator,
                'Camera Access': navigator.mediaDevices !== undefined,
                'WebGL': !!document.createElement('canvas').getContext('webgl'),
                'LocalStorage': !!window.localStorage,
                'SessionStorage': !!window.sessionStorage
            };

            let results = '<div class="diagnostic-results">';
            results += '<h6 class="mb-3">Resultados del Diagnóstico:</h6>';

            for (const [check, passed] of Object.entries(checks)) {
                const icon = passed ? 'bx-check-circle text-success' : 'bx-x-circle text-danger';
                results +=
                    `<div class="mb-2"><i class="bx ${icon} me-2"></i>${check}: <strong>${passed ? 'OK' : 'Fallo'}</strong></div>`;
            }

            results += '</div>';

            Swal.fire({
                title: 'Diagnóstico Completado',
                html: results,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });

            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }, 2000);
    }

    // ===================================
    // EVENT LISTENERS
    // ===================================
    document.getElementById('diagnosticBtn').addEventListener('click', runDiagnostic);

    document.getElementById('enterHomelabBtn').addEventListener('click', function(e) {
        e.preventDefault();

        // Animación antes de navegar
        anime({
            targets: '#homelabIcon',
            scale: [1, 1.3, 1],
            rotate: 360,
            duration: 800,
            easing: 'easeInOutQuad',
            complete: function() {
                window.location.href = '/homelab';
            }
        });
    });

    // ===================================
    // INICIALIZAR AL CARGAR
    // ===================================
    function initialize() {
        console.log('🚀 ThePearlOS: Iniciando...');

        loadUserSession();
        loadSystemStats();

        // Esperar a que anime.js esté disponible
        setTimeout(() => {
            animateHomelabIcon();
        }, 500);
    }

    // Ejecutar cuando DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

})();
</script>