<?php
/**
 * Componente: Navbar Dashboard
 * Barra superior con breadcrumb dinámico, fecha/hora y acciones de usuario
 * HomeLab AR - Roepard Labs
 */

// Obtener datos del usuario
$userName = $_SESSION['user_name'] ?? 'Administrador';
$userFirstName = explode(' ', $userName)[0];
$userRole = $_SESSION['role_id'] ?? 2;
$roleName = $userRole == 2 ? 'Administrador' : 'Usuario';

// Detectar página actual desde la URL
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Mapear rutas a breadcrumbs y títulos
$pageInfo = [
    '/dashboard' => [
        'breadcrumb' => ['Dashboard'],
        'title' => 'Dashboard Principal',
        'icon' => 'bx-home-alt'
    ],
    '/dashboard/users' => [
        'breadcrumb' => ['Dashboard', 'Usuarios'],
        'title' => 'Gestión de Usuarios',
        'icon' => 'bx-user'
    ],
    '/dashboard/files' => [
        'breadcrumb' => ['Dashboard', 'Archivos'],
        'title' => 'Administrador de Archivos',
        'icon' => 'bx-folder-open'
    ],
    '/dashboard/settings' => [
        'breadcrumb' => ['Dashboard', 'Configuración'],
        'title' => 'Configuración del Sistema',
        'icon' => 'bx-cog'
    ],
    '/dashboard/profile' => [
        'breadcrumb' => ['Dashboard', 'Mi Perfil'],
        'title' => 'Mi Perfil de Usuario',
        'icon' => 'bx-user-circle'
    ]
];

// Obtener información de la página actual
$currentPageInfo = $pageInfo[$currentPath] ?? [
    'breadcrumb' => ['Dashboard'],
    'title' => 'Dashboard',
    'icon' => 'bx-home-alt'
];

$currentBreadcrumb = $currentPageInfo['breadcrumb'];
$pageTitle = $currentPageInfo['title'];
$pageIcon = $currentPageInfo['icon'];
?>

<nav class="navbar-dashboard border-bottom sticky-top" style="background-color: var(--bs-body-bg);">
    <div class="container-fluid px-4 py-3">
        <div class="row w-100 align-items-center">

            <!-- Left: Mobile Menu Button + Breadcrumb + Page Title -->
            <div class="col-12 col-md-7 d-flex align-items-center gap-3">

                <!-- Mobile Menu Toggle -->
                <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMobile">
                    <i class="bx bx-menu"></i>
                </button>

                <!-- Breadcrumb + Page Title -->
                <div class="page-header-section">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-1">
                        <ol class="breadcrumb mb-0">
                            <?php foreach ($currentBreadcrumb as $index => $crumb): ?>
                                <?php if ($index === count($currentBreadcrumb) - 1): ?>
                                    <li class="breadcrumb-item active" aria-current="page" id="currentPageBreadcrumb">
                                        <?php echo htmlspecialchars($crumb); ?>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item">
                                        <a href="/dashboard"
                                            class="text-decoration-none"><?php echo htmlspecialchars($crumb); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <!-- Page Title -->
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2" id="currentPageTitle">
                        <i class="bx <?php echo $pageIcon; ?> text-primary"></i>
                        <span><?php echo htmlspecialchars($pageTitle); ?></span>
                    </h5>
                </div>
            </div>

            <!-- Right: Weather + Date & Time Card -->
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end gap-3 mt-3 mt-md-0">

                <!-- Weather Widget -->
                <div class="weather-widget-mini widget-card d-flex align-items-center gap-2 px-3 py-2 rounded">

                    <!-- Weather Icon -->
                    <div class="weather-icon rounded d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="bx bx-cloud fs-4" id="weatherIcon"></i>
                    </div>

                    <!-- Weather Info -->
                    <div class="weather-info flex-grow-1">
                        <div class="fw-bold widget-main-text" id="weatherTemp">
                            --°C
                        </div>
                        <small class="widget-sub-text" id="weatherLocation">
                            Manizales
                        </small>
                    </div>

                    <!-- Weather Details (Tooltip trigger) -->
                    <div class="weather-details-trigger" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-html="true" title="" id="weatherTooltip">
                        <i class="bx bx-info-circle widget-info-icon" style="cursor: help;"></i>
                    </div>

                </div>

                <!-- Date & Time Card -->
                <div class="datetime-card widget-card d-flex align-items-center gap-2 px-3 py-2 rounded">

                    <!-- Calendar Icon -->
                    <div class="datetime-icon rounded d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="bx bx-time-five fs-4"></i>
                    </div>

                    <!-- Date & Time -->
                    <div class="datetime-info flex-grow-1">
                        <div class="fw-semibold widget-main-text" id="currentDate">
                            Cargando...
                        </div>
                        <small class="widget-sub-text d-flex align-items-center gap-1">
                            <i class="bx bx-calendar-alt"></i>
                            <span id="currentTime">--:--:--</span>
                        </small>
                    </div>

                    <!-- UTC Info (Tooltip trigger) -->
                    <div class="datetime-details-trigger" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-html="true"
                        title="<div class='text-center'><strong>Zona Horaria</strong><br>UTC-5 (COT)<br><small>Colombia Time</small></div>">
                        <i class="bx bx-info-circle widget-info-icon" style="cursor: help;"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>

<style>
    /* ===================================
   NAVBAR DASHBOARD STYLES
=================================== */
    .navbar-dashboard {
        z-index: 1020;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-header-section {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        font-size: 0.85rem;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: var(--bs-secondary);
    }

    .breadcrumb-item a {
        color: var(--bs-secondary);
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--bs-primary);
    }

    .breadcrumb-item.active {
        color: var(--bs-body-color);
        font-weight: 500;
    }

    #currentPageTitle {
        font-size: 1.25rem;
        color: var(--bs-body-color);
    }

    #currentPageTitle i {
        font-size: 1.5rem;
    }

    /* ===================================
   WIDGET CARDS - TAMAÑO UNIFORME Y SINCRONIZADO
=================================== */
    .widget-card {
        width: 210px;
        min-width: 210px;
        max-width: 210px;
        height: 68px;
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .widget-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    /* Tema Dark - Mayor contraste en hover */
    [data-bs-theme="dark"] .widget-card:hover {
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
        background-color: var(--bs-secondary-bg);
    }

    /* ===================================
   WEATHER WIDGET - TEMA DINÁMICO
=================================== */
    .weather-icon {
        background-color: rgba(255, 193, 7, 0.1);
        transition: all 0.3s ease;
    }

    .weather-icon i {
        color: #ffc107;
        transition: all 0.3s ease;
    }

    /* Tema Dark - Weather Icon */
    [data-bs-theme="dark"] .weather-icon {
        background-color: rgba(255, 193, 7, 0.15);
    }

    [data-bs-theme="dark"] .weather-icon i {
        color: #ffd54f;
    }

    .weather-widget-mini:hover .weather-icon {
        transform: scale(1.1) rotate(10deg);
    }

    /* ===================================
   DATETIME WIDGET - TEMA DINÁMICO
=================================== */
    .datetime-icon {
        background-color: rgba(13, 202, 240, 0.1);
        transition: all 0.3s ease;
    }

    .datetime-icon i {
        color: #0dcaf0;
        transition: all 0.3s ease;
    }

    /* Tema Dark - Datetime Icon */
    [data-bs-theme="dark"] .datetime-icon {
        background-color: rgba(13, 202, 240, 0.15);
    }

    [data-bs-theme="dark"] .datetime-icon i {
        color: #31d2f2;
    }

    .datetime-card:hover .datetime-icon {
        transform: scale(1.1) rotate(-10deg);
    }

    /* ===================================
   TEXTOS DE WIDGETS - TEMA DINÁMICO
=================================== */
    .widget-main-text {
        font-size: 1.1rem;
        line-height: 1.2;
        color: var(--bs-body-color);
        font-weight: 600;
    }

    .widget-sub-text {
        font-size: 0.7rem;
        color: var(--bs-secondary-color);
    }

    /* Tema Dark - Mejorar legibilidad */
    [data-bs-theme="dark"] .widget-main-text {
        color: var(--bs-gray-100);
    }

    [data-bs-theme="dark"] .widget-sub-text {
        color: var(--bs-gray-400);
    }

    /* ===================================
   INFO ICONS - TEMA DINÁMICO
=================================== */
    .widget-info-icon {
        font-size: 1.1rem;
        color: var(--bs-secondary-color);
        transition: all 0.2s ease;
    }

    .widget-info-icon:hover {
        color: var(--bs-info);
        transform: scale(1.15);
    }

    /* Tema Dark - Info Icon */
    [data-bs-theme="dark"] .widget-info-icon {
        color: var(--bs-gray-500);
    }

    [data-bs-theme="dark"] .widget-info-icon:hover {
        color: var(--bs-info);
    }

    /* ===================================
   TOOLTIPS - MEJORAR VISIBILIDAD
=================================== */
    .tooltip-inner {
        background-color: var(--bs-dark);
        color: var(--bs-light);
        max-width: 250px;
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    [data-bs-theme="dark"] .tooltip-inner {
        background-color: var(--bs-light);
        color: var(--bs-dark);
    }

    /* ===================================
   RESPONSIVE - WIDGETS ADAPTABLES
=================================== */
    @media (max-width: 991.98px) {
        .navbar-dashboard .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Widgets en móvil: full width */
        .widget-card {
            width: 100%;
            min-width: unset;
            max-width: unset;
        }
    }

    @media (max-width: 575.98px) {

        /* Widgets más compactos en móviles pequeños */
        .widget-card {
            width: 100%;
            min-width: unset;
            max-width: unset;
            height: 60px;
            padding: 0.5rem 0.75rem !important;
        }

        .weather-icon,
        .datetime-icon {
            width: 32px;
            height: 32px;
            min-width: 32px;
        }

        .weather-icon i,
        .datetime-icon i {
            font-size: 1.25rem !important;
        }

        .widget-main-text {
            font-size: 0.95rem !important;
        }

        .widget-sub-text {
            font-size: 0.65rem !important;
        }

        .widget-info-icon {
            font-size: 0.95rem !important;
        }
    }
</style>

<!-- Clock Service ya se carga en AppLayout.php, no duplicar aquí -->

<script>
    (function () {
        'use strict';

        // ===================================
        // DATE & TIME DISPLAY con ClockService
        // ===================================

        // Escuchar evento de actualización del reloj
        window.addEventListener('clockUpdated', function (event) {
            const {
                date,
                time
            } = event.detail;

            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');

            if (dateElement) dateElement.textContent = date;
            if (timeElement) timeElement.textContent = time;
        });

        // Inicialización inmediata con datos actuales
        document.addEventListener('DOMContentLoaded', function () {
            const currentDateTime = window.ClockService.getCurrentDateTime();

            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');

            if (dateElement) dateElement.textContent = currentDateTime.date;
            if (timeElement) timeElement.textContent = currentDateTime.time;
        });

        // ===================================
        // ACTUALIZAR BREADCRUMB DINÁMICAMENTE
        // ===================================
        const pageMapping = {
            '/dashboard': {
                breadcrumb: 'Dashboard',
                title: 'Dashboard Principal',
                icon: 'bx-home-alt'
            },
            '/dashboard/users': {
                breadcrumb: 'Usuarios',
                title: 'Gestión de Usuarios',
                icon: 'bx-user'
            },
            '/dashboard/files': {
                breadcrumb: 'Archivos',
                title: 'Administrador de Archivos',
                icon: 'bx-folder-open'
            },
            '/dashboard/settings': {
                breadcrumb: 'Configuración',
                title: 'Configuración del Sistema',
                icon: 'bx-cog'
            },
            '/dashboard/profile': {
                breadcrumb: 'Mi Perfil',
                title: 'Mi Perfil de Usuario',
                icon: 'bx-user-circle'
            }
        };

        function updateBreadcrumb() {
            const currentPath = window.location.pathname;
            const pageInfo = pageMapping[currentPath];

            if (!pageInfo) return;

            // Actualizar breadcrumb
            const breadcrumbItem = document.getElementById('currentPageBreadcrumb');
            if (breadcrumbItem) {
                breadcrumbItem.textContent = pageInfo.breadcrumb;
            }

            // Actualizar título de la página
            const pageTitle = document.getElementById('currentPageTitle');
            if (pageTitle) {
                pageTitle.innerHTML = `
                    <i class="bx ${pageInfo.icon} text-primary"></i>
                    <span>${pageInfo.title}</span>
                `;
            }

            console.log('📍 Breadcrumb actualizado:', currentPath, '→', pageInfo.title);
        }

        // Actualizar al cargar y cuando cambie la URL
        updateBreadcrumb();

        // Escuchar cambios de navegación (para SPAs o navegación dinámica)
        window.addEventListener('popstate', updateBreadcrumb);

        // Observar cambios en la URL (para navegación sin recargar)
        let lastPath = window.location.pathname;
        setInterval(() => {
            if (window.location.pathname !== lastPath) {
                lastPath = window.location.pathname;
                updateBreadcrumb();
            }
        }, 500);

        console.log('✅ Navbar Dashboard inicializado con breadcrumb dinámico');
    })();
</script>

<!-- Weather Service -->
<script src="../composables/weatherCheck.js"></script>

<script>
    (function () {
        'use strict';

        // ===================================
        // WEATHER WIDGET INTEGRATION
        // ===================================

        // Mapeo de códigos de OpenWeatherMap a iconos Boxicons
        const weatherIconMap = {
            // Clear sky (despejado)
            '01d': {
                icon: 'bx-sun',
                color: 'text-warning',
                bg: 'bg-warning'
            },
            '01n': {
                icon: 'bx-moon',
                color: 'text-info',
                bg: 'bg-info'
            },

            // Few clouds (pocas nubes)
            '02d': {
                icon: 'bx-cloud',
                color: 'text-secondary',
                bg: 'bg-secondary'
            },
            '02n': {
                icon: 'bx-cloud',
                color: 'text-secondary',
                bg: 'bg-secondary'
            },

            // Scattered clouds (nubes dispersas)
            '03d': {
                icon: 'bx-cloud',
                color: 'text-secondary',
                bg: 'bg-secondary'
            },
            '03n': {
                icon: 'bx-cloud',
                color: 'text-secondary',
                bg: 'bg-secondary'
            },

            // Broken clouds (nubes rotas)
            '04d': {
                icon: 'bx-cloud',
                color: 'text-muted',
                bg: 'bg-muted'
            },
            '04n': {
                icon: 'bx-cloud',
                color: 'text-muted',
                bg: 'bg-muted'
            },

            // Shower rain (lluvia ligera)
            '09d': {
                icon: 'bx-cloud-drizzle',
                color: 'text-primary',
                bg: 'bg-primary'
            },
            '09n': {
                icon: 'bx-cloud-drizzle',
                color: 'text-primary',
                bg: 'bg-primary'
            },

            // Rain (lluvia)
            '10d': {
                icon: 'bx-cloud-rain',
                color: 'text-primary',
                bg: 'bg-primary'
            },
            '10n': {
                icon: 'bx-cloud-rain',
                color: 'text-primary',
                bg: 'bg-primary'
            },

            // Thunderstorm (tormenta)
            '11d': {
                icon: 'bx-cloud-lightning',
                color: 'text-danger',
                bg: 'bg-danger'
            },
            '11n': {
                icon: 'bx-cloud-lightning',
                color: 'text-danger',
                bg: 'bg-danger'
            },

            // Snow (nieve)
            '13d': {
                icon: 'bx-cloud-snow',
                color: 'text-info',
                bg: 'bg-info'
            },
            '13n': {
                icon: 'bx-cloud-snow',
                color: 'text-info',
                bg: 'bg-info'
            },

            // Mist/Fog (niebla)
            '50d': {
                icon: 'bx-water',
                color: 'text-secondary',
                bg: 'bg-secondary'
            },
            '50n': {
                icon: 'bx-water',
                color: 'text-secondary',
                bg: 'bg-secondary'
            }
        };

        // Función para traducir descripción del clima
        const weatherDescriptions = {
            'clear sky': 'Despejado',
            'few clouds': 'Pocas nubes',
            'scattered clouds': 'Nubes dispersas',
            'broken clouds': 'Nublado',
            'shower rain': 'Lluvia ligera',
            'rain': 'Lluvia',
            'light rain': 'Lluvia ligera',
            'moderate rain': 'Lluvia moderada',
            'heavy intensity rain': 'Lluvia fuerte',
            'thunderstorm': 'Tormenta',
            'snow': 'Nieve',
            'mist': 'Neblina',
            'fog': 'Niebla',
            'overcast clouds': 'Muy nublado'
        };

        function translateWeather(description) {
            const lower = description.toLowerCase();
            return weatherDescriptions[lower] || description;
        }

        async function updateWeatherWidget() {
            try {
                // Verificar que WeatherService esté disponible
                if (typeof getDefaultWeather !== 'function') {
                    console.log('⏳ Esperando a WeatherService...');
                    setTimeout(updateWeatherWidget, 500);
                    return;
                }

                // Obtener datos del clima
                const weather = await getDefaultWeather();

                if (!weather) {
                    console.error('❌ Datos de clima inválidos:', weather);
                    return;
                }

                // weatherCheck.js devuelve datos procesados, usar _raw o los procesados
                const useRaw = weather._raw ? true : false;

                // Extraer datos importantes (compatibilidad con formato procesado y raw)
                const temp = useRaw ?
                    Math.round(weather._raw.main.temp) :
                    Math.round(weather.temperature.current);

                const feelsLike = useRaw ?
                    Math.round(weather._raw.main.feels_like) :
                    Math.round(weather.temperature.feelsLike);

                const humidity = useRaw ?
                    weather._raw.main.humidity :
                    weather.atmosphere.humidity;

                const pressure = useRaw ?
                    weather._raw.main.pressure :
                    weather.atmosphere.pressure;

                const windSpeed = useRaw ?
                    Math.round(weather._raw.wind.speed * 3.6) :
                    Math.round(weather.wind.speed * 3.6); // m/s a km/h

                const description = useRaw ?
                    weather._raw.weather[0].description :
                    weather.weather.description;

                const translatedDesc = translateWeather(description);

                const iconCode = useRaw ?
                    weather._raw.weather[0].icon :
                    weather.weather.icon;

                const cityName = useRaw ?
                    weather._raw.name :
                    weather.location.city;

                // Obtener configuración de icono
                const iconConfig = weatherIconMap[iconCode] || {
                    icon: 'bx-cloud',
                    color: 'text-secondary',
                    bg: 'bg-secondary'
                };

                // Actualizar UI
                const weatherIcon = document.getElementById('weatherIcon');
                const weatherTemp = document.getElementById('weatherTemp');
                const weatherLocation = document.getElementById('weatherLocation');
                const weatherTooltip = document.getElementById('weatherTooltip');

                if (weatherIcon) {
                    // Limpiar clases previas
                    weatherIcon.className = 'bx fs-4';
                    // Agregar nuevas clases
                    weatherIcon.classList.add(iconConfig.icon, iconConfig.color);

                    // Actualizar bg del contenedor
                    const iconContainer = weatherIcon.parentElement;
                    iconContainer.className =
                        'weather-icon rounded d-flex align-items-center justify-content-center';
                    iconContainer.classList.add(`${iconConfig.bg}-opacity-10`);
                    iconContainer.style.width = '40px';
                    iconContainer.style.height = '40px';
                }

                // Obtener símbolo de temperatura según preferencias (ANTES de usar)
                const tempUnit = localStorage.getItem('widget_prefs_temp_unit') || 'C';
                let tempSymbol = '°C';
                if (tempUnit === 'F') {
                    tempSymbol = '°F';
                } else if (tempUnit === 'K') {
                    tempSymbol = ' K';  // Kelvin no usa símbolo de grado
                }

                if (weatherTemp) {
                    weatherTemp.textContent = `${temp}${tempSymbol}`;
                }

                if (weatherLocation) {
                    weatherLocation.textContent = cityName;
                }

                // Crear tooltip con información detallada
                if (weatherTooltip) {
                    const tooltipContent = `
                        <div class="text-start">
                            <div class="mb-1"><strong>${translatedDesc}</strong></div>
                            <div class="small">
                                <div>💨 Viento: ${windSpeed} km/h</div>
                                <div>💧 Humedad: ${humidity}%</div>
                                <div>🌡️ Sensación: ${feelsLike}${tempSymbol}</div>
                                <div>🔽 Presión: ${pressure} hPa</div>
                            </div>
                        </div>
                    `;
                    weatherTooltip.setAttribute('data-bs-original-title', tooltipContent);

                    // Inicializar tooltip de Bootstrap
                    const tooltip = new bootstrap.Tooltip(weatherTooltip);
                }

                console.log('✅ Widget de clima actualizado:', {
                    temp: `${temp}${tempSymbol}`,
                    description: translatedDesc,
                    city: cityName,
                    icon: iconCode
                });

            } catch (error) {
                console.error('❌ Error al actualizar widget de clima:', error);

                // Mostrar estado de error
                const weatherTemp = document.getElementById('weatherTemp');
                const weatherLocation = document.getElementById('weatherLocation');

                if (weatherTemp) weatherTemp.textContent = '--°C';
                if (weatherLocation) weatherLocation.textContent = 'Error';
            }
        }

        // Actualizar clima al cargar
        document.addEventListener('DOMContentLoaded', function () {
            updateWeatherWidget();

            // Actualizar cada 10 minutos
            setInterval(updateWeatherWidget, 10 * 60 * 1000);
        });

        // Escuchar cambios de preferencias de widgets
        window.addEventListener('widgetPreferencesChanged', function (event) {
            console.log('🔔 Preferencias cambiadas, recargando widget de clima...');
            updateWeatherWidget();
        });

        console.log('✅ Weather Widget inicializado en navbar');
    })();
</script>