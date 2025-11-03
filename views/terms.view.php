<?php
/**
 * Vista: Terms of Service
 * Términos y condiciones de uso
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página
$pageConfig = [
    'title' => 'Términos y Condiciones - HomeLab AR | Roepard Labs',
    'description' => 'Lee los términos y condiciones de uso de HomeLab AR.',
    'keywords' => 'términos, condiciones, legal, uso, servicio',
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
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 fw-bold mb-3">Términos y Condiciones</h1>
                <p class="text-muted">
                    Última actualización: <?php echo date('d/m/Y'); ?>
                </p>
            </div>
        </div>

        <!-- Contenido -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="content-wrapper">
                    <!-- Aceptación -->
                    <div class="mb-5" data-aos="fade-up">
                        <h2 class="h3 mb-3">1. Aceptación de los Términos</h2>
                        <p class="text-muted">
                            Al acceder y utilizar HomeLab AR, aceptas estar sujeto a estos términos y condiciones de
                            uso. Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar nuestros
                            servicios.
                        </p>
                    </div>

                    <!-- Descripción del servicio -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="h3 mb-3">2. Descripción del Servicio</h2>
                        <p class="text-muted">
                            HomeLab AR proporciona una plataforma de realidad aumentada para visualizar y gestionar
                            infraestructuras de homelab. El servicio incluye:
                        </p>
                        <ul class="text-muted">
                            <li>Visualización AR de servidores y servicios</li>
                            <li>Monitoreo en tiempo real de recursos</li>
                            <li>Gestión de aplicaciones y contenedores</li>
                            <li>Dashboard personalizable</li>
                            <li>Notificaciones y alertas</li>
                        </ul>
                    </div>

                    <!-- Registro y cuenta -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="h3 mb-3">3. Registro y Cuenta de Usuario</h2>
                        <h3 class="h5 mb-3">3.1 Requisitos de Registro</h3>
                        <ul class="text-muted">
                            <li>Debes tener al menos 18 años de edad</li>
                            <li>Proporcionar información precisa y actualizada</li>
                            <li>Mantener la confidencialidad de tu cuenta</li>
                            <li>Notificarnos sobre cualquier uso no autorizado</li>
                        </ul>

                        <h3 class="h5 mb-3 mt-4">3.2 Responsabilidades del Usuario</h3>
                        <p class="text-muted">
                            Eres responsable de todas las actividades que ocurran bajo tu cuenta. Debes mantener tu
                            contraseña segura y notificarnos inmediatamente sobre cualquier violación de seguridad.
                        </p>
                    </div>

                    <!-- Uso aceptable -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="h3 mb-3">4. Uso Aceptable</h2>
                        <p class="text-muted mb-3">Te comprometes a NO utilizar el servicio para:</p>
                        <ul class="text-muted">
                            <li>Actividades ilegales o no autorizadas</li>
                            <li>Violar derechos de propiedad intelectual</li>
                            <li>Transmitir malware o código malicioso</li>
                            <li>Interferir con el funcionamiento del servicio</li>
                            <li>Recopilar información de otros usuarios sin consentimiento</li>
                            <li>Realizar ataques de denegación de servicio (DoS)</li>
                        </ul>
                    </div>

                    <!-- Propiedad intelectual -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="h3 mb-3">5. Propiedad Intelectual</h2>
                        <p class="text-muted">
                            Todos los derechos de propiedad intelectual sobre HomeLab AR, incluyendo el software,
                            diseño, logotipos y contenido, pertenecen a Roepard Labs o sus licenciantes. No se te
                            concede ningún derecho de propiedad sobre estos materiales.
                        </p>
                    </div>

                    <!-- Limitación de responsabilidad -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="h3 mb-3">6. Limitación de Responsabilidad</h2>
                        <p class="text-muted">
                            HomeLab AR se proporciona "tal cual" sin garantías de ningún tipo. No somos responsables de:
                        </p>
                        <ul class="text-muted">
                            <li>Pérdida de datos o interrupciones del servicio</li>
                            <li>Daños indirectos o consecuentes</li>
                            <li>Problemas causados por terceros</li>
                            <li>Incompatibilidad con tu hardware o software</li>
                        </ul>
                    </div>

                    <!-- Disponibilidad del servicio -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="600">
                        <h2 class="h3 mb-3">7. Disponibilidad del Servicio</h2>
                        <p class="text-muted">
                            Nos esforzamos por mantener el servicio disponible 24/7, pero no garantizamos un
                            funcionamiento ininterrumpido. Podemos realizar mantenimiento programado con notificación
                            previa cuando sea posible.
                        </p>
                    </div>

                    <!-- Modificaciones -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="700">
                        <h2 class="h3 mb-3">8. Modificaciones al Servicio y Términos</h2>
                        <p class="text-muted">
                            Nos reservamos el derecho de modificar o discontinuar el servicio en cualquier momento.
                            También podemos actualizar estos términos, notificándote de cambios significativos.
                        </p>
                    </div>

                    <!-- Terminación -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="800">
                        <h2 class="h3 mb-3">9. Terminación</h2>
                        <p class="text-muted">
                            Podemos suspender o terminar tu acceso al servicio si:
                        </p>
                        <ul class="text-muted">
                            <li>Violas estos términos y condiciones</li>
                            <li>Realizas actividades fraudulentas o ilegales</li>
                            <li>Dañas la reputación del servicio</li>
                            <li>Lo solicitas explícitamente</li>
                        </ul>
                    </div>

                    <!-- Ley aplicable -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="900">
                        <h2 class="h3 mb-3">10. Ley Aplicable</h2>
                        <p class="text-muted">
                            Estos términos se rigen por las leyes de México. Cualquier disputa será resuelta en los
                            tribunales competentes de Ciudad de México.
                        </p>
                    </div>

                    <!-- Contacto -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="1000">
                        <h2 class="h3 mb-3">11. Contacto</h2>
                        <p class="text-muted">
                            Para preguntas sobre estos términos, contáctanos:
                        </p>
                        <ul class="list-unstyled text-muted">
                            <li><strong>Email:</strong> legal@roepard.online</li>
                            <li><strong>Website:</strong> https://website.roepard.online</li>
                        </ul>
                    </div>
                </div>

                <!-- Botón volver -->
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="/" class="btn btn-primary btn-lg px-5">
                        <i class='bx bx-home-alt me-2'></i>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .content-wrapper h2 {
        color: var(--bs-emphasis-color);
        border-bottom: 2px solid var(--bs-primary);
        padding-bottom: 0.5rem;
    }

    .content-wrapper h3 {
        color: var(--bs-emphasis-color);
    }

    .content-wrapper ul {
        line-height: 1.8;
    }
</style>

<?php
$content = ob_get_clean();

// Renderizar con AppLayout
AppLayout::render('terms', ['content' => $content], $pageConfig);
?>