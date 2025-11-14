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
<section class="homelab-preview container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-3 text-center">HomeLab VR/AR Preview</h1>
                    <p class="lead text-center">Bienvenido a la vista preliminar de HomeLab VR/AR. Aquí se cargarán todas las dependencias de realidad virtual y aumentada necesarias para la experiencia.</p>
                    <div class="alert alert-info text-center">
                        <strong>Dependencias VR/AR:</strong> Todas las librerías principales se cargan automáticamente.<br>
                        Puedes comenzar a integrar componentes de <code>A-Frame</code>, <code>AR.js</code>, <code>Three.js</code> y más.
                    </div>
                    <div id="vr-user-info" class="mb-3 text-center"></div>
                    <div class="vr-demo my-4">
                        <!-- Ejemplo básico de escena A-Frame -->
                        <div class="ratio ratio-16x9 border rounded">
                            <a-scene embedded style="width:100%; height:100%;">
                                <a-box position="-1 1 -3" rotation="0 45 0" color="#4CC3D9"></a-box>
                                <a-sphere position="0 1.25 -5" radius="1.25" color="#EF2D5E"></a-sphere>
                                <a-cylinder position="1 0.75 -3" radius="0.5" height="1.5" color="#FFC65D"></a-cylinder>
                                <a-plane position="0 0 -4" rotation="-90 0 0" width="4" height="4" color="#7BC8A4"></a-plane>
                                <a-sky color="#ECECEC"></a-sky>
                            </a-scene>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center bg-dark">
                    <small class="text-muted">Esta es una vista preliminar. Personaliza la experiencia VR/AR aquí.</small>
                </div>
            </div>
        </div>
    </div>
</section>
