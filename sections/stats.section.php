<?php
/**
 * Sección: Stats
 * Estadísticas animadas
 * HomeLab AR - Roepard Labs
 */

$stats = [
    ['number' => 1200, 'label' => 'Usuarios Activos', 'suffix' => '+', 'icon' => 'bx-user'],
    ['number' => 50, 'label' => 'Apps Desplegadas', 'suffix' => '+', 'icon' => 'bx-package'],
    ['number' => 99.9, 'label' => 'Uptime', 'suffix' => '%', 'icon' => 'bx-server'],
    ['number' => 24, 'label' => 'Soporte', 'suffix' => '/7', 'icon' => 'bx-support']
];
?>

<section class="py-5 gradient-primary" id="stats">
    <div class="container py-5">
        <div class="row g-4 text-center text-white">
            <?php foreach ($stats as $index => $stat): ?>
            <div class="col-6 col-md-3" 
                 data-aos="zoom-in" 
                 data-aos-delay="<?php echo $index * 100; ?>">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="bx <?php echo $stat['icon']; ?> display-3"></i>
                    </div>
                    <div class="stat-number display-4 fw-bold mb-2" data-count="<?php echo $stat['number']; ?>">
                        0<?php echo $stat['suffix']; ?>
                    </div>
                    <div class="stat-label text-white-50 fs-5"><?php echo $stat['label']; ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.stat-item {
    padding: 2rem 1rem;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: scale(1.05);
}

.stat-icon {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.stat-item:hover .stat-icon {
    opacity: 1;
}

.stat-number {
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
</style>
