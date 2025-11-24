/* VR-OS index: initialize UI glue and simple runtime for A-Frame components
 * This file expects AFRAME to be loaded globally and the components placed
 * at /src/aframe/*.js
 */
(function () {
  'use strict';

  function waitForAFRame(attempt) {
    attempt = attempt || 0;
    var MAX = 30;
    var INTERVAL = 100;
    return new Promise(function (resolve) {
      if (window.AFRAME) return resolve(window.AFRAME);
      if (attempt >= MAX) return resolve(null);
      setTimeout(function () { resolve(waitForAFRame(attempt + 1)); }, INTERVAL);
    });
  }

  function formatTime(d) {
    return d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
  }

  function populateAppList(scene) {
    var list = document.getElementById('vr-app-list');
    if (!list) return;

    // Try to load apps metadata from appstore
    fetch('/appstore/apps.json').then(function(res){
      if (!res.ok) throw new Error('apps.json not available');
      return res.json();
    }).then(function(json){
      var apps = (json && json.apps) ? json.apps : [];
      window.VROS = window.VROS || {};
      window.VROS.apps = apps;

      apps.forEach(function(app, i){
        var el = document.createElement('a-entity');
        el.setAttribute('geometry','primitive: circle; radius: 0.12;');
        el.setAttribute('material','color: #0ea5a4; shader: flat');
        var y = 0.55 - (i%4)*0.28;
        var x = (i<4) ? -0.05 : 0.15;
        el.setAttribute('position', x + ' ' + y + ' 0.04');
        el.setAttribute('class','clickable');
        el.setAttribute('data-appid', app.id);
        // store name for tooltips
        el.setAttribute('title', app.name || app.id);
        el.addEventListener('click', function(){
          openAppById(app.id);
        });
        list.appendChild(el);
      });
    }).catch(function(err){
      console.warn('populateAppList: failed to load apps.json', err);
      // fallback: create sample icons
      for (var i=0;i<8;i++) {
        var el = document.createElement('a-entity');
        el.setAttribute('geometry','primitive: circle; radius: 0.12;');
        el.setAttribute('material','color: #0ea5a4; shader: flat');
        var y = 0.55 - (i%4)*0.28;
        var x = (i<4) ? -0.05 : 0.15;
        el.setAttribute('position', x + ' ' + y + ' 0.04');
        el.setAttribute('class','clickable');
        (function(idx){
          el.addEventListener('click', function(){
            openApp(idx);
          });
        })(i);
        list.appendChild(el);
      }
    });
  }

  // Open app by id (uses apps metadata)
  function openAppById(appId) {
    if (!window.VROS || !window.VROS.apps) return openApp(0);
    var apps = window.VROS.apps;
    var app = apps.find(function(a){ return a.id === appId; });
    if (!app) return openApp(0);
    // set iframe if present
    var iframe = document.getElementById('vr-app-iframe');
    if (iframe) {
      iframe.src = app.entry || app.manifest || '';
    }
    // set 3D app name
    var appNameTxt = document.getElementById('vr-panel-appname');
    if (appNameTxt) appNameTxt.setAttribute('value', 'Aplicación: ' + (app.name || app.id));
    // record recent
    window.VROS.recentApps = window.VROS.recentApps || [];
    window.VROS.recentApps.unshift(app.name || app.id);
    window.VROS.recentApps = window.VROS.recentApps.slice(0,20);
    // update content fallback
    openApp(apps.indexOf(app));
  }

  function openApp(idx) {
    var panel = document.getElementById('vr-app-content');
    if (!panel) return;
    // Simple placeholder content
    panel.innerHTML = '';
    var text = document.createElement('a-text');
    text.setAttribute('value', 'App ' + (idx+1) + ' abierta');
    text.setAttribute('color','#fff');
    text.setAttribute('width','1.6');
    panel.appendChild(text);
    console.log('VR-OS: opened app', idx+1);
  }

  // Close current app
  function closeApp() {
    var panel = document.getElementById('vr-app-content');
    if (panel) panel.innerHTML = '';
    var appName = document.getElementById('vr-panel-appname');
    if (appName) appName.setAttribute('value', 'Aplicación: Ninguna');
    // push to recents
    if (!window.VROS) window.VROS = {};
    window.VROS.currentApp = null;
    console.log('VR-OS: closed app');
  }

  // Show recent apps (simple placeholder)
  function showRecents() {
    var panel = document.getElementById('vr-app-content');
    if (!panel) return;
    panel.innerHTML = '';
    var title = document.createElement('a-text');
    title.setAttribute('value', 'Recientes');
    title.setAttribute('color','#fff');
    title.setAttribute('width','1.6');
    title.setAttribute('position','0 0.2 0');
    panel.appendChild(title);

    var recents = (window.VROS && window.VROS.recentApps) ? window.VROS.recentApps : [];
    if (recents.length === 0) {
      var none = document.createElement('a-text');
      none.setAttribute('value', 'No hay apps recientes');
      none.setAttribute('color','#bbb');
      none.setAttribute('width','1.6');
      none.setAttribute('position','0 -0.1 0');
      panel.appendChild(none);
    } else {
      recents.slice(0,5).forEach(function(name, i){
        var it = document.createElement('a-text');
        it.setAttribute('value', (i+1) + '. ' + name);
        it.setAttribute('color','#fff');
        it.setAttribute('width','1.6');
        it.setAttribute('position','0 ' + (0.0 - i*0.15) + ' 0');
        panel.appendChild(it);
      });
    }
  }

  function updateClock() {
    var el = document.getElementById('vr-time');
    if (!el) return;
    el.setAttribute('value', 'Hora: ' + formatTime(new Date()));
  }

  document.addEventListener('DOMContentLoaded', function(){
    waitForAFRame().then(function(AFRAMEglobal){
      if (!AFRAMEglobal) {
        console.warn('VR-OS: AFRAME not available');
        return;
      }

      var scene = document.querySelector('a-scene');
      if (!scene) {
        console.warn('VR-OS: a-scene not found');
        return;
      }

      // Populate app list
      populateAppList(scene);

      // Update clock periodically
      updateClock();
      setInterval(updateClock, 30*1000);

      // Expose simple API
      window.VROS = window.VROS || {};
      window.VROS.openApp = openApp;
      window.VROS.scene = scene;

      // recent apps storage
      window.VROS.recentApps = window.VROS.recentApps || [];

      // Register action buttons if present
      var btnClose = document.getElementById('vr-btn-close');
      var btnRecents = document.getElementById('vr-btn-recents');
      if (btnClose) btnClose.addEventListener('click', function(){ closeApp(); });
      if (btnRecents) btnRecents.addEventListener('click', function(){ showRecents(); });

      // Enhance openApp to set panel app name and record recents
      var oldOpenApp = openApp;
      openApp = function(idx) {
        var name = 'App ' + (idx+1);
        window.VROS.currentApp = name;
        window.VROS.recentApps.unshift(name);
        // keep latest 20
        window.VROS.recentApps = window.VROS.recentApps.slice(0,20);
        var appNameTxt = document.getElementById('vr-panel-appname');
        if (appNameTxt) appNameTxt.setAttribute('value', 'Aplicación: ' + name);
        // update 3D weather position remains
        oldOpenApp(idx);
      };

      // Attach simple interaction handlers for clickable entities
      scene.addEventListener('loaded', function(){
        // enable raycaster cursor for desktop/mobile if needed
        if (!scene.querySelector('[cursor]')) {
          var camera = scene.querySelector('a-camera') || document.createElement('a-entity');
          // do nothing if existing camera; rely on default
        }
      });

      console.log('VR-OS: initialized');
    });
  });

})();
