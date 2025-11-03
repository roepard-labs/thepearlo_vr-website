<?php
/**
 * Sección: Contact
 * Formulario de contacto
 * HomeLab AR - Roepard Labs
 */
?>

<section class="py-5 bg-light" id="contact">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-4 fw-bold mb-3">Contáctanos</h2>
            <p class="lead text-muted">¿Tienes preguntas? Estamos aquí para ayudarte</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-5">
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Asunto</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
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
                            <p class="text-muted">UAM Cuajimalpa<br>Ciudad de México</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="contact-info-item">
                            <i class="bx bx-envelope text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Email</h5>
                            <p class="text-muted">dev@roepard.online</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="500">
                        <div class="contact-info-item">
                            <i class="bx bx-phone text-primary display-4 mb-3"></i>
                            <h5 class="fw-bold">Soporte</h5>
                            <p class="text-muted">24/7 Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
