
/* homelabConfigCheck.js
 * Cliente ligero para sincronizar la configuración Homelab con el backend
 * Usa `window.AppRouter` (Axios) expuesto por `composables/router.js`
/* homelabConfigCheck.js
 * Cliente ligero para sincronizar la configuración Homelab con el backend
 * Usa `window.AppRouter` (Axios) expuesto por `composables/router.js`
 * - Obtiene config: GET /routes/homelab/list_config.php
 * - Actualiza config: POST /routes/homelab/up_config.php
 * Exports: window.HomelabConfig
 */

(function () {
	'use strict';

	const RETRY_INTERVAL = 250; // ms
	const MAX_RETRIES = 20;

	function waitForRouter(attempt = 0) {
		return new Promise((resolve, reject) => {
			if (window.AppRouter && typeof window.AppRouter.get === 'function') return resolve(window.AppRouter);
			if (attempt >= MAX_RETRIES) return reject(new Error('AppRouter no disponible'));
			setTimeout(() => resolve(waitForRouter(attempt + 1)), RETRY_INTERVAL);
		});
	}

	const state = {
		loaded: false,
		config: null,
		error: null
	};

	async function fetchConfig() {
		try {
			const router = await waitForRouter();
			const res = await router.get('/routes/homelab/list_config.php');
			// Router.get may return either a wrapper {status,data} or the raw config object.
			const payload = (res && res.data) ? res.data : res;
			console.debug('homelabConfigCheck: fetchConfig payload', payload);

			if (payload && payload.status === 'success') {
				state.config = payload.data;
			} else if (payload && (payload.id || payload.user_id || payload.theme)) {
				// Backend returned raw config object directly
				state.config = payload;
			}

			if (!state.config) {
				throw new Error((payload && payload.message) || 'Respuesta inesperada');
			}

			state.loaded = true;
			state.error = null;
			window.dispatchEvent(new CustomEvent('homelab:configLoaded', { detail: state.config }));
			// If user hasn't seen modal, show it (if present)
			tryShowModalIfNeeded();
			return state.config;
		} catch (err) {
			state.error = err;
			console.error('homelabConfigCheck: fetchConfig error', err);
			window.dispatchEvent(new CustomEvent('homelab:configError', { detail: err }));
			throw err;
		}
	}

	async function updateConfig(payload = {}) {
		try {
			const router = await waitForRouter();
			const res = await router.post('/routes/homelab/up_config.php', payload);
			const result = (res && res.data) ? res.data : res;
			console.debug('homelabConfigCheck: updateConfig result', result);
			if (result && result.status === 'success') {
				// update local state with returned data if present
				state.config = result.data || state.config;
				window.dispatchEvent(new CustomEvent('homelab:configUpdated', { detail: state.config }));
				return state.config;
			}
			// If backend returned raw config without wrapper, accept it
			if (result && (result.id || result.user_id || result.theme)) {
				state.config = result;
				window.dispatchEvent(new CustomEvent('homelab:configUpdated', { detail: state.config }));
				return state.config;
			}
			// backend returned error-like response
			throw new Error((result && result.message) || 'Error updating config');
		} catch (err) {
			console.error('homelabConfigCheck: updateConfig error', err);
			window.dispatchEvent(new CustomEvent('homelab:configUpdateError', { detail: err }));
			throw err;
		}
	}

	function applyTheme(theme) {
		if (!theme) return;
		try {
			document.documentElement.setAttribute('data-bs-theme', theme);
		} catch (e) { /* ignore */ }
	}

	function applyColorAccessibility(mode) {
		if (!mode) return;
		if (mode === 'high_contrast') document.body.classList.add('high-contrast');
		else document.body.classList.remove('high-contrast');
	}

	function tryShowModalIfNeeded() {
		try {
			if (!state.config) return;
			if (parseInt(state.config.seen_homelab_modal || 0, 10) === 0) {
				const modalEl = document.getElementById('homelabModal');
				if (modalEl && window.bootstrap && window.bootstrap.Modal) {
					const bs = window.bootstrap.Modal.getOrCreateInstance(modalEl);
					bs.show();
					// When modal is hidden, mark as seen
					modalEl.addEventListener('hidden.bs.modal', function onHidden() {
						modalEl.removeEventListener('hidden.bs.modal', onHidden);
						// set seen flag and persist
						updateConfig({ seen_homelab_modal: 1 }).catch(() => { /* ignore errors here */ });
					});
				}
			}
		} catch (e) { console.warn('homelabConfigCheck: tryShowModalIfNeeded', e); }
	}

	// Public API
	// NOTE: applyTheme and applyColorAccessibility are intentionally kept internal
	// to prevent other scripts from changing global UI directly. Theme is applied
	// only once on initial load after fetchConfig.
	const API = {
		state,
		fetchConfig,
		updateConfig
	};

	// Auto init on DOMContentLoaded
	document.addEventListener('DOMContentLoaded', function () {
		// Small delay so router can initialize in legacy pages
		setTimeout(() => {
			fetchConfig().then(cfg => {
				// apply theme/accessibility if present
				if (cfg) {
					applyTheme(cfg.theme);
					applyColorAccessibility(cfg.color_accessibility);
				}
			}).catch(() => {/* already handled events */});
		}, 50);
	});

	// Expose globally
	window.HomelabConfig = API;

})();
