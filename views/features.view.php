<?php
/**
 * Vista: Features
 * Página de características detalladas
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página
$pageConfig = [
    'title' => 'Características - HomeLab AR | Roepard Labs',
    'description' => 'Descubre todas las características de HomeLab AR: visualización AR, monitoreo en tiempo real, seguridad robusta y multiplataforma.',
    'keywords' => 'características, features, AR, monitoreo, seguridad, multiplataforma',
    'css' => [],
    'js' => []
];

// Capturar contenido
ob_start();
?>

<section class="py-5 bg-body">
    <div class="container py-5">
        <!-- Header -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">
                    Características de HomeLab AR
                </h1>
                <p class="lead text-muted">
                    Descubre todas las funcionalidades que hacen de HomeLab AR la mejor solución para gestionar tu
                    infraestructura en realidad aumentada
                </p>
            </div>
        </div>

        <!-- Grid de Características -->
        <div class="row g-4">
            <!-- Feature 1: Visualización AR -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-cube-alt text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Visualización AR</h3>
                        <p class="text-muted mb-0">
                            Proyecta tu infraestructura en el mundo real usando tecnología WebXR. Visualiza servidores,
                            contenedores y servicios en 3D con información en tiempo real.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Monitoreo en Tiempo Real -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-success bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-time-five text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Tiempo Real</h3>
                        <p class="text-muted mb-0">
                            Monitoreo en vivo de CPU, RAM, disco y red. Recibe notificaciones instantáneas sobre eventos
                            críticos en tu infraestructura.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Seguridad -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-danger bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-shield-alt-2 text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Seguridad Robusta</h3>
                        <p class="text-muted mb-0">
                            Autenticación multifactor, cifrado end-to-end y auditoría de accesos. Tu infraestructura
                            siempre protegida.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 4: Multiplataforma -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-info bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-mobile text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Multiplataforma</h3>
                        <p class="text-muted mb-0">
                            Compatible con desktop, móvil, tablets y dispositivos AR/VR. Una única aplicación, múltiples
                            dispositivos.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 5: Gestión de Apps -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-warning bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-package text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Gestión de Apps</h3>
                        <p class="text-muted mb-0">
                            Despliega, actualiza y gestiona aplicaciones y servicios desde una interfaz intuitiva en AR.
                            Docker, Kubernetes y más.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 6: Dashboards Personalizables -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-secondary bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center fs-2 mb-3"
                            style="width: 64px; height: 64px;">
                            <i class='bx bx-customize text-white'></i>
                        </div>
                        <h3 class="h4 mb-3">Dashboards Personalizables</h3>
                        <p class="text-muted mb-0">
                            Crea dashboards a tu medida con widgets arrastrables. Métricas, gráficos y alertas
                            personalizadas.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                <a href="/" class="btn btn-primary btn-lg px-5">
                    <i class='bx bx-home-alt me-2'></i>
                    Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
    }

    .feature-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }
</style>

<?php
$content = ob_get_clean();

// Renderizar con AppLayout
AppLayout::render('features', ['content' => $content], $pageConfig);
?>