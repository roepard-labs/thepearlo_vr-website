<?php
/**
 * Sección: Contact
 * Formulario de contacto
 * HomeLab AR - Roepard Labs
 */
?>

<section class="py-5 contact-section" id="contact">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 fw-bold mb-3">Contáctanos</h2>
            <p class="lead text-secondary">¿Tienes preguntas? Estamos aquí para ayudarte</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card contact-card shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-5">
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" placeholder="Juan Pérez" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="juan@ejemplo.com"
                                        required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Asunto</label>
                                    <input type="text" class="form-control" id="subject"
                                        placeholder="Consulta sobre HomeLab AR" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="message" rows="5"
                                        placeholder="Escribe tu mensaje aquí..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bx bx-send me-2"></i> Enviar Mensaje
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="row g-4 mt-4">
                    <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="contact-info-item">
                            <i class="bx bx-map text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Ubicación</h5>
                            <p class="text-secondary">UAM<br>Manizales</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="contact-info-item">
                            <i class="bx bx-envelope text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Email</h5>
                            <p class="text-secondary">contact@roepard.online</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="500">
                        <div class="contact-info-item">
                            <i class="bx bx-phone text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Soporte</h5>
                            <p class="text-secondary">24/7 Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Fondo adaptable de sección */
.contact-section {
    background-color: var(--bs-tertiary-bg);
}

/* Card del formulario adaptable */
.contact-card {
    background-color: var(--bs-body-bg);
    border: 1px solid var(--bs-border-color) !important;
}

/* Labels del formulario */
.form-label {
    color: var(--bs-body-color);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* Inputs y textarea adaptables */
.form-control {
    background-color: var(--bs-body-bg);
    border-color: var(--bs-border-color);
    color: var(--bs-body-color);
}

.form-control:focus {
    background-color: var(--bs-body-bg);
    border-color: var(--bs-primary);
    color: var(--bs-body-color);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-control::placeholder {
    color: var(--bs-secondary-color);
    opacity: 0.6;
}

/* Contact info items */
.contact-info-item {
    padding: 1.5rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.contact-info-item:hover {
    background-color: var(--bs-body-bg);
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

[data-bs-theme="dark"] .contact-info-item:hover {
    box-shadow: 0 5px 20px rgba(255, 255, 255, 0.05);
}

.contact-info-item h5 {
    color: var(--bs-body-color);
}

.contact-info-item i {
    transition: transform 0.3s ease;
}

.contact-info-item:hover i {
    transform: scale(1.1);
}

/* Responsive */
@media (max-width: 768px) {
    .contact-section .card-body {
        padding: 2rem !important;
    }

    .contact-info-item {
        padding: 1rem;
    }
}
</style>