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
                    <div class="homelab-version text-end">
                        <small class="d-block text-muted">Frontend: <span id="repoVersionFrontend">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="visually-hidden">Cargando versión</span>
                            </span></small>
                        <small class="d-block text-muted">Backend: <span id="repoVersionBackend">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="visually-hidden">Cargando versión</span>
                            </span></small>
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
                        <p class="text-muted mb-1 small">Status</p>
                        <h5 class="mb-0 fw-bold" id="systemUptime">Cargando...</h5>
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

                        <!-- Info  profile-->
                        <div class="col-12 col-lg-6">
                            <div class="d-flex gap-4 align-items-start">


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
                                <button class="btn btn-primary btn-lg px-4 py-3 enter-homelab-btn"
                                    id="enterHomelabBtn" data-bs-toggle="modal" data-bs-target="#homelabModal">
                                    <i class="bx bx-right-arrow-circle me-2"></i>
                                    Entrar a HomeLab
                                </button>
                            </div>

                            <!-- Modal de ingreso a HomeLab VR/AR -->
                            <?php include __DIR__ . '/../modals/homelab.modal.php'; ?>
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

            <!-- User diagnostic -->
            <div class="card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="200">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bx bx-info-circle me-2 text-warning"></i>
                        Diagnostico
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-3">Ejecuta un diagnóstico rápido de tu sistema para asegurar la mejor
                        experiencia
                        VR/AR.</p>
                </div>
                <div class="mt-3">
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
    (function () {
        'use strict';

        console.log('🥽 ThePearlOS: Inicializando página HomeLab');

        // ===================================
        // CARGAR DATOS DEL USUARIO
        // ===================================
        async function loadUserSession() {
            try {
                console.log('🔎 loadUserSession: iniciando petición a /routes/user/user_data.php');
                // Usar endpoint más completo: /routes/user/user_data.php
                const response = await window.AppRouter.get('/routes/user/user_data.php');
                console.log('🔁 loadUserSession: response raw ->', response);
                const payload = response && (response.data || response) || {};
                console.log('🔁 loadUserSession: payload ->', payload);
                const userData = payload.data || payload;
                console.log('🔁 loadUserSession: userData ->', userData);

                // Aceptar varias formas de respuesta del backend:
                // 1) { status: 'success', data: { ... } }
                // 2) respuesta directa con los datos del usuario (sin status)
                const respStatus = (response && (response.status || (response.data && response.data.status))) ||
                    payload.status;
                if (userData && (respStatus === 'success' || (userData && userData.user_id))) {
                    // Nombre completo preferido
                    const fullName = userData.full_name ||
                        `${userData.first_name || ''} ${userData.last_name || ''}`.trim();
                    document.getElementById('sessionName').textContent = fullName || 'Usuario';

                    // Mostrar identificador y usuario de forma agradable
                    const uid = userData.user_id || '';
                    const uname = userData.username || '';
                    const usernameEl = document.getElementById('sessionUsername');
                    if (usernameEl) {
                        // Formato solicitado: (4@thisfeeling)
                        // Si no hay username, mostrar solo el id entre paréntesis: (4)
                        // Si no hay id pero hay username, mostrar (@username)
                        const display = uid ? (uname ? `(${uid}@${uname})` : `(${uid})`) : (uname ? `(@${uname})` :
                            '@usuario');
                        usernameEl.innerHTML = `<span class="fw-bold text-primary">${display}</span>`;
                    }

                    // Email
                    document.getElementById('sessionEmail').textContent = userData.email || '';

                    // Actualizar foto de perfil
                    const profilePictureContainer = document.querySelector('#userProfilePicture img');
                    if (profilePictureContainer && userData.profile_picture) {
                        const backendUrl = window.ENV_CONFIG?.API_URL || 'http://localhost:3000';
                        profilePictureContainer.src = `${backendUrl}${userData.profile_picture}`;
                        profilePictureContainer.onerror = function () {
                            // Si la imagen falla, usar avatar por defecto
                            this.src = '/assets/img/default-avatar.png';
                        };
                        console.log('✅ Foto de perfil actualizada:', userData.profile_picture);
                    }

                    // Rol con badge (usar role_name si está disponible)
                    const roleName = userData.role_name || 'Usuario';
                    const roleColorMap = {
                        user: 'primary',
                        admin: 'danger',
                        supervisor: 'warning'
                    };
                    const roleColor = roleColorMap[(userData.role_name || '').toLowerCase()] || 'primary';
                    document.getElementById('sessionRole').innerHTML =
                        `<span class="badge bg-${roleColor}">${roleName}</span>`;

                    console.log('✅ Datos de sesión cargados y aplicados al DOM:', userData);
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
                    // Apps instaladas: dejar el estado de carga por defecto a menos que
                    // la API nos devuelva explícitamente un valor numérico.
                    // (El HTML inicial ya contiene un spinner; no sobreescribimos.)

                    // Usuarios activos (obtenidos desde /routes/dashboard/stats.php)
                    window.AppRouter.get('/routes/dashboard/stats.php')
                        .then(response => {
                            // La API responde: { status: 'success', data: { stats: { ... } } }
                            const payload = response && (response.data || response);
                            const stats = payload && (payload.stats || (payload.data && payload.data
                                .stats)) || {};

                            // Preferir sesiones activas si están disponibles, sino usuarios activos
                            const activeFromSessions = stats.sessions && (stats.sessions.active ?? stats
                                .sessions.user_sessions);
                            const activeFromUsers = stats.users && (stats.users.active ?? stats.users
                                .total);

                            const active = (typeof activeFromSessions === 'number') ?
                                activeFromSessions :
                                (typeof activeFromUsers === 'number' ? activeFromUsers : null);

                            document.getElementById('activeUsers').textContent = (active !== null) ?
                                String(active) : '0';

                            // Si la API expone un conteo de apps, usarlo; si no, dejar el spinner
                            // (soporte para varias formas: stats.apps.total, stats.apps.installed,
                            // stats.apps_count)
                            let appsCount = null;
                            if (stats) {
                                if (typeof stats.apps === 'number') appsCount = stats.apps;
                                if (stats.apps && typeof stats.apps.total === 'number') appsCount =
                                    stats.apps.total;
                                if (stats.apps && typeof stats.apps.installed === 'number') appsCount =
                                    stats.apps.installed;
                                if (typeof stats.apps_count === 'number') appsCount = stats.apps_count;
                            }
                            if (appsCount !== null) {
                                document.getElementById('totalApps').textContent = String(appsCount);
                            }

                            // Si el endpoint expone algún dato de apps en otro lugar, podríamos usarlo.
                            // Por ahora dejar totalApps como estaba si no viene en stats.
                            // Obtener estado del backend para el recuadro "Status"
                            window.AppRouter.get('/routes/web/status.php')
                                .then(statusResp => {
                                    const payload = statusResp && (statusResp.data || statusResp) ||
                                        {};
                                    // Mostrar solo "API Running" en caso de éxito (sin timestamp)
                                    if (payload.status === 'success') {
                                        document.getElementById('systemUptime').innerHTML =
                                            `<i class="bx bx-check-circle me-1 text-success"></i> API Running`;
                                    } else {
                                        const msg = payload.message || payload.status ||
                                            'Desconocido';
                                        document.getElementById('systemUptime').innerHTML =
                                            `<i class="bx bx-x-circle me-1 text-danger"></i> ${msg}`;
                                    }
                                })
                                .catch(() => {
                                    document.getElementById('systemUptime').innerHTML =
                                        `<i class="bx bx-help-circle me-1 text-warning"></i> Desconectado`;
                                });
                        })
                        .catch((err) => {
                            console.warn('❌ Error cargando dashboard stats:', err);
                            document.getElementById('activeUsers').textContent = '0';
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
        // ANIMACIÓN DEL ICONO HOMELAB - DESACTIVADA
        // Mantener la librería anime.js cargada pero NO ejecutarla aquí
        // para evitar errores si la versión cargada no expone la API esperada.
        // Si en el futuro queremos usar animaciones avanzadas, crear una
        // función segura que verifique la API de anime antes de llamar.
        // Por ahora usamos solo efectos CSS y una navegación simple.

        // ===================================
        // LIMPIAR LOADERS GLOBALES (SAFE)
        // Oculta overlays o loaders globales que puedan haberse quedado activos
        // y cierra modales tipo Swal si están abiertos. Operación segura (no-op
        // si los elementos no existen).
        function clearGlobalLoaders() {
            try {
                // Cerrar SweetAlert si está visible
                if (typeof Swal !== 'undefined' && Swal.close) {
                    try {
                        Swal.close();
                    } catch (e) {
                        /* ignore */
                    }
                }

                // Selectores comunes de loaders/overlays en el proyecto
                const selectors = ['#app-loader', '#page-loader', '.loading-overlay', '.page-loading', '.app-loading',
                    '.preloader', '.site-loader'
                ];
                selectors.forEach(sel => {
                    document.querySelectorAll(sel).forEach(el => {
                        try {
                            el.style.display = 'none';
                            el.classList.remove('show', 'visible', 'active');
                        } catch (e) {
                            /* ignore */
                        }
                    });
                });

                // Asegurar que el main-content sea visible
                const main = document.getElementById('main-content');
                if (main) {
                    main.style.visibility = 'visible';
                    main.style.opacity = '1';
                }

                // Restaurar scroll si estaba deshabilitado
                try {
                    document.body.style.overflow = 'auto';
                } catch (e) {
                    /* ignore */
                }
                console.log('🔧 Limpieza de loaders globales ejecutada');
            } catch (e) {
                console.warn('🔧 clearGlobalLoaders falló:', e);
            }
        }

        // ===================================
        // DIAGNÓSTICO DEL SISTEMA
        // ===================================
        function runDiagnostic() {
            const btn = document.getElementById('diagnosticBtn');
            const originalHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Analizando...';
            // Ejecutar comprobaciones (incluye Modernizr si está disponible)
            const reportLines = [];

            const hasModernizr = !!window.Modernizr;
            if (hasModernizr) {
                reportLines.push('<div class="mb-2"><strong>Modernizr:</strong> disponible</div>');
                // Añadir algunas comprobaciones comunes realizadas por Modernizr
                const mChecks = {
                    'WebGL (Modernizr.webgl)': !!Modernizr.webgl,
                    'LocalStorage (Modernizr.localstorage)': !!Modernizr.localstorage,
                    'Canvas (Modernizr.canvas)': !!Modernizr.canvas
                };
                for (const [k, v] of Object.entries(mChecks)) {
                    const icon = v ? 'bx-check-circle text-success' : 'bx-x-circle text-danger';
                    reportLines.push(`<div class="mb-2"><i class="bx ${icon} me-2"></i>${k}: <strong>${v ? 'OK' : 'Fallo'}</strong></div>`);
                }
            } else {
                reportLines.push('<div class="mb-2"><strong>Modernizr:</strong> no disponible (se usará comprobación nativa)</div>');
            }

            // Comprobaciones nativas / adicionales
            const nativeChecks = {
                'WebXR API (navigator.xr)': 'xr' in navigator,
                'MediaDevices API (getUserMedia presente)': !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia),
                'WebGL (canvas test)': (() => { try { return !!document.createElement('canvas').getContext('webgl'); } catch (e) { return false; } })(),
                'LocalStorage (nativo)': !!window.localStorage,
                'SessionStorage (nativo)': !!window.sessionStorage
            };

            for (const [k, v] of Object.entries(nativeChecks)) {
                const icon = v ? 'bx-check-circle text-success' : 'bx-x-circle text-danger';
                reportLines.push(`<div class="mb-2"><i class="bx ${icon} me-2"></i>${k}: <strong>${v ? 'OK' : 'Fallo'}</strong></div>`);
            }

            // Intentar comprobar acceso a cámara solicitando permiso (si el API está disponible)
            (async function checkCameraAndShow() {
                let cameraAccess = false;
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                        cameraAccess = true;
                        // Detener tracks inmediatamente
                        stream.getTracks().forEach(t => t.stop());
                    } catch (e) {
                        cameraAccess = false;
                    }
                }
                const camIcon = cameraAccess ? 'bx-check-circle text-success' : 'bx-x-circle text-danger';
                reportLines.push(`<div class="mb-2"><i class="bx ${camIcon} me-2"></i>Acceso a cámara (getUserMedia): <strong>${cameraAccess ? 'OK' : 'No disponible / denegado'}</strong></div>`);

                // Montar HTML de resultados
                let results = '<div class="diagnostic-results">';
                results += '<h6 class="mb-3">Resultados del Diagnóstico:</h6>';
                results += reportLines.join('');
                results += '</div>';

                Swal.fire({
                    title: 'Diagnóstico Completado',
                    html: results,
                    icon: 'info',
                    confirmButtonText: 'Cerrar'
                });

                btn.disabled = false;
                btn.innerHTML = originalHtml;
            })();
        }

        // ===================================
        // EVENT LISTENERS
        // ===================================
        document.getElementById('diagnosticBtn').addEventListener('click', runDiagnostic);

        document.getElementById('enterHomelabBtn').addEventListener('click', function (e) {
            e.preventDefault();

            // Animación ligera con CSS/JS (no usamos anime.js para evitar errores)
            const icon = document.getElementById('homelabIcon');
            if (icon) {
                icon.style.transition = 'transform 0.6s ease-in-out';
                icon.style.transform = 'scale(1.25) rotate(20deg)';
                // revertir después
                setTimeout(() => {
                    icon.style.transform = '';
                }, 600);
            }

            // Navegar tras pequeña pausa para que el usuario vea la respuesta
            setTimeout(() => {
                // window.location.href = '/homelab';
            }, 250);
        });

        // ===================================
        // INICIALIZAR AL CARGAR
        // ===================================
        function initialize() {
            console.log('🚀 ThePearlOS: Iniciando...');

            // Intentar limpiar loaders globales/overlays que puedan quedarse activos
            // (safety: no-ops si no existen). Esto soluciona casos donde la UI queda
            // bloqueada por un overlay/loader que no se cerró correctamente.
            clearGlobalLoaders();

            loadUserSession();
            loadSystemStats();

            // Nota: dejamos anime.js cargada pero NO la ejecutamos aquí.
            // Evitamos la comprobación/reintentos para no generar errores si
            // la librería expone una API distinta.
        }

        // Ejecutar cuando DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initialize);
        } else {
            initialize();
        }

        // ===================================
        // COMPROBAR VERSIONES FRONTEND / BACKEND EN GITHUB
        // ===================================
        async function checkRepoVersions() {
            const feEl = document.getElementById('repoVersionFrontend');
            const beEl = document.getElementById('repoVersionBackend');
            if (!feEl && !beEl) return;

            const STORE_FE = 'thepearlo_version_frontend_v1';
            const STORE_BE = 'thepearlo_version_backend_v1';
            const TTL = 60 * 60 * 1000; // 60 minutes

            function getStored(key) {
                try {
                    const raw = sessionStorage.getItem(key);
                    if (!raw) return null;
                    const p = JSON.parse(raw);
                    if (!p || !p.ts) return null;
                    if (Date.now() - p.ts > TTL) return null;
                    return p.value;
                } catch (e) {
                    return null;
                }
            }

            function setStored(key, value) {
                try {
                    sessionStorage.setItem(key, JSON.stringify({
                        ts: Date.now(),
                        value
                    }));
                } catch (e) { }
            }

            // Helper para actualizar un elemento con objeto v { tag, url, data }
            function apply(el, v, fallback) {
                if (!el) return;
                // limpiar spinner
                el.innerHTML = '';
                if (!v) {
                    el.textContent = fallback || el.textContent || 'v1.0.0-beta';
                    return;
                }
                const tag = v.tag || (v.data && (v.data.tag_name || v.data.name)) || fallback || 'v1.0.0-beta';
                if (v.url) el.innerHTML =
                    `<a href="${v.url}" target="_blank" class="text-decoration-none">${tag}</a>`;
                else el.textContent = tag;
            }

            // Try cache first
            const cachedFE = getStored(STORE_FE);
            const cachedBE = getStored(STORE_BE);
            if (cachedFE) {
                apply(feEl, cachedFE, 'v1.0.0-beta');
            }
            if (cachedBE) {
                apply(beEl, cachedBE, 'v1.0.0-beta');
            }

            try {
                if (window.VersionService && typeof VersionService.getLatestTagOrRelease === 'function') {
                    const [fe, be] = await Promise.all([
                        VersionService.getLatestTagOrRelease('frontend'),
                        VersionService.getLatestTagOrRelease('backend')
                    ]);
                    if (fe) {
                        setStored(STORE_FE, fe);
                        apply(feEl, fe, 'v1.0.0-beta');
                    }
                    if (be) {
                        setStored(STORE_BE, be);
                        apply(beEl, be, 'v1.0.0-beta');
                    }
                    return;
                }

                // Fallback: usar API pública de GitHub
                const urls = {
                    frontend_latest: 'https://api.github.com/repos/roepard-labs/thepearlo_vr-website/releases/latest',
                    backend_latest: 'https://api.github.com/repos/roepard-labs/thepearlo_vr-backend/releases/latest'
                };

                const [rfe, rbe] = await Promise.all([
                    fetch(urls.frontend_latest, {
                        headers: {
                            Accept: 'application/vnd.github.v3+json'
                        }
                    }),
                    fetch(urls.backend_latest, {
                        headers: {
                            Accept: 'application/vnd.github.v3+json'
                        }
                    })
                ]);

                if (rfe.ok) {
                    const data = await rfe.json();
                    const feObj = {
                        tag: data.tag_name || data.name,
                        url: data.html_url,
                        data
                    };
                    setStored(STORE_FE, feObj);
                    apply(feEl, feObj, 'v1.0.0-beta');
                } else if (!cachedFE) apply(feEl, null, 'v1.0.0-beta');

                if (rbe.ok) {
                    const data = await rbe.json();
                    const beObj = {
                        tag: data.tag_name || data.name,
                        url: data.html_url,
                        data
                    };
                    setStored(STORE_BE, beObj);
                    apply(beEl, beObj, 'v1.0.0-beta');
                } else if (!cachedBE) apply(beEl, null, 'v1.0.0-beta');

            } catch (e) {
                console.warn('❌ Error comprobando versions:', e);
                if (!cachedFE) apply(feEl, null, 'v1.0.0-beta');
                if (!cachedBE) apply(beEl, null, 'v1.0.0-beta');
            }
        }

        // Ejecutar comprobación en background poco después de initialize()
        setTimeout(() => {
            try {
                checkRepoVersions();
            } catch (e) {
                console.warn('checkRepoVersions falló:', e);
            }
        }, 500);

    })();
</script>