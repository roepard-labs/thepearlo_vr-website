<?php
/**
 * Componente: Header
 * Header con navegación y autenticación
 * HomeLab AR - Roepard Labs
 */

// Verificar si el usuario está autenticado (usando estructura del backend)
$isAuthenticated = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userName = $isAuthenticated ? ($_SESSION['user_name'] ?? 'Usuario') : '';
$userRole = $isAuthenticated ? ($_SESSION['role_id'] ?? 1) : 1;

// Detectar si estamos en una página de error (30x/40x/50x) y, en ese caso,
// renderizar un header minimal (solo logo) y salir para evitar cargar scripts
// y elementos que provocan reintentos en consola.
$current_uri = $_SERVER['REQUEST_URI'] ?? '';
$error_paths = ['/40x.php', '/30x.php', '/50x.php'];
$is_error_page = false;
foreach ($error_paths as $p) {
    if (strpos($current_uri, $p) === 0) {
        $is_error_page = true;
        break;
    }
}

if ($is_error_page) {
    // Header minimal para páginas de error: solo logo y marca
    ?>
    <header class="navbar shadow-sm sticky-top" data-bs-theme="auto">
        <div class="container py-2">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <i class="bx bx-cube-alt text-primary fs-3 me-2"></i>
                <span class="text-primary">HomeLab</span>
                <span class="text-secondary">AR</span>
            </a>
        </div>
    </header>
    <?php
    // Salir para no renderizar el header completo con scripts
    return;
}
?>

<header class="navbar navbar-expand-lg shadow-sm sticky-top" data-bs-theme="auto">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            <i class="bx bx-cube-alt text-primary fs-3 me-2"></i>
            <span class="text-primary">HomeLab</span>
            <span class="text-secondary">AR</span>
        </a>

        <!-- Toggler para móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/features">Características</a>
                </li>
                <li class="nav-item" data-home-only>
                    <a class="nav-link" href="#about">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/homelab">VR/AR</a>
                </li>
                <li class="nav-item" data-home-only>
                    <a class="nav-link" href="#contact">Contacto</a>
                </li>
            </ul>

            <!-- Acciones del usuario -->
            <div class="d-flex align-items-center gap-2">
                <!-- Theme Toggle -->
                <button class="btn btn-outline-secondary btn-sm" id="themeToggle" title="Cambiar tema">
                    <i class="bx bx-moon"></i>
                </button>

                <?php if ($isAuthenticated): ?>
                    <!-- Usuario autenticado -->
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" type="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Avatar del botón (img + fallback icon) -->
                            <div class="user-avatar-btn bg-white rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                                style="width: 28px; height: 28px;" id="headerAvatarBtn">
                                <img id="headerAvatarImgBtn" src="/assets/img/default-avatar.png" alt="Avatar"
                                    class="w-100 h-100 object-fit-cover" style="display: block;">
                                <i id="headerAvatarIconBtn" class="bx bx-user-circle text-primary"
                                    style="display: none; font-size: 1.5rem;"></i>
                            </div>
                            <span><?php echo htmlspecialchars($userName); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <!-- Header del dropdown con info del usuario -->
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar-dropdown bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                                        style="width: 36px; height: 36px;" id="headerAvatarDropdown">
                                        <img id="headerAvatarImgDropdown" src="/assets/img/default-avatar.png" alt="Avatar"
                                            class="w-100 h-100 object-fit-cover" style="display: block;">
                                        <i id="headerAvatarIconDropdown" class="bx bx-user text-white"
                                            style="display: none;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small"><?php echo htmlspecialchars($userName); ?></div>
                                        <small
                                            class="text-muted"><?php echo $userRole == 2 ? 'Administrador' : 'Usuario'; ?></small>
                                    </div>
                                </div>
                            </li>

                            <!-- Opciones del menú según rol -->
                            <?php if ($userRole == 2): ?>
                                <!-- Administrador: Admin Dashboard + Configuración -->
                                <li><a class="dropdown-item py-2" href="/dashboard">
                                        <d class="bx bx-dashboard me-2 text-primary"></d>Admin Dashboard
                                    </a></li>
                            <?php else: ?>
                                <!-- Usuario/Supervisor: User Dashboard + Configuración -->
                                <li><a class="dropdown-item py-2" href="/dashboard"><i
                                            class="bx bx-dashboard me-2 text-primary"></i>User Dashboard</a></li>
                            <?php endif; ?>

                            <li>
                                <hr class="dropdown-divider my-2">
                            </li>

                            <li>
                                <a class="dropdown-item py-2 text-danger" href="#" id="logoutBtn">
                                    <i class="bx bx-log-out me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Usuario no autenticado - UN SOLO BOTÓN -->
                    <button class="btn btn-primary px-4" id="authModalTrigger" type="button">
                        <i class="bx bx-user-circle me-2"></i>
                        Identifícate
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<style>
    .navbar {
        transition: all 0.3s ease;
        background-color: var(--bs-body-bg) !important;
        border-bottom: 1px solid var(--bs-border-color);
    }

    .navbar-brand {
        font-size: 1.5rem;
    }

    .nav-link {
        font-weight: 500;
        transition: color 0.3s ease;
        color: var(--bs-body-color) !important;
    }

    .nav-link:hover {
        color: var(--bs-primary) !important;
    }

    /* Asegurar visibilidad del toggler en ambos temas */
    .navbar-toggler {
        border-color: var(--bs-border-color);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    [data-bs-theme="dark"] .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Dropdown menu adaptable al tema */
    .dropdown-menu {
        background-color: var(--bs-body-bg);
        border-color: var(--bs-border-color);
        border-radius: 12px;
        padding: 0.5rem;
        min-width: 260px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        color: var(--bs-body-color);
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-body-color);
        transform: translateX(5px);
    }

    .dropdown-item.text-danger:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: var(--bs-danger) !important;
    }

    /* Botón del dropdown con animación */
    .dropdown button {
        transition: all 0.3s ease;
    }

    .dropdown button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(var(--bs-primary-rgb), 0.4);
    }

    /* Avatar en header - botón y dropdown */
    .user-avatar-btn,
    .user-avatar-dropdown {
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .user-avatar-btn img,
    .user-avatar-dropdown img {
        object-fit: cover;
        object-position: center;
    }

    .user-avatar-dropdown {
        border-color: rgba(var(--bs-primary-rgb), 0.2);
    }
</style>

<!-- Script para inicializar el modal manualmente -->
<script>
    (function () {
        'use strict';

        // Si la página marcó SKIP_UI_INIT (por ejemplo páginas de error 40x),
        // evitamos iniciar los scripts del header y sus bucles de reintento.
        if (window.SKIP_UI_INIT) {
            console.log('⏸️ SKIP_UI_INIT: Saltando inicialización del header (error page)');
            return;
        }

        console.log('🎬 Script de header cargado');

        // ==========================================
        // OCULTAR ENLACES DE ANCHORS EN PÁGINAS NO-HOME
        // ==========================================
        function handleHomeOnlyLinks() {
            const currentPath = window.location.pathname;
            const isHomePage = currentPath === '/' || currentPath === '/home';

            console.log('📍 Ruta actual:', currentPath, '| Es home:', isHomePage);

            // Obtener todos los elementos con data-home-only
            const homeOnlyItems = document.querySelectorAll('[data-home-only]');

            homeOnlyItems.forEach(item => {
                if (isHomePage) {
                    item.style.display = ''; // Mostrar en home
                    console.log('✅ Mostrando:', item.querySelector('a').textContent);
                } else {
                    item.style.display = 'none'; // Ocultar en otras páginas
                    console.log('🚫 Ocultando:', item.querySelector('a').textContent);
                }
            });
        }

        // Ejecutar al cargar
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', handleHomeOnlyLinks);
        } else {
            handleHomeOnlyLinks();
        }

        console.log('🎬 Script de modal trigger cargado');

        function initModalTrigger() {
            console.log('🔍 Buscando elementos del modal...');
            const triggerBtn = document.getElementById('authModalTrigger');
            const modalElement = document.getElementById('authModal');

            console.log('🔘 Botón trigger:', triggerBtn ? '✅ Encontrado' : '❌ No encontrado');
            console.log('📦 Modal element:', modalElement ? '✅ Encontrado' : '❌ No encontrado');

            if (!triggerBtn || !modalElement) {
                console.log('⏳ Elementos del modal no encontrados, reintentando en 200ms...');
                setTimeout(initModalTrigger, 200);
                return;
            }

            // Verificar que Bootstrap esté disponible
            if (typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {
                console.warn('⚠️ Bootstrap Modal no disponible, reintentando en 100ms...');
                setTimeout(initModalTrigger, 100);
                return;
            }

            console.log('✅ Inicializando trigger del modal de autenticación');

            // Agregar event listener al botón
            triggerBtn.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('🔐 Click detectado en botón Identifícate');
                console.log('🔐 Bootstrap disponible:', typeof bootstrap !== 'undefined');
                console.log('🔐 Bootstrap.Modal disponible:', typeof bootstrap?.Modal !== 'undefined');

                try {
                    // Obtener o crear instancia del modal
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    console.log('📦 Instancia existente:', modalInstance ? 'Sí' : 'No, creando nueva...');

                    if (!modalInstance) {
                        modalInstance = new bootstrap.Modal(modalElement, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                        console.log('✅ Nueva instancia creada');
                    }

                    console.log('🚀 Intentando mostrar modal...');
                    modalInstance.show();
                    console.log('✅ Modal.show() ejecutado');
                } catch (error) {
                    console.error('❌ Error al abrir modal:', error);
                    console.error('Stack:', error.stack);
                }
            });

            console.log('✅ Event listener agregado al botón');
        }

        // Inicializar cuando esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initModalTrigger);
        } else {
            initModalTrigger();
        }
    })();

    // ==========================================
    // HEADER UI - INTEGRACIÓN CON SERVICIOS DE AUTENTICACIÓN
    // ==========================================
    (function () {
        'use strict';

        // Evitar inicialización adicional en páginas marcadas para omitir la UI
        if (window.SKIP_UI_INIT) {
            console.log('⏸️ SKIP_UI_INIT: Saltando Header UI (error page)');
            return;
        }

        console.log('🔐 Header UI: Inicializando');

        // Estado inicial del header según PHP
        const initialAuth = <?php echo $isAuthenticated ? 'true' : 'false'; ?>;
        const initialUser =
            <?php echo $isAuthenticated ? json_encode(['first_name' => $userName, 'role_id' => $userRole]) : 'null'; ?>;

        console.log('📊 Estado inicial PHP (frontend):', {
            initialAuth,
            initialUser
        });
        console.log('⚠️ NOTA: PHP del frontend NO puede leer sesiones del backend (puertos diferentes)');

        // VERIFICAR SESIÓN DEL BACKEND AL CARGAR LA PÁGINA
        function checkBackendSession() {
            // Esperar a que AppRouter esté disponible (tiene la configuración correcta)
            if (!window.AppRouter || !window.AppRouter.axiosInstance) {
                console.log('⏳ Esperando a AppRouter para verificar sesión...');
                setTimeout(checkBackendSession, 500);
                return;
            }

            const apiUrl = window.AppRouter.baseURL || window.ENV_CONFIG?.API_URL || 'http://localhost:3000';
            console.log('🔍 Verificando sesión del backend:', apiUrl);

            // Usar AppRouter que tiene CORS configurado correctamente
            window.AppRouter.get('/routes/user/check_session.php')
                .then(data => {
                    console.log('📥 Respuesta del backend:', data);

                    if (data.logged === true && data.user_data) {
                        console.log('✅ Sesión válida en backend');
                        console.log('👤 Usuario:', data.user_data.first_name);

                        // Verificar si el frontend no muestra usuario pero el backend sí tiene sesión
                        const authBtn = document.getElementById('authModalTrigger');
                        if (authBtn) {
                            console.log('🔄 Frontend sin sesión, pero backend SÍ tiene sesión');
                            console.log('🔄 Sincronizando header con datos del backend...');
                            window.updateHeaderAfterLogin(data.user_data);
                        } else {
                            console.log('✅ Header ya muestra usuario correctamente');
                        }
                    } else {
                        console.log('ℹ️ No hay sesión activa en el backend (esperado sin login)');

                        // Si frontend muestra usuario pero backend no tiene sesión
                        const userDropdown = document.getElementById('userDropdown');
                        if (userDropdown) {
                            console.log('⚠️ Frontend muestra usuario pero backend no tiene sesión');
                            console.log('🔄 Limpiando header...');
                            // Aquí podrías limpiar el header si es necesario
                        }
                    }
                })
                .catch(error => {
                    // CRÍTICO: 401 Unauthorized es ESPERADO cuando no hay sesión
                    // Solo mostrar error si es un problema real de conexión
                    if (error.response && error.response.status === 401) {
                        console.log('ℹ️ Sin sesión activa (401 - esperado)');
                    } else {
                        console.error('❌ Error de conexión con el backend:', error.message);
                        console.error('💡 Backend URL:', apiUrl);
                        console.error('💡 Verifica que el backend esté accesible');
                    }
                });
        }

        // ===================================
        // ACTUALIZAR AVATAR EN HEADER
        // ===================================
        function updateHeaderAvatar(profilePicture) {
            // Elementos del botón dropdown
            const avatarImgBtn = document.getElementById('headerAvatarImgBtn');
            const avatarIconBtn = document.getElementById('headerAvatarIconBtn');

            // Elementos del dropdown header
            const avatarImgDropdown = document.getElementById('headerAvatarImgDropdown');
            const avatarIconDropdown = document.getElementById('headerAvatarIconDropdown');

            console.log('📷 Header: Actualizando avatar con:', profilePicture);
            console.log('🔍 Header: Elementos encontrados:', {
                avatarImgBtn: !!avatarImgBtn,
                avatarIconBtn: !!avatarIconBtn,
                avatarImgDropdown: !!avatarImgDropdown,
                avatarIconDropdown: !!avatarIconDropdown
            });

            if (!avatarImgBtn || !avatarIconBtn || !avatarImgDropdown || !avatarIconDropdown) {
                console.warn('⚠️ Header: Elementos de avatar no encontrados, saltando actualización');
                return;
            }

            // Normalizar rutas incorrectas del backend (defensivo)
            if (profilePicture && !profilePicture.startsWith('/')) {
                if (profilePicture === 'default-avatar.png' || profilePicture === 'default-profile.png') {
                    profilePicture = '/assets/img/default-avatar.png';
                    console.log('🔧 Header: Ruta normalizada a:', profilePicture);
                }
            }

            // Si no hay foto o es null/undefined
            if (!profilePicture) {
                console.log('⚠️ Header: Sin foto de perfil, mostrando icono por defecto');
                avatarImgBtn.style.display = 'none';
                avatarIconBtn.style.display = 'block';
                avatarImgDropdown.style.display = 'none';
                avatarIconDropdown.style.display = 'block';
                return;
            }

            // Construir URL completa según el tipo de imagen
            let imageUrl;

            if (profilePicture === '/assets/img/default-avatar.png') {
                // Foto por defecto: Cargar desde frontend
                imageUrl = profilePicture;
                console.log('🖼️ Header: Cargando imagen por defecto:', imageUrl);
            } else if (profilePicture.startsWith('/uploads/')) {
                // Foto personalizada: Cargar desde BACKEND
                const backendUrl = window.ENV_CONFIG?.API_URL || 'http://localhost:3000';
                imageUrl = backendUrl + profilePicture;
                console.log('📸 Header: Cargando foto personalizada desde backend:', imageUrl);
            } else {
                // Ruta relativa o desconocida
                imageUrl = profilePicture;
                console.log('⚠️ Header: Ruta desconocida, usando tal cual:', imageUrl);
            }

            // Actualizar ambas versiones del avatar (botón y dropdown)
            avatarImgBtn.src = imageUrl;
            avatarImgBtn.style.display = 'block';
            avatarIconBtn.style.display = 'none';

            avatarImgDropdown.src = imageUrl;
            avatarImgDropdown.style.display = 'block';
            avatarIconDropdown.style.display = 'none';

            console.log('✅ Header: Avatar actualizado en botón y dropdown');
        }

        // Si ya hay un botón de logout, adjuntar LogoutService
        document.addEventListener('DOMContentLoaded', function () {
            // PASO 1: Verificar sesión del backend SIEMPRE al cargar
            console.log('🚀 DOM cargado, verificando sincronización con backend...');
            checkBackendSession();

            // PASO 2: Adjuntar LogoutService si existe el botón
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn && window.LogoutService) {
                console.log('🔗 Adjuntando LogoutService al botón de logout existente');
                window.LogoutService.attachToButton('#logoutBtn', {
                    confirm: true,
                    redirect: true,
                    redirectUrl: '/'
                });
            }

            // PASO 3: Re-inicializar modal trigger después de actualizaciones
            const modalTrigger = document.getElementById('authModalTrigger');
            if (modalTrigger) {
                console.log('🔗 Modal trigger encontrado y listo');
            }

            // PASO 4: Cargar foto de perfil si usuario está autenticado
            async function loadHeaderAvatar() {
                // Verificar si hay sesión (esperar a SessionService)
                if (!window.SessionService) {
                    console.log('⏳ Header: Esperando a SessionService para cargar avatar...');
                    setTimeout(loadHeaderAvatar, 300);
                    return;
                }

                try {
                    const sessionStatus = await window.SessionService.check();
                    if (!sessionStatus.isAuthenticated) {
                        console.log('ℹ️ Header: Usuario no autenticado, sin avatar que cargar');
                        return;
                    }

                    // Usuario autenticado: Obtener foto de perfil desde det_user.php
                    console.log('👤 Header: Usuario autenticado, cargando foto de perfil...');

                    if (!window.AppRouter) {
                        console.log('⏳ Header: Esperando a AppRouter para cargar foto...');
                        setTimeout(loadHeaderAvatar, 300);
                        return;
                    }

                    const profileData = await window.AppRouter.get('/routes/profile/det_user.php');
                    if (profileData && profileData.status === 'success' && profileData.data) {
                        console.log('✅ Header: Datos de perfil obtenidos:', profileData.data);
                        updateHeaderAvatar(profileData.data.profile_picture);
                    } else {
                        console.warn('⚠️ Header: No se pudo obtener foto de perfil, usando default');
                        updateHeaderAvatar('/assets/img/default-avatar.png');
                    }
                } catch (error) {
                    console.error('❌ Header: Error al cargar foto de perfil:', error);
                    updateHeaderAvatar('/assets/img/default-avatar.png');
                }
            }

            // Ejecutar carga de avatar
            loadHeaderAvatar();
        });

        // Función global para actualizar header después de login exitoso
        window.updateHeaderAfterLogin = function (userData) {
            console.log('🔄 Actualizando header después de login:', userData);
            console.log('📊 Origen de datos:', {
                tiene_role_id: !!userData.role_id,
                role_id_valor: userData.role_id,
                role_id_tipo: typeof userData.role_id
            });

            if (!userData) {
                console.error('❌ Datos de usuario inválidos');
                return;
            }

            const userDropdownContainer = document.querySelector('.d-flex.align-items-center.gap-2');
            if (!userDropdownContainer) {
                console.error('❌ Contenedor del header no encontrado');
                return;
            }

            // Determinar rol del usuario desde la respuesta del backend
            const roleId = parseInt(userData.role_id);
            const isAdmin = roleId === 2;
            const isUser = roleId === 1 || roleId === 3; // User o Supervisor

            // Obtener nombre para mostrar
            let displayName = userData.user_name || userData.first_name || 'Usuario';

            // Si tenemos user_name completo, usar solo el primer nombre
            if (userData.user_name && userData.user_name.includes(' ')) {
                displayName = userData.user_name.split(' ')[0];
            }

            console.log('👤 Usuario:', displayName, '| Role ID:', roleId, '| Es Admin:', isAdmin);
            console.log('🎯 Menú a mostrar:', isAdmin ? 'ADMIN DASHBOARD' : 'USER DASHBOARD');

            // Construir opciones del menú según el rol
            let menuOptions = '';
            if (isAdmin) {
                // Administrador: Dashboard (con contenido admin) + Configuración
                menuOptions = `
                <li><a class="dropdown-item py-2" href="/dashboard"><i class="bx bx-home me-2 text-primary"></i>Dashboard</a></li>   
            `;
            } else {
                // Usuario/Supervisor: Dashboard (con contenido user) + Configuración
                menuOptions = `
                <li><a class="dropdown-item py-2" href="/dashboard"><i class="bx bx-home me-2 text-primary"></i>Dashboard</a></li>
            `;
            }

            // Construir HTML del dropdown de usuario
            const userHTML = `
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Avatar del botón (img + fallback icon) -->
                        <div class="user-avatar-btn bg-white rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                            style="width: 28px; height: 28px;" id="headerAvatarBtn">
                            <img id="headerAvatarImgBtn" src="/assets/img/default-avatar.png" alt="Avatar" 
                                class="w-100 h-100 object-fit-cover" style="display: block;">
                            <i id="headerAvatarIconBtn" class="bx bx-user-circle text-primary" style="display: none; font-size: 1.5rem;"></i>
                        </div>
                        <span>${displayName}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <!-- Header del dropdown con info del usuario -->
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar-dropdown bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                                    style="width: 36px; height: 36px;" id="headerAvatarDropdown">
                                    <img id="headerAvatarImgDropdown" src="/assets/img/default-avatar.png" alt="Avatar" 
                                        class="w-100 h-100 object-fit-cover" style="display: block;">
                                    <i id="headerAvatarIconDropdown" class="bx bx-user text-white" style="display: none;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">${displayName}</div>
                                    <small class="text-muted">${isAdmin ? 'Administrador' : 'Usuario'}</small>
                                </div>
                            </div>
                        </li>

                        <!-- Opciones del menú según rol -->
                        ${menuOptions}

                        <li><hr class="dropdown-divider my-2"></li>

                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" id="logoutBtn">
                                <i class="bx bx-log-out me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            `;

            // Guardar el botón de theme
            const themeBtn = userDropdownContainer.querySelector('#themeToggle');

            // Limpiar contenedor
            userDropdownContainer.innerHTML = '';

            // Restaurar theme button
            if (themeBtn) {
                userDropdownContainer.appendChild(themeBtn);
            }

            // Agregar dropdown de usuario
            userDropdownContainer.insertAdjacentHTML('beforeend', userHTML);

            // Adjuntar LogoutService al nuevo botón
            setTimeout(function () {
                const logoutBtn = document.getElementById('logoutBtn');
                if (logoutBtn && window.LogoutService) {
                    window.LogoutService.attachToButton('#logoutBtn', {
                        confirm: true,
                        redirect: true,
                        redirectUrl: '/'
                    });
                    console.log('✅ LogoutService adjuntado al botón de logout');
                }
            }, 100);

            // Cargar foto de perfil después de actualizar el header
            setTimeout(async function () {
                try {
                    console.log('📷 Header: Cargando foto de perfil después de login...');

                    if (!window.AppRouter) {
                        console.warn('⚠️ Header: AppRouter no disponible, usando imagen por defecto');
                        updateHeaderAvatar('/assets/img/default-avatar.png');
                        return;
                    }

                    const profileData = await window.AppRouter.get('/routes/profile/det_user.php');
                    if (profileData && profileData.status === 'success' && profileData.data) {
                        console.log('✅ Header: Foto de perfil obtenida:', profileData.data.profile_picture);
                        updateHeaderAvatar(profileData.data.profile_picture);
                    } else {
                        console.warn('⚠️ Header: No se pudo obtener foto de perfil, usando default');
                        updateHeaderAvatar('/assets/img/default-avatar.png');
                    }
                } catch (error) {
                    console.error('❌ Header: Error al cargar foto de perfil:', error);
                    updateHeaderAvatar('/assets/img/default-avatar.png');
                }
            }, 200);

            console.log('✅ Header actualizado con datos del usuario');
        };

        // Escuchar evento personalizado de login exitoso desde auth-modal.js
        window.addEventListener('userLoggedIn', function (event) {
            console.log('🔔 Header: Evento userLoggedIn recibido', event.detail);
            if (event.detail && event.detail.userData) {
                window.updateHeaderAfterLogin(event.detail.userData);
            }
        });

        // CRÍTICO: Escuchar cambios de rol desde RoleService
        // Esto corrige el rol si check_session.php retorna role_id incorrecto
        window.addEventListener('roleChanged', function (event) {
            console.log('🔔 Header: Evento roleChanged recibido', event.detail);

            if (event.detail.checking) {
                console.log('⏳ Header: Verificación de rol en progreso...');
                return;
            }

            // Si hay sesión activa y el rol cambió, actualizar header
            if (window.SessionService && window.SessionService.isAuthenticated()) {
                console.log('🔄 Header: Actualizando con rol correcto del backend');

                // Obtener datos de usuario de SessionService
                window.SessionService.check().then(sessionData => {
                    if (sessionData.isAuthenticated && sessionData.userData) {
                        // Sobrescribir role_id con el valor correcto de RoleService
                        const correctedUserData = {
                            ...sessionData.userData,
                            role_id: event.detail.roleId // ✅ Usar role_id correcto de RoleService
                        };

                        console.log('🔧 Header: Datos corregidos con role_id del RoleService:',
                            correctedUserData);
                        window.updateHeaderAfterLogin(correctedUserData);
                    }
                }).catch(error => {
                    console.error('❌ Header: Error al obtener datos de sesión:', error);
                });
            }
        });

        console.log('✅ Header UI: Listo para actualizaciones dinámicas');
    })();
</script>