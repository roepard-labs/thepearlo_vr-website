/* gaze-activator.js
 * A-Frame component that fires a 'gazeactivated' event when the entity
 * is gazed at (cursorenter) for a configurable timeout.
 */
(function () {
  if (typeof AFRAME === 'undefined') return;

  AFRAME.registerComponent('gaze-activator', {
    schema: {
      timeout: { type: 'number', default: 800 }
    },
    init: function () {
      this.timer = null;
      this.isHover = false;
      var el = this.el;

      this.enter = function () {
        this.isHover = true;
        var self = this;
        this.timer = setTimeout(function () {
          if (self.isHover) {
            el.emit('gazeactivated');
          }
        }, this.data.timeout);
      }.bind(this);

      this.leave = function () {
        this.isHover = false;
        if (this.timer) { clearTimeout(this.timer); this.timer = null; }
      }.bind(this);

      el.addEventListener('mouseenter', this.enter);
      el.addEventListener('mouseleave', this.leave);
    },
    remove: function () {
      this.el.removeEventListener('mouseenter', this.enter);
      this.el.removeEventListener('mouseleave', this.leave);
      if (this.timer) clearTimeout(this.timer);
    }
  });

})();
