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

<section class="py-5 bg-light" id="features">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 fw-bold mb-3">Características Poderosas</h2>
            <p class="lead text-muted">Todo lo que necesitas para tu homelab del futuro</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($features as $feature): ?>
            <div class="col-md-6 col-lg-3" 
                 data-aos="fade-up" 
                 data-aos-delay="<?php echo $feature['delay']; ?>">
                <div class="card card-custom h-100 text-center p-4 border-0">
                    <div class="feature-icon mb-3 mx-auto">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bx <?php echo $feature['icon']; ?> display-4 text-primary"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold mb-3"><?php echo $feature['title']; ?></h5>
                    <p class="card-text text-muted"><?php echo $feature['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.card-custom {
    transition: all 0.3s ease;
}

.card-custom:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 136, 255, 0.2);
}

.icon-wrapper {
    transition: all 0.3s ease;
}

.card-custom:hover .icon-wrapper {
    transform: scale(1.1);
    background-color: var(--color-primary) !important;
}

.card-custom:hover .icon-wrapper i {
    color: white !important;
}
</style>
