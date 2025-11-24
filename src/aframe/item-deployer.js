/* item-deployer.js
 * Simple A-Frame helper that deploys an entity (box) into the scene when
 * the host entity receives a 'deploy-item' event or is clicked.
 */
(function () {
  if (typeof AFRAME === 'undefined') return;

  AFRAME.registerComponent('item-deployer', {
    schema: {
      src: { type: 'string', default: '' }
    },
    init: function () {
      var el = this.el;
      var scene = el.sceneEl;

      this.deploy = (function (detail) {
        var pos = detail && detail.position ? detail.position : el.getAttribute('position') || { x: 0, y: 1, z: -1 };
        var item = document.createElement('a-box');
        item.setAttribute('position', (pos.x || pos[0] || 0) + ' ' + (pos.y || pos[1] || 1) + ' ' + (pos.z || pos[2] || -1));
        item.setAttribute('depth', '0.4');
        item.setAttribute('height', '0.4');
        item.setAttribute('width', '0.4');
        item.setAttribute('color', '#38bdf8');
        item.setAttribute('class', 'deployed-item');
        scene.appendChild(item);
        console.log('item-deployer: deployed item at', pos);
      }).bind(this);

      el.addEventListener('click', function () { this.deploy(); }.bind(this));
      el.addEventListener('deploy-item', function (e) { this.deploy(e.detail || {}); }.bind(this));
    }
  });

})();
