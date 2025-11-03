<?php
/**
 * Vista: Privacy Policy
 * Política de privacidad
 * HomeLab AR - Roepard Labs
 */

require_once __DIR__ . '/../layout/AppLayout.php';

// Configuración de la página
$pageConfig = [
    'title' => 'Política de Privacidad - HomeLab AR | Roepard Labs',
    'description' => 'Conoce cómo protegemos tus datos y respetamos tu privacidad en HomeLab AR.',
    'keywords' => 'privacidad, política, protección datos, GDPR, seguridad',
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
                <h1 class="display-4 fw-bold mb-3">Política de Privacidad</h1>
                <p class="text-muted">
                    Última actualización: <?php echo date('d/m/Y'); ?>
                </p>
            </div>
        </div>

        <!-- Contenido -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="content-wrapper">
                    <!-- Introducción -->
                    <div class="mb-5" data-aos="fade-up">
                        <h2 class="h3 mb-3">1. Introducción</h2>
                        <p class="text-muted">
                            En HomeLab AR (Roepard Labs), nos comprometemos a proteger tu privacidad y tus datos
                            personales. Esta política describe cómo recopilamos, usamos, almacenamos y protegemos tu
                            información cuando utilizas nuestros servicios.
                        </p>
                    </div>

                    <!-- Información que recopilamos -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="h3 mb-3">2. Información que Recopilamos</h2>
                        <h3 class="h5 mb-3">2.1 Información Personal</h3>
                        <ul class="text-muted">
                            <li>Nombre y apellidos</li>
                            <li>Dirección de correo electrónico</li>
                            <li>Número de teléfono (opcional)</li>
                            <li>Información de cuenta de usuario</li>
                        </ul>

                        <h3 class="h5 mb-3 mt-4">2.2 Información Técnica</h3>
                        <ul class="text-muted">
                            <li>Dirección IP</li>
                            <li>Tipo de navegador y dispositivo</li>
                            <li>Información de uso de la aplicación</li>
                            <li>Datos de rendimiento y métricas</li>
                        </ul>
                    </div>

                    <!-- Uso de la información -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="h3 mb-3">3. Cómo Usamos tu Información</h2>
                        <p class="text-muted mb-3">Utilizamos tu información para:</p>
                        <ul class="text-muted">
                            <li>Proporcionar y mantener nuestros servicios</li>
                            <li>Mejorar la experiencia del usuario</li>
                            <li>Comunicarnos contigo sobre actualizaciones y novedades</li>
                            <li>Garantizar la seguridad de nuestros servicios</li>
                            <li>Cumplir con obligaciones legales</li>
                        </ul>
                    </div>

                    <!-- Protección de datos -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="h3 mb-3">4. Protección de Datos</h2>
                        <p class="text-muted">
                            Implementamos medidas de seguridad técnicas y organizativas para proteger tus datos:
                        </p>
                        <ul class="text-muted">
                            <li>Cifrado SSL/TLS para todas las comunicaciones</li>
                            <li>Almacenamiento seguro de contraseñas con hashing</li>
                            <li>Autenticación de dos factores (2FA)</li>
                            <li>Auditorías de seguridad regulares</li>
                            <li>Acceso restringido a datos personales</li>
                        </ul>
                    </div>

                    <!-- Cookies -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="h3 mb-3">5. Cookies y Tecnologías Similares</h2>
                        <p class="text-muted">
                            Utilizamos cookies y tecnologías similares para mejorar tu experiencia. Puedes controlar el
                            uso de cookies a través de la configuración de tu navegador.
                        </p>
                    </div>

                    <!-- Tus derechos -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="h3 mb-3">6. Tus Derechos</h2>
                        <p class="text-muted mb-3">Tienes derecho a:</p>
                        <ul class="text-muted">
                            <li>Acceder a tus datos personales</li>
                            <li>Rectificar datos incorrectos o incompletos</li>
                            <li>Solicitar la eliminación de tus datos</li>
                            <li>Oponerte al procesamiento de tus datos</li>
                            <li>Solicitar la portabilidad de tus datos</li>
                            <li>Retirar tu consentimiento en cualquier momento</li>
                        </ul>
                    </div>

                    <!-- Contacto -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="600">
                        <h2 class="h3 mb-3">7. Contacto</h2>
                        <p class="text-muted">
                            Si tienes preguntas sobre esta política de privacidad o deseas ejercer tus derechos,
                            contáctanos:
                        </p>
                        <ul class="list-unstyled text-muted">
                            <li><strong>Email:</strong> privacy@roepard.online</li>
                            <li><strong>Website:</strong> https://website.roepard.online</li>
                        </ul>
                    </div>

                    <!-- Actualizaciones -->
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="700">
                        <h2 class="h3 mb-3">8. Actualizaciones de esta Política</h2>
                        <p class="text-muted">
                            Podemos actualizar esta política periódicamente. Te notificaremos sobre cambios
                            significativos a través de nuestro sitio web o por correo electrónico.
                        </p>
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
AppLayout::render('privacy', ['content' => $content], $pageConfig);
?>