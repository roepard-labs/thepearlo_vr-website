<!-- Homelab Modal - Instalación guiada tipo lista -->
<div class="modal fade" id="homelabModal" tabindex="-1" aria-labelledby="homelabModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2" id="homelabModalLabel">
                    <i class='bx bx-cube fs-4 text-primary'></i>
                    <span>Configuración HomeLab VR/OS</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="homelab-modal-list" style="max-height:65vh; overflow:auto; scroll-behavior:smooth;">
                    <!-- Sección 1: Bienvenida -->
                    <section class="modal-section px-4 py-4 border-bottom">
                        <h5 class="text-end fw-bold mb-2">Bienvenida</h5>
                        <p class="text-muted text-end fs-5">¡Bienvenido a tu laboratorio virtual!<br>Sigue los pasos para configurar tu experiencia VR/AR personalizada.</p>
                    </section>
                    <!-- Sección 2: Temas -->
                    <section class="modal-section px-4 py-4 border-bottom">
                        <h5 class="text-end fw-bold mb-2">Tema visual</h5>
                        <div class="d-flex justify-content-end gap-3 mb-2">
                            <button class="btn btn-dark px-4" id="themeDarkBtn">Oscuro</button>
                            <button class="btn btn-light px-4" id="themeLightBtn">Claro</button>
                        </div>
                        <p class="text-end small">Puedes cambiar el tema en cualquier momento desde la configuración.</p>
                    </section>
                    <!-- Sección 3: Datos -->
                    <section class="modal-section px-4 py-4 border-bottom">
                        <h5 class="text-end fw-bold mb-2">Datos y privacidad</h5>
                        <ul class="list-unstyled text-end fs-6">
                            <li><i class="bx bx-check-circle text-success me-2"></i> Tus datos están protegidos y encriptados</li>
                            <li><i class="bx bx-check-circle text-success me-2"></i> Puedes revisar la política de privacidad</li>
                            <li><i class="bx bx-check-circle text-success me-2"></i> Acceso seguro a tus sesiones</li>
                        </ul>
                    </section>
                    <!-- Sección 4: Formato de reloj (accesibilidad) -->
                    <section class="modal-section px-4 py-4 border-bottom">
                        <h5 class="text-end fw-bold mb-2">Formato de reloj</h5>
                        <div class="d-flex justify-content-end gap-3 mb-2">
                            <button class="btn btn-outline-primary px-4" id="clock12Btn">12 horas</button>
                            <button class="btn btn-outline-primary px-4" id="clock24Btn">24 horas</button>
                        </div>
                        <p class="text-end small">Elige el formato que prefieras para la visualización de la hora.</p>
                    </section>
                    <!-- Sección 5: Colores y accesibilidad -->
                    <section class="modal-section px-4 py-4 border-bottom">
                        <h5 class="text-end fw-bold mb-2">Colores y accesibilidad</h5>
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <button class="btn btn-outline-secondary px-4" id="colorDefaultBtn">Por defecto</button>
                            <button class="btn btn-outline-warning px-4" id="colorHighContrastBtn">Alto contraste</button>
                        </div>
                        <p class="text-end small">Puedes activar el modo alto contraste para mejorar la legibilidad.</p>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success d-none" id="continueHomelabBtn">
                    <span id="homelabContinueSpinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                    <i class='bx bx-rocket me-2'></i> Continuar a HomeLab
                </button>
            </div>
        </div>
    </div>
</div>

<script>
/* Homelab modal behavior: bind safely when modal is shown.
   - Ensures handlers run when DOM is ready and modal elements exist
   - Moves modal to document.body on show to avoid stacking-context issues
   - Shows continue button only when user scrolls to bottom of list */
(function () {
    var modalEl = document.getElementById('homelabModal');
    if (!modalEl) return;

    function initBindings(container) {
        var list = container.querySelector('.homelab-modal-list');
        var contBtn = container.querySelector('#continueHomelabBtn');
        var spinner = container.querySelector('#homelabContinueSpinner');
        if (!list || !contBtn) return;

        function checkScroll() {
            var reached = Math.ceil(list.scrollTop + list.clientHeight) >= list.scrollHeight - 8;
            contBtn.classList.toggle('d-none', !reached);
        }

        if (!list._homelabScrollBound) {
            list.addEventListener('scroll', checkScroll, { passive: true });
            list._homelabScrollBound = true;
        }

        // Initial check after a short delay so layout stabilizes
        setTimeout(checkScroll, 80);

        // Theme buttons
        var themeDark = container.querySelector('#themeDarkBtn');
        var themeLight = container.querySelector('#themeLightBtn');
        if (themeDark) themeDark.addEventListener('click', function () { document.documentElement.setAttribute('data-bs-theme', 'dark'); });
        if (themeLight) themeLight.addEventListener('click', function () { document.documentElement.setAttribute('data-bs-theme', 'light'); });

        // Clock format
        var c12 = container.querySelector('#clock12Btn');
        var c24 = container.querySelector('#clock24Btn');
        if (c12) c12.addEventListener('click', function () { if (window.ClockService && window.ClockService.setHourFormat) window.ClockService.setHourFormat(12); });
        if (c24) c24.addEventListener('click', function () { if (window.ClockService && window.ClockService.setHourFormat) window.ClockService.setHourFormat(24); });

        // Color accessibility
        var colDef = container.querySelector('#colorDefaultBtn');
        var colHigh = container.querySelector('#colorHighContrastBtn');
        if (colDef) colDef.addEventListener('click', function () { document.body.classList.remove('high-contrast'); });
        if (colHigh) colHigh.addEventListener('click', function () { document.body.classList.add('high-contrast'); });

        // Continue button
        contBtn.addEventListener('click', function (e) {
            e.preventDefault();
            contBtn.setAttribute('disabled', 'disabled');
            if (spinner) spinner.classList.remove('d-none');
            setTimeout(function () { window.location.href = '/homelab'; }, 600);
        });

        // Close button fallback: explicitly hide modal via Bootstrap API if data-bs-dismiss doesn't work
        try {
            var bsModalInst = (window.bootstrap && window.bootstrap.Modal) ? window.bootstrap.Modal.getOrCreateInstance(container) : null;
            var closeBtn = container.querySelector('[data-bs-dismiss="modal"]');
            if (closeBtn) {
                closeBtn.addEventListener('click', function (ev) {
                    ev.preventDefault();
                    try { if (bsModalInst && bsModalInst.hide) bsModalInst.hide(); else container.classList.remove('show'); } catch (e) { container.classList.remove('show'); }
                });
            }
        } catch (e) {
            // ignore
        }
    }

    // Move modal to body on show to avoid stacking and z-index issues
    modalEl.addEventListener('show.bs.modal', function () {
        try { if (modalEl.parentElement !== document.body) document.body.appendChild(modalEl); } catch (e) { /* ignore */ }
    });

    modalEl.addEventListener('shown.bs.modal', function () {
        initBindings(modalEl);
        // ensure modal sits above backdrop
        setTimeout(function () {
            var backdrop = document.querySelector('.modal-backdrop');
            try {
                if (backdrop) backdrop.style.zIndex = '1050';
                modalEl.style.zIndex = '1060';
            } catch (e) { /* ignore */ }
        }, 0);
        // focus first actionable element for accessibility
        var firstBtn = modalEl.querySelector('button:not([data-bs-dismiss])');
        if (firstBtn) firstBtn.focus();
    });
})();

</script>

<style>
#homelabModal .modal-content {
    border-radius: 0.75rem;
    background: rgba(30,34,44,0.98);
    color: var(--bs-body-color);
}

#homelabModal .homelab-modal-list {
    max-height: 60vh;
    overflow: auto;
    padding: 1rem 1.25rem;
}

#homelabModal .modal-section {
    padding: 1rem 0;
}

#homelabModal .modal-footer .btn + .btn {
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    #homelabModal .homelab-modal-list { max-height: 55vh; }
}
</style>
