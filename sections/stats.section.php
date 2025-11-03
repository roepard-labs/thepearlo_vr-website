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

<section class="py-5 stats-section" id="stats">
    <div class="container py-5">
        <div class="row g-4 text-center">
            <?php foreach ($stats as $index => $stat): ?>
                <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="stat-item">
                        <div class="stat-icon mb-3">
                            <i class="bx <?php echo $stat['icon']; ?> display-3 stat-icon-color"></i>
                        </div>
                        <div class="stat-number display-4 fw-bold mb-2" data-count="<?php echo $stat['number']; ?>">
                            0<?php echo $stat['suffix']; ?>
                        </div>
                        <div class="stat-label fs-5"><?php echo $stat['label']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    /* Fondo adaptable con gradiente sutil */
    .stats-section {
        background: linear-gradient(135deg,
                var(--bs-primary-bg-subtle) 0%,
                var(--bs-info-bg-subtle) 100%);
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, var(--bs-primary) 0%, transparent 70%);
        opacity: 0.03;
        z-index: 0;
    }

    .stats-section .container {
        position: relative;
        z-index: 1;
    }

    /* Stat item adaptable */
    .stat-item {
        padding: 2rem 1rem;
        transition: all 0.3s ease;
        border-radius: 1rem;
    }

    .stat-item:hover {
        transform: scale(1.05);
        background-color: var(--bs-body-bg);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    [data-bs-theme="dark"] .stat-item:hover {
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.05);
    }

    /* Iconos con color primario */
    .stat-icon-color {
        color: var(--bs-primary);
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .stat-item:hover .stat-icon-color {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Números destacados */
    .stat-number {
        color: var(--bs-body-color);
        text-shadow: 0 2px 10px rgba(13, 110, 253, 0.1);
    }

    /* Labels legibles */
    .stat-label {
        color: var(--bs-secondary-color);
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-item {
            padding: 1.5rem 0.5rem;
        }

        .stat-number {
            font-size: 2rem !important;
        }

        .stat-icon-color {
            font-size: 2.5rem !important;
        }

        .stat-label {
            font-size: 0.875rem !important;
        }
    }
</style>