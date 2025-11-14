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

    // Wait for HomelabConfig composable: resolves to instance or null after attempts
    function waitForHomelabGlobal(attempt) {
        attempt = attempt || 0;
        var MAX = 20;
        var INTERVAL = 150;
        return new Promise(function (resolve) {
            if (window.HomelabConfig && typeof window.HomelabConfig.updateConfig === 'function') return resolve(window.HomelabConfig);
            if (attempt >= MAX) return resolve(null);
            setTimeout(function () { resolve(waitForHomelabGlobal(attempt + 1)); }, INTERVAL);
        });
    }

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

        // Theme buttons - update local pendingChanges; persist only on Continue
        var themeDark = container.querySelector('#themeDarkBtn');
        var themeLight = container.querySelector('#themeLightBtn');
        // pending changes collected locally until user confirms
        var pendingChanges = {};

        // Use the global waiter which resolves to the composable or null
        function safeUpdateAndApply(payload) {
            // backwards-compat helper: no-op here, we persist on Continue
            try {
                Object.keys(payload).forEach(function (k) { pendingChanges[k] = payload[k]; });
            } catch (e) { /* ignore */ }
        }

        // helper para marcar visualmente el boton seleccionado
        function setSelected(btn, others) {
            try {
                if (!btn) return;
                btn.setAttribute('aria-pressed', 'true');
                btn.classList.add('hm-selected');
                if (Array.isArray(others)) {
                    others.forEach(function (b) {
                        if (!b) return;
                        b.setAttribute('aria-pressed', 'false');
                        b.classList.remove('hm-selected');
                    });
                }
            } catch (e) { /* ignore */ }
        }

        if (themeDark) themeDark.addEventListener('click', function () { setSelected(themeDark, [themeLight]); pendingChanges.theme = 'dark'; });
        if (themeLight) themeLight.addEventListener('click', function () { setSelected(themeLight, [themeDark]); pendingChanges.theme = 'light'; });

        // Clock format
        var c12 = container.querySelector('#clock12Btn');
        var c24 = container.querySelector('#clock24Btn');
        if (c12) c12.addEventListener('click', function () { setSelected(c12, [c24]); pendingChanges.clock_format = 12; });
        if (c24) c24.addEventListener('click', function () { setSelected(c24, [c12]); pendingChanges.clock_format = 24; });

        // Color accessibility
        var colDef = container.querySelector('#colorDefaultBtn');
        var colHigh = container.querySelector('#colorHighContrastBtn');
        if (colDef) colDef.addEventListener('click', function () { setSelected(colDef, [colHigh]); pendingChanges.color_accessibility = 'default'; });
        if (colHigh) colHigh.addEventListener('click', function () { setSelected(colHigh, [colDef]); pendingChanges.color_accessibility = 'high_contrast'; });

        // Continue button
        contBtn.addEventListener('click', function (e) {
            e.preventDefault();
            contBtn.setAttribute('disabled', 'disabled');
            if (spinner) spinner.classList.remove('d-none');
            // Persist pendingChanges + seen flag before redirecting
            var toPersist = Object.assign({}, pendingChanges || {});
            toPersist.seen_homelab_modal = 1;
            console.debug('homelabModal: persisting', toPersist);

            // small helper to wait for AppRouter if needed
            function waitForRouter(attempt) {
                attempt = attempt || 0;
                var MAX = 20;
                var INTERVAL = 150;
                return new Promise(function (resolve, reject) {
                    if (window.AppRouter && typeof window.AppRouter.post === 'function') return resolve(window.AppRouter);
                    if (attempt >= MAX) return reject(new Error('AppRouter no disponible'));
                    setTimeout(function () { resolve(waitForRouter(attempt + 1)); }, INTERVAL);
                });
            }

            waitForHomelabGlobal().then(function (hc) {
                if (hc && typeof hc.updateConfig === 'function') {
                    console.debug('homelabModal: using HomelabConfig.updateConfig');
                    return hc.updateConfig(toPersist).then(function (r) { console.debug('homelabModal: persisted via HomelabConfig', r); }).catch(function (err) { console.warn('homelabModal: error using HomelabConfig', err); });
                }
                // fallback to AppRouter.post directly
                return waitForRouter().then(function (router) {
                    console.debug('homelabModal: falling back to AppRouter.post');
                    return router.post('/routes/homelab/up_config.php', toPersist).then(function (res) { console.debug('homelabModal: persisted via AppRouter', res); }).catch(function (err) { console.warn('homelabModal: AppRouter.post failed', err); });
                }).catch(function (err) { console.warn('homelabModal: AppRouter not available', err); });
            }).finally(function () {
                setTimeout(function () { window.location.href = '/homelab'; }, 600);
            });
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
        // Try to sync UI with backend config (if HomelabConfig available)
        try {
            waitForHomelabGlobal().then(function (hc) {
                if (!hc) return null;
                var cfg = (hc && hc.state && hc.state.config) ? hc.state.config : null;
                if (!cfg && hc && typeof hc.fetchConfig === 'function') {
                    return hc.fetchConfig();
                }
                return cfg;
            }).then(function (cfg) {
                if (!cfg) return;
                // theme
                try {
                    var tDark = modalEl.querySelector('#themeDarkBtn');
                    var tLight = modalEl.querySelector('#themeLightBtn');
                    if (cfg.theme === 'dark') { if (tDark) tDark.classList.add('hm-selected'); if (tLight) tLight.classList.remove('hm-selected'); }
                    else { if (tLight) tLight.classList.add('hm-selected'); if (tDark) tDark.classList.remove('hm-selected'); }
                } catch (e) { /* ignore */ }
                // clock
                try {
                    var b12 = modalEl.querySelector('#clock12Btn');
                    var b24 = modalEl.querySelector('#clock24Btn');
                    if (parseInt(cfg.clock_format || 24, 10) === 12) { if (b12) b12.classList.add('hm-selected'); if (b24) b24.classList.remove('hm-selected'); }
                    else { if (b24) b24.classList.add('hm-selected'); if (b12) b12.classList.remove('hm-selected'); }
                } catch (e) { /* ignore */ }
                // color accessibility
                try {
                    var colDef = modalEl.querySelector('#colorDefaultBtn');
                    var colHigh = modalEl.querySelector('#colorHighContrastBtn');
                    if (cfg.color_accessibility === 'high_contrast') { if (colHigh) colHigh.classList.add('hm-selected'); if (colDef) colDef.classList.remove('hm-selected'); }
                    else { if (colDef) colDef.classList.add('hm-selected'); if (colHigh) colHigh.classList.remove('hm-selected'); }
                } catch (e) { /* ignore */ }
            }).catch(function () { /* ignore errors */ });
        } catch (e) { /* ignore */ }
    });
})();

</script>

<style>
#homelabModal .modal-content {
    border-radius: 0.75rem;
    background: rgba(30,34,44,0.98);
    color: var(--bs-body-color);
}

/* Visual selection helper for modal buttons */
.hm-selected {
    box-shadow: 0 0 0 3px rgba(13,110,253,0.08) inset, 0 0 0 2px rgba(13,110,253,0.12);
    transform: translateY(-1px);
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
