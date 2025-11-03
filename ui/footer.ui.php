<?php
/**
 * Componente: Footer
 * Footer del sitio
 * HomeLab AR - Roepard Labs
 */
?>

<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            <!-- Columna 1: Sobre nosotros -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">
                    <i class="bx bx-cube-alt text-primary"></i> HomeLab AR
                </h5>
                <p class="text-white-50">
                    Plataforma de realidad aumentada para gestión de infraestructura homelab. 
                    Proyecto piloto para la UAM Cuajimalpa.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="bx bxl-github"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="bx bxl-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="bx bxl-linkedin"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="bx bxl-discord"></i>
                    </a>
                </div>
            </div>
            
            <!-- Columna 2: Enlaces rápidos -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Enlaces</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/" class="text-white-50 text-decoration-none">Inicio</a>
                    </li>
                    <li class="mb-2">
                        <a href="#features" class="text-white-50 text-decoration-none">Características</a>
                    </li>
                    <li class="mb-2">
                        <a href="#about" class="text-white-50 text-decoration-none">Acerca de</a>
                    </li>
                    <li class="mb-2">
                        <a href="/homelab" class="text-white-50 text-decoration-none">VR/AR</a>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 3: Recursos -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Recursos</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/docs" class="text-white-50 text-decoration-none">Documentación</a>
                    </li>
                    <li class="mb-2">
                        <a href="/api" class="text-white-50 text-decoration-none">API</a>
                    </li>
                    <li class="mb-2">
                        <a href="/appstore" class="text-white-50 text-decoration-none">AppStore</a>
                    </li>
                    <li class="mb-2">
                        <a href="#contact" class="text-white-50 text-decoration-none">Soporte</a>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 4: Legal -->
            <div class="col-lg-2 col-md-4">
                <h6 class="fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/privacy" class="text-white-50 text-decoration-none">Privacidad</a>
                    </li>
                    <li class="mb-2">
                        <a href="/terms" class="text-white-50 text-decoration-none">Términos</a>
                    </li>
                    <li class="mb-2">
                        <a href="/license" class="text-white-50 text-decoration-none">Licencia</a>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 5: Newsletter -->
            <div class="col-lg-2">
                <h6 class="fw-bold mb-3">Newsletter</h6>
                <p class="text-white-50 small">Recibe actualizaciones</p>
                <form id="newsletterForm">
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control" placeholder="Tu email" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bx bx-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <hr class="my-4 border-secondary">
        
        <!-- Copyright -->
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-white-50 small mb-0">
                    © <?php echo date('Y'); ?> HomeLab AR - Roepard Labs. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="text-white-50 small mb-0">
                    Hecho con <i class="bx bx-heart text-danger"></i> para la UAM
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
footer a:hover {
    color: var(--color-primary) !important;
}

footer .btn-outline-light:hover {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
}
</style>
