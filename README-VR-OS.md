# VR-OS (scaffold)

Este directorio contiene un scaffold mínimo para construir el VR-OS usando A-Frame.

Objetivos:
- Proporcionar una vista `vr-os` que muestra una escena A-Frame con un panel de apps, sidebar y barra de estado (mockup).
- Incluir componentes A-Frame reutilizables en `/src/aframe/`.
- Proveer `src/index.js` como glue runtime sin necesidad de bundler.

Archivos clave:
- `views/vr-os.view.php` - Vista PHP que usa `PearlLayout::render()` y carga la escena y scripts.
- `src/index.js` - Inicializador: rellena la lista de apps, actualiza el reloj y expone `window.VROS`.
- `src/aframe/gaze-activator.js` - Componente: dispara `gazeactivated` tras mirar.
- `src/aframe/item-deployer.js` - Componente: despliega un item en la escena (placeholder).
- `src/aframe/surface-detector.js` - Componente: emite `surface-detected` y chequea soporte AR.

Orden de carga recomendado (critico):
1. PearlLayout carga dependencias core (A-Frame desde node_modules). Asegúrate que A-Frame está disponible.
2. Cargar componentes locales `/src/aframe/*.js` (ya incluido en `vr-os.view.php`).
3. Cargar `/src/index.js` (inicializador).

Integración con routing:
- Registrar ruta en `index.php` (router principal) añadiendo:

```php
$routes['/vr-os'] = 'vr-os.view.php';
```

Notas de uso y desarrollo:
- Los componentes son placeholders y están diseñados para ser ampliados.
- Para desplegar modelos GLTF/GLB, extiende `item-deployer` para usar `a-gltf-model`.
- Para soporte AR avanzado use WebXR hit-test API; `surface-detector` sólo hace un chequeo básico.

Pruebas rápidas (desarrollo):
1. Iniciar servidor PHP desde la raíz `thepearlo_vr-website`:

```bash
php -S localhost:9000 router.php
```

2. Abrir `http://localhost:9000/vr-os` en navegador (preferiblemente Chrome/Edge para WebXR).

Siguientes pasos recomendados:
- Añadir cámara y cursor adaptado a VR y desktop si es necesario (ej.: `a-camera` con `raycaster`).
- Implementar un pequeño módulo para cargar apps desde un JSON (`appstore/apps.json`).
- Mejorar `surface-detector` con WebXR hit-test cuando se necesite AR real.

Si quieres, continúo creando una plantilla `a-camera` con cursor y un ejemplo de app GLTF loader.
