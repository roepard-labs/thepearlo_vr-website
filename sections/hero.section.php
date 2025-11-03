<?php
/**
 * Sección: Hero
 * Sección principal con animaciones AOS
 * HomeLab AR - Roepard Labs
 */
?>

<section class="hero-section" id="hero">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="display-2 fw-bold mb-4 hero-title">
                    Bienvenido a <span class="text-primary">HomeLab AR</span>
                </h1>
                <p class="lead mb-4 hero-subtitle">
                    Despliega y gestiona servicios virtuales en realidad aumentada.
                    La próxima generación de homelab está aquí.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/homelab" class="btn btn-primary btn-lg shadow-lg">
                        <i class="bx bx-rocket me-2"></i> Comenzar Ahora
                    </a>
                    <a href="#features" class="btn btn-outline-primary btn-lg">
                        <i class="bx bx-info-circle me-2"></i> Conoce Más
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="hero-image-wrapper text-center">
                    <img src="/assets/images/hero-illustration.svg" alt="HomeLab AR Illustration"
                        class="img-fluid animate__animated animate__pulse animate__infinite animate__slow"
                        onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 800 600%22%3E%3Cdefs%3E%3ClinearGradient id=%22grad1%22 x1=%220%25%22 y1=%220%25%22 x2=%22100%25%22 y2=%22100%25%22%3E%3Cstop offset=%220%25%22 style=%22stop-color:%230d6efd;stop-opacity:0.3%22/%3E%3Cstop offset=%22100%25%22 style=%22stop-color:%236610f2;stop-opacity:0.3%22/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect fill=%22url(%23grad1)%22 width=%22800%22 height=%22600%22 rx=%2220%22/%3E%3Cg fill=%22none%22 stroke=%22%230d6efd%22 stroke-width=%223%22 opacity=%220.4%22%3E%3Ccircle cx=%22400%22 cy=%22300%22 r=%22200%22/%3E%3Ccircle cx=%22400%22 cy=%22300%22 r=%22150%22/%3E%3Ccircle cx=%22400%22 cy=%22300%22 r=%22100%22/%3E%3Cpath d=%22M200 300h400M400 100v400%22/%3E%3C/g%3E%3Ctext x=%2250%25%22 y=%2245%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22system-ui,-apple-system,sans-serif%22 font-size=%2248%22 font-weight=%22bold%22 fill=%22%230d6efd%22%3EHomeLab AR%3C/text%3E%3Ctext x=%2250%25%22 y=%2255%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22system-ui,-apple-system,sans-serif%22 font-size=%2224%22 fill=%22%236c757d%22%3ERealidad Aumentada%3C/text%3E%3C/svg%3E';">
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4" data-aos="fade-up"
        data-aos-delay="1000">
        <a href="#features" class="scroll-link text-decoration-none">
            <i class="bx bx-chevron-down bx-fade-down fs-1"></i>
        </a>
    </div>
</section>

<style>
.hero-section {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg,
            var(--bs-primary-bg-subtle) 0%,
            var(--bs-secondary-bg-subtle) 50%,
            var(--bs-tertiary-bg) 100%);
    padding: 2rem 0;
}

.hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 30% 50%, var(--bs-primary) 0%, transparent 50%),
        radial-gradient(circle at 70% 50%, var(--bs-info) 0%, transparent 50%);
    opacity: 0.05;
    z-index: 0;
}

.hero-section .container {
    position: relative;
    z-index: 1;
}

/* Títulos adaptables al tema */
.hero-title {
    color: var(--bs-body-color);
}

.hero-subtitle {
    color: var(--bs-secondary-color);
}

/* Botones mejorados */
.btn-outline-primary {
    border-width: 2px;
    font-weight: 500;
}

.btn-outline-primary:hover {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Scroll indicator adaptable */
.scroll-link {
    color: var(--bs-primary);
    transition: all 0.3s ease;
}

.scroll-link:hover {
    color: var(--bs-secondary);
    transform: scale(1.1);
}

.scroll-indicator {
    animation: bounce 2s infinite;
    z-index: 10;
}

@keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0) translateX(-50%);
    }

    40% {
        transform: translateY(-10px) translateX(-50%);
    }

    60% {
        transform: translateY(-5px) translateX(-50%);
    }
}

/* Mejoras de imagen */
.hero-image-wrapper img {
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.1));
}

[data-bs-theme="dark"] .hero-image-wrapper img {
    filter: drop-shadow(0 10px 30px rgba(255, 255, 255, 0.1));
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section {
        min-height: auto;
        padding: 4rem 0;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
    }
}
</style>