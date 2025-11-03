<?php
/**
 * Sección: Features
 * Características principales con cards animadas
 * HomeLab AR - Roepard Labs
 */

$features = [
    [
        'icon' => 'bx-cube',
        'title' => 'Realidad Aumentada',
        'description' => 'Visualiza tu homelab en 3D con tecnología WebXR',
        'delay' => 0
    ],
    [
        'icon' => 'bx-server',
        'title' => 'Gestión de Servicios',
        'description' => 'Controla Docker, VMs y contenedores en tiempo real',
        'delay' => 200
    ],
    [
        'icon' => 'bx-lock-alt',
        'title' => 'Seguridad Avanzada',
        'description' => 'Autenticación JWT y encriptación end-to-end',
        'delay' => 400
    ],
    [
        'icon' => 'bx-chart',
        'title' => 'Analytics en Vivo',
        'description' => 'Monitorea rendimiento con dashboards interactivos',
        'delay' => 600
    ]
];
?>

<section class="py-5 features-section" id="features">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 fw-bold mb-3">Características Poderosas</h2>
            <p class="lead text-secondary">Todo lo que necesitas para tu homelab del futuro</p>
        </div>

        <div class="row g-4">
            <?php foreach ($features as $feature): ?>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $feature['delay']; ?>">
                <div class="card card-custom h-100 text-center p-4 shadow-sm">
                    <div class="feature-icon mb-3 mx-auto">
                        <div class="icon-wrapper rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bx <?php echo $feature['icon']; ?> display-4 icon-primary"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold mb-3"><?php echo $feature['title']; ?></h5>
                    <p class="card-text text-secondary"><?php echo $feature['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Fondo de sección adaptable */
.features-section {
    background-color: var(--bs-tertiary-bg);
}

/* Card adaptable al tema */
.card-custom {
    transition: all 0.3s ease;
    background-color: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color) !important;
}

.card-custom:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(13, 110, 253, 0.15);
    border-color: var(--bs-primary) !important;
}

/* Icon wrapper con colores adaptables */
.icon-wrapper {
    transition: all 0.3s ease;
    background-color: rgba(13, 110, 253, 0.1);
}

[data-bs-theme="dark"] .icon-wrapper {
    background-color: rgba(13, 110, 253, 0.2);
}

.icon-primary {
    color: var(--bs-primary);
}

/* Hover effect mejorado */
.card-custom:hover .icon-wrapper {
    transform: scale(1.1);
    background-color: var(--bs-primary);
}

.card-custom:hover .icon-primary {
    color: white;
}

/* Asegurar visibilidad de textos */
.card-title {
    color: var(--bs-body-color);
}

.text-secondary {
    color: var(--bs-secondary-color) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .features-section {
        padding: 3rem 0 !important;
    }

    .features-section .container {
        padding-top: 2rem !important;
        padding-bottom: 2rem !important;
    }
}
</style>