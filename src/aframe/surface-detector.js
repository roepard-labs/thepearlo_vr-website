/* surface-detector.js
 * Lightweight surface detector placeholder.
 * Emits events when basic surface heuristics are available. For advanced
 * plane detection use WebXR hit-test and native AR features.
 */
(function () {
  if (typeof AFRAME === 'undefined') return;

  AFRAME.registerComponent('surface-detector', {
    schema: {
      enabled: { type: 'boolean', default: true }
    },
    init: function () {
      var el = this.el;
      // Basic ready signal
      setTimeout(function () {
        el.emit('surface-detected', { message: 'primitive-surface-available' });
        console.debug('surface-detector: emitted surface-detected');
      }, 500);

      // Try to detect WebXR AR support (best-effort)
      if (navigator.xr && navigator.xr.isSessionSupported) {
        navigator.xr.isSessionSupported('immersive-ar').then(function (supported) {
          el.emit('ar-support', { supported: !!supported });
          console.debug('surface-detector: ar-support', supported);
        }).catch(function (err) {
          console.debug('surface-detector: ar-support check failed', err);
        });
      }
    }
  });

})();
