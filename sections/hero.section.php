<?php
/**
 * Sección: Hero
 * Sección principal con animaciones AOS
 * HomeLab AR - Roepard Labs
 */
?>

<section class="hero-section gradient-primary" id="hero">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="display-2 fw-bold text-white mb-4">
                    Bienvenido a <span class="text-gradient">HomeLab AR</span>
                </h1>
                <p class="lead text-white-50 mb-4">
                    Despliega y gestiona servicios virtuales en realidad aumentada.
                    La próxima generación de homelab está aquí.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="/homelab" class="btn btn-light btn-lg shadow">
                        <i class="bx bx-rocket me-2"></i> Comenzar Ahora
                    </a>
                    <a href="#features" class="btn btn-outline-light btn-lg">
                        <i class="bx bx-info-circle me-2"></i> Conoce Más
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="hero-image-wrapper text-center">
                    <img src="/assets/images/hero-illustration.svg" 
                         alt="HomeLab AR Illustration" 
                         class="img-fluid animate__animated animate__pulse animate__infinite animate__slow">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4" data-aos="fade-up" data-aos-delay="1000">
        <a href="#features" class="text-white text-decoration-none">
            <i class="bx bx-chevron-down bx-fade-down fs-1"></i>
        </a>
    </div>
</section>

<style>
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 136, 255, 0.1), rgba(0, 102, 204, 0.2));
    z-index: 0;
}

.hero-section .container {
    position: relative;
    z-index: 1;
}

.scroll-indicator {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0) translateX(-50%);
    }
    40% {
        transform: translateY(-10px) translateX(-50%);
    }
    60% {
        transform: translateY(-5px) translateX(-50%);
    }
}
</style>
