<!-- Función global para logout usando AppRouter (petición real al backend) -->
<script>
function logoutUserVR() {
    if (window.AppRouter && typeof window.AppRouter.post === 'function') {
        window.AppRouter.post('/routes/user/logout_user.php')
            .then(function (result) {
                console.log('🔓 logout_user.php:', result);
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'Sesión cerrada',
                        text: 'Has cerrado sesión correctamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo cerrar la sesión.',
                        icon: 'error'
                    });
                }
            })
            .catch(function (err) {
                Swal.fire({
                    title: 'Error',
                    text: 'Error al cerrar sesión: ' + err,
                    icon: 'error'
                });
            });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'AppRouter no disponible.',
            icon: 'error'
        });
    }
}
</script>

<!-- Cargar userCheck.js ANTES de la inicialización global -->
<script src="/composables/userCheck.js"></script>
<!-- Cargar homelabConfigCheck para exponer window.HomelabConfig -->
<script src="/composables/homelabConfigCheck.js"></script>
<!-- Weather service (needed for overlay) -->
<script src="/composables/weatherCheck.js"></script>

<!-- Inicialización global: verifica sesión, rol y obtiene datos completos del usuario -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.AppRouter && typeof window.AppRouter.get === 'function') {
        // Verificar sesión activa
        window.AppRouter.get('/routes/user/check_session.php')
            .then(function (data) {
                console.log('🔐 check_session.php:', data);
                if (data.logged === true && data.user_data) {
                    // Obtener datos completos del usuario
                    if (window.UserCheck && typeof window.UserCheck.getUserData === 'function') {
                        window.UserCheck.getUserData()
                            .then(function (userData) {
                                console.group('%c👤 Usuario logueado','color:#00ff88;font-weight:bold;font-size:1.1em');
                                console.log('ID:', userData.user_id);
                                console.log('Username:', userData.username);
                                console.log('Email:', userData.email);
                                console.log('Nombre completo:', userData.full_name);
                                console.log('Rol:', userData.role_name);
                                console.log('Estado:', userData.status_name);
                                console.log('Miembro desde:', userData.member_since, '('+userData.member_since_days+' días)');
                                console.log('Último login:', userData.last_login);
                                console.log('Bio:', userData.bio);
                                console.groupEnd();
                                // Actualizar UI con nombre y rol
                                const userInfo = document.getElementById('vr-user-info');
                                if (userInfo) {
                                    userInfo.innerHTML = `<b>${userData.full_name}</b> <span class=\"badge bg-primary ms-2\">${userData.role_name}</span>`;
                                }
                            })
                            .catch(function (err) {
                                console.error('Error obteniendo datos de usuario:', err);
                            });
                    }
                } else {
                    // No autenticado: cerrar sesión automáticamente
                    logoutUserVR();
                }
            })
            .catch(function (err) {
                console.error('Error en check_session:', err);
                logoutUserVR();
            });
        // Verificar rol y permisos solo para logging
        window.AppRouter.get('/routes/user/check_role.php')
            .then(function (data) {
                console.log('🛡️ check_role.php:', data);
            })
            .catch(function (err) {
                console.error('Error en check_role:', err);
            });
    } else {
        console.warn('AppRouter no disponible');
    }
});
</script>

<!-- Integración con homelabConfigCheck: obtener y loguear la configuración -->
<script>
(function () {
    'use strict';

    function waitForHomelab(attempt) {
        attempt = attempt || 0;
        var MAX = 20;
        var INTERVAL = 150;
        return new Promise(function (resolve) {
            if (window.HomelabConfig && typeof window.HomelabConfig.fetchConfig === 'function') return resolve(window.HomelabConfig);
            if (attempt >= MAX) return resolve(null); // Resolve to null instead of rejecting
            setTimeout(function () { resolve(waitForHomelab(attempt + 1)); }, INTERVAL);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        waitForHomelab().then(function (hc) {
            if (!hc) {
                console.warn('homelab.view: HomelabConfig no disponible after retries (continuing without it)');
                return;
            }
            console.debug('homelab.view: HomelabConfig disponible', hc);
            // fetch current config and log it
            hc.fetchConfig().then(function (cfg) {
                console.debug('homelab.view: config fetched', cfg);
            }).catch(function (err) {
                console.warn('homelab.view: fetchConfig error', err);
            });

            // Listen to updates
            window.addEventListener('homelab:configUpdated', function (e) {
                console.debug('homelab.view: homelab:configUpdated', e.detail);
            });
            window.addEventListener('homelab:configLoaded', function (e) {
                console.debug('homelab.view: homelab:configLoaded', e.detail);
            });
        });
    });

})();
</script>
<!-- VR-OS main scene (A-Frame) -->
<!-- VR-OS main scene (A-Frame) -->
<style>
/* Ensure the A-Frame canvas fills viewport inside this view */
section.vr-os, section.vr-os a-scene, section.vr-os a-scene .a-scene {
    width: 100% !important;
    height: 100vh !important;
    display: block !important;
}
</style>

<section class="vr-os container-fluid p-0">
    <a-scene embedded renderer="antialias: true" background="color: #0a0a0a" vr-mode-ui="enabled: true">
        <!-- Camera rig: supports desktop (mouse) and VR controllers -->
        <a-entity id="cameraRig">
            <a-entity id="camera" camera look-controls wasd-controls position="0 1.6 0">
                <!-- Mouse raycaster for desktop interactions -->
                <a-entity cursor="fuse: false; rayOrigin: mouse"
                          raycaster="objects: .clickable"
                          position="0 0 -1"
                          geometry="primitive: ring; radiusInner: 0.01; radiusOuter: 0.02"
                          material="color: #ffffff; shader: flat"></a-entity>
            </a-entity>
        </a-entity>

        <!-- Lighting: ambient + directional for basic visibility -->
        <a-entity light="type: ambient; color: #666"></a-entity>
        <a-entity light="type: directional; color: #ffffff; intensity: 0.8" position="0 4 2"></a-entity>

        <!-- Basic environment for the OS shell -->
        <a-entity environment="preset: forest; dressingAmount:6; skyColor: #0a0a0a; horizonColor: #111;" position="0 0 0"></a-entity>

        <!-- Mockup elements: app area, sidebar anchor, status bar -->
        <a-entity id="vr-os-shell">
            <!-- App container (floating panel) -->
            <a-entity id="vr-app-panel" position="0 1.6 -2" geometry="primitive: plane; width: 1.8; height: 1.0" material="color: #0f1720; opacity: 0.95; shader: flat" class="clickable">
                <!-- Top: app name (center) -->
                <a-text id="vr-panel-appname" value="Aplicación: Ninguna" color="#fff" position="0 0.45 0.01" align="center" width="1.6"></a-text>
                <!-- Left: panel label -->
                <a-text value="VR-OS App Area" color="#fff" position="-0.85 0.15 0.01" width="2"></a-text>
                <!-- Panel weather summary (updated from WeatherService) -->
                <a-text id="vr-panel-weather" value="" color="#9fd" position="0.7 0.15 0.01" align="right" width="0.6"></a-text>
                <!-- Main content area -->
                <a-entity id="vr-app-content" position="-0.85 -0.25 0.01"></a-entity>

                <!-- Action buttons (Cerrar, Recientes) - positioned at bottom of panel -->
                <a-entity id="vr-panel-actions" position="0 -0.4 0.01">
                    <a-plane id="vr-btn-recents" class="clickable" position="-0.45 0 0" width="0.6" height="0.18" color="#0b74a3" material="shader: flat">
                        <a-text value="Recientes" color="#fff" align="center" position="0 0 0.01" width="0.55"></a-text>
                    </a-plane>
                    <a-plane id="vr-btn-close" class="clickable" position="0.45 0 0" width="0.6" height="0.18" color="#a32b2b" material="shader: flat">
                        <a-text value="Cerrar" color="#fff" align="center" position="0 0 0.01" width="0.55"></a-text>
                    </a-plane>
                </a-entity>
            </a-entity>

            <!-- Sidebar (apps) -->
            <a-entity id="vr-sidebar" position="-1.6 1.6 -1.6">
                <a-box position="0 0 0" depth="0.02" height="1.6" width="0.6" color="#0b1220" opacity="0.98"></a-box>
                <!-- Example app icons -->
                <a-entity id="vr-app-list" position="-0.25 0.5 0.03"></a-entity>
            </a-entity>

            <!-- Status bar (bottom) -->
            <a-entity id="vr-status" position="0 0.2 -1.5">
                <a-plane width="2.6" height="0.18" color="#071019" opacity="0.95"></a-plane>
                <a-text value="Hora: --:--" id="vr-time" color="#9fd" position="-1.2 0 0.01" width="1.2"></a-text>
            </a-entity>
        </a-entity>


    </a-scene>
</section>

<!-- Load local A-Frame components and init script -->
<script src="../src/aframe/gaze-activator.js"></script>
<script src="../src/aframe/item-deployer.js"></script>
<script src="../src/aframe/surface-detector.js"></script>
<script src="../src/index.js"></script>

<!-- Overlay UI for clock and weather (2D DOM over the scene) -->
<style>
    #vr-overlay {
        position: fixed;
        right: 1rem;
        top: 1rem;
        z-index: 2000;
        display: flex;
        gap: 0.5rem;
        align-items: center;
        pointer-events: none; /* allow clicks to pass through to scene */
        font-family: Arial, Helvetica, sans-serif;
    }
    .vr-widget {
        background: rgba(6,10,14,0.6);
        color: #e6f9f8;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        min-width: 120px;
        text-align: left;
        pointer-events: auto;
        backdrop-filter: blur(4px);
    }
    .vr-widget img { width: 36px; height: 36px; vertical-align: middle; }
    .vr-widget .main { font-weight: 600; font-size: 1rem; }
    .vr-widget .sub { font-size: 0.8rem; opacity: 0.9; }
</style>

<div id="vr-overlay">
    <div id="vr-clock" class="vr-widget" aria-live="polite">
        <div class="main" id="vr-clock-time">--:--</div>
        <div class="sub" id="vr-clock-date">Cargando fecha...</div>
    </div>
    <div id="vr-weather" class="vr-widget" aria-live="polite">
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <img id="vr-weather-icon" src="" alt="icon" />
            <div style="flex:1;">
                <div class="main" id="vr-weather-temp">--°</div>
                <div class="sub" id="vr-weather-desc">Cargando clima...</div>
            </div>
        </div>
    </div>
</div>

<!-- Top-center panel containing app name, clock, weather and embedded app (iframe) -->
<style>
    #vr-panel {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        top: 1.2rem;
        width: 68vw;
        max-width: 1100px;
        z-index: 1999;
        pointer-events: auto;
        font-family: Arial, Helvetica, sans-serif;
    }
    #vr-panel .panel-header {
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
        background: rgba(10,12,16,0.75); color:#e6f9f8; padding:0.6rem 0.8rem; border-radius:10px 10px 6px 6px;
    }
    #vr-panel .panel-body {
        background: rgba(2,6,10,0.85); height: 48vh; border-radius: 0 0 10px 10px; overflow: hidden; margin-top: 0.2rem;
    }
    #vr-panel iframe { width:100%; height:100%; border:0; display:block; }
    .panel-left { display:flex; gap:0.75rem; align-items:center; }
    .panel-title { font-weight:700; font-size:1.05rem; }
    .panel-sub { font-size:0.85rem; opacity:0.9; }
</style>

<div id="vr-panel">
    <div class="panel-header">
        <div class="panel-left">
            <div class="panel-title" id="panel-appname">Aplicación: Ninguna</div>
            <div class="panel-sub" id="panel-time">--:--</div>
            <div class="panel-sub" id="panel-date">Cargando...</div>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <img id="panel-weather-icon" src="" alt="weather" style="width:36px;height:36px;" />
            <div style="text-align:right;">
                <div id="panel-weather-temp" style="font-weight:600;">--°</div>
                <div id="panel-weather-desc" style="font-size:0.85rem;opacity:0.9;">Cargando clima...</div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <iframe id="vr-app-iframe" src="about:blank" title="App Embed"></iframe>
    </div>
</div>

<script>
    (function(){
        'use strict';

        // Update DOM and 3D a-text with clock using existing ClockService events
        window.addEventListener('clockUpdated', function(e){
            try {
                var detail = e.detail || {};
                var time = detail.time || '';
                var date = detail.date || '';

                // Update 3D text inside A-Frame if present
                var aText = document.getElementById('vr-time');
                if (aText && typeof aText.setAttribute === 'function') {
                    aText.setAttribute('value', 'Hora: ' + time);
                }

                // Update overlay DOM
                var domTime = document.getElementById('vr-clock-time');
                var domDate = document.getElementById('vr-clock-date');
                if (domTime) domTime.textContent = time;
                if (domDate) domDate.textContent = date;

                // Update top panel time/date
                var panelTime = document.getElementById('panel-time');
                var panelDate = document.getElementById('panel-date');
                if (panelTime) panelTime.textContent = time;
                if (panelDate) panelDate.textContent = date;
            } catch (err) {
                console.warn('VR overlay clock update error', err);
            }
        });

        // Fetch weather once and then periodically
        async function refreshWeather() {
            try {
                if (window.getDefaultWeather) {
                    var w = await window.getDefaultWeather();
                    if (!w) return;
                    var tempEl = document.getElementById('vr-weather-temp');
                    var descEl = document.getElementById('vr-weather-desc');
                    var iconEl = document.getElementById('vr-weather-icon');
                                        if (tempEl && w.temperature) tempEl.textContent = Math.round(w.temperature.current) + (w.temperature.unit || '');
                                        if (descEl && w.weather) descEl.textContent = (w.weather.description || w.weather.main || '—');
                                        if (iconEl && w.weather && w.weather.iconURL) iconEl.src = w.weather.iconURL;
                                        // Update top panel weather DOM
                                        var pTemp = document.getElementById('panel-weather-temp');
                                        var pDesc = document.getElementById('panel-weather-desc');
                                        var pIcon = document.getElementById('panel-weather-icon');
                                        if (pTemp && w.temperature) pTemp.textContent = Math.round(w.temperature.current) + (w.temperature.unit || '');
                                        if (pDesc && w.weather) pDesc.textContent = (w.weather.description || w.weather.main || '—');
                                        if (pIcon && w.weather && w.weather.iconURL) pIcon.src = w.weather.iconURL;
                                        // Update 3D panel weather text if present
                                        try {
                                            var panelWeather = document.getElementById('vr-panel-weather');
                                            if (panelWeather && typeof panelWeather.setAttribute === 'function') {
                                                var panelText = Math.round(w.temperature.current) + (w.temperature.unit || '') + ' — ' + (w.weather.description || w.weather.main || '');
                                                panelWeather.setAttribute('value', panelText);
                                            }
                                        } catch (err) {
                                            console.warn('Failed to update 3D panel weather', err);
                                        }
                } else {
                    console.warn('WeatherService not ready');
                }
            } catch (err) {
                console.warn('Failed to refresh weather', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function(){
            // initial weather fetch
            refreshWeather();
            // refresh every 10 minutes
            setInterval(refreshWeather, 10 * 60 * 1000);
        });
    })();
</script>
