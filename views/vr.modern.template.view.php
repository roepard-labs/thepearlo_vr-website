<!doctype html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HomeLab AR - Experiencia VR/AR con A-Frame">

    <title>HomeLab VR - Template VR/AR Moderno</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Boxicons CSS -->
    <link href="../node_modules/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">

    <!-- SweetAlert2 CSS -->
    <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Notyf CSS -->
    <link href="../node_modules/notyf/notyf.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/variables.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- ============================================ -->
    <!-- A-FRAME & VR/AR LIBRARIES -->
    <!-- ============================================ -->
    <script src="../node_modules/aframe/dist/aframe-master.min.js"></script>
    <script src="../node_modules/webvr-polyfill/build/webvr-polyfill.min.js"></script>

    <!-- Three.js (Module) -->
    <script type="importmap">
    {
      "imports": {
        "three": "../node_modules/three/build/three.module.js",
        "three/addons/": "../node_modules/three/examples/jsm/"
      }
    }
    </script>

    <style>
        body {
            margin: 0;
            overflow: hidden;
        }

        #vr-ui-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            pointer-events: none;
        }

        #vr-ui-overlay > * {
            pointer-events: auto;
        }

        .vr-info-panel {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .vr-stats {
            font-family: monospace;
            font-size: 0.875rem;
            color: #00ff88;
        }

        .vr-button {
            background: linear-gradient(135deg, #00ff88 0%, #008866 100%);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .vr-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 255, 136, 0.3);
        }

        .vr-button:active {
            transform: translateY(0);
        }

        .vr-controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .vr-control-item {
            background: rgba(0, 255, 136, 0.1);
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 255, 136, 0.2);
        }

        .vr-control-item:hover {
            background: rgba(0, 255, 136, 0.2);
            border-color: rgba(0, 255, 136, 0.4);
        }

        .vr-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #00ff88;
            color: #000;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        a-scene {
            width: 100vw;
            height: 100vh;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body>
    <!-- ============================================ -->
    <!-- VR UI OVERLAY -->
    <!-- ============================================ -->
    <div id="vr-ui-overlay" class="fade-in">
        <!-- Top Bar -->
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12">
                    <div class="vr-info-panel">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">
                                    <i class="bx bx-cube-alt text-success"></i>
                                    HomeLab VR - Modo Inmersivo
                                </h5>
                                <div class="vr-stats">
                                    <span class="vr-badge">A-Frame 1.7.1</span>
                                    <span class="vr-badge">Three.js</span>
                                    <span class="vr-badge">WebXR</span>
                                    <span id="fps-counter" class="ms-2">FPS: --</span>
                                </div>
                            </div>
                            <div>
                                <button class="vr-button" id="toggle-ui-btn">
                                    <i class="bx bx-hide"></i> Ocultar UI
                                </button>
                                <button class="vr-button ms-2" id="enter-vr-btn">
                                    <i class="bx bx-glasses"></i> Entrar VR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Panel -->
        <div id="controls-panel" class="container mt-3">
            <div class="vr-info-panel">
                <h6 class="text-success mb-3">
                    <i class="bx bx-joystick"></i> Controles
                </h6>
                <div class="vr-controls-grid">
                    <div class="vr-control-item">
                        <strong>Añadir Cubo</strong>
                        <button class="btn btn-sm btn-success mt-2 w-100" onclick="addCube()">
                            <i class="bx bx-cube"></i> Crear
                        </button>
                    </div>
                    <div class="vr-control-item">
                        <strong>Añadir Esfera</strong>
                        <button class="btn btn-sm btn-info mt-2 w-100" onclick="addSphere()">
                            <i class="bx bx-circle"></i> Crear
                        </button>
                    </div>
                    <div class="vr-control-item">
                        <strong>Cambiar Fondo</strong>
                        <button class="btn btn-sm btn-warning mt-2 w-100" onclick="changeSky()">
                            <i class="bx bx-palette"></i> Cambiar
                        </button>
                    </div>
                    <div class="vr-control-item">
                        <strong>Limpiar Escena</strong>
                        <button class="btn btn-sm btn-danger mt-2 w-100" onclick="clearScene()">
                            <i class="bx bx-trash"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- A-FRAME SCENE -->
    <!-- ============================================ -->
    <a-scene
        vr-mode-ui="enabled: true"
        embedded
        stats="false"
        background="color: #1a1a1a"
        fog="type: linear; color: #1a1a1a; near: 10; far: 50">

        <!-- Assets -->
        <a-assets>
            <img id="sky-texture" src="https://cdn.aframe.io/360-image-gallery-boilerplate/img/city.jpg" crossorigin="anonymous">
        </a-assets>

        <!-- Camera -->
        <a-entity id="camera-rig" position="0 1.6 0">
            <a-camera id="main-camera" look-controls wasd-controls>
                <a-cursor
                    color="#00ff88"
                    raycaster="objects: .interactive"
                    fuse="true"
                    fuse-timeout="1500">
                </a-cursor>
            </a-camera>
        </a-entity>

        <!-- Lighting -->
        <a-light type="ambient" color="#fff" intensity="0.5"></a-light>
        <a-light type="directional" color="#fff" intensity="0.8" position="2 4 2"></a-light>
        <a-light type="point" color="#00ff88" intensity="1" position="0 2 0"></a-light>

        <!-- Ground -->
        <a-plane
            position="0 0 0"
            rotation="-90 0 0"
            width="20"
            height="20"
            color="#222"
            shadow="receive: true"
            class="interactive">
        </a-plane>

        <!-- Grid Helper -->
        <a-entity
            geometry="primitive: plane; width: 20; height: 20"
            material="color: #00ff88; opacity: 0.1; transparent: true; wireframe: true"
            rotation="-90 0 0"
            position="0 0.01 0">
        </a-entity>

        <!-- Demo Objects -->
        <a-box
            id="demo-cube"
            position="-2 1 -3"
            rotation="0 45 0"
            color="#00ff88"
            shadow="cast: true"
            animation="property: rotation; to: 0 405 0; loop: true; dur: 4000; easing: linear"
            class="interactive">
        </a-box>

        <a-sphere
            id="demo-sphere"
            position="0 1.5 -3"
            radius="0.5"
            color="#0088ff"
            shadow="cast: true"
            animation="property: position; to: 0 2 -3; dir: alternate; loop: true; dur: 2000; easing: easeInOutQuad"
            class="interactive">
        </a-sphere>

        <a-cylinder
            id="demo-cylinder"
            position="2 1 -3"
            radius="0.3"
            height="1.5"
            color="#ff00aa"
            shadow="cast: true"
            class="interactive">
        </a-cylinder>

        <!-- Text -->
        <a-text
            value="HomeLab VR\nPowered by npm"
            position="0 2.5 -4"
            align="center"
            color="#00ff88"
            width="6"
            font="monoid">
        </a-text>

        <!-- Sky -->
        <a-sky id="scene-sky" color="#87ceeb"></a-sky>

    </a-scene>

    <!-- ============================================ -->
    <!-- JAVASCRIPT DEPENDENCIES -->
    <!-- ============================================ -->

    <!-- jQuery -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- Notyf -->
    <script src="../node_modules/notyf/notyf.min.js"></script>

    <!-- Custom VR Logic -->
    <script>
        // ========================================
        // VR SCENE MANAGEMENT
        // ========================================

        const scene = document.querySelector('a-scene');
        const camera = document.querySelector('#main-camera');
        const sky = document.querySelector('#scene-sky');
        let objectCount = 0;
        let isUIVisible = true;

        // Initialize Notyf
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' }
        });

        // FPS Counter
        let frameCount = 0;
        let lastTime = performance.now();
        
        function updateFPS() {
            frameCount++;
            const currentTime = performance.now();
            
            if (currentTime >= lastTime + 1000) {
                const fps = Math.round((frameCount * 1000) / (currentTime - lastTime));
                document.getElementById('fps-counter').textContent = `FPS: ${fps}`;
                frameCount = 0;
                lastTime = currentTime;
            }
            
            requestAnimationFrame(updateFPS);
        }
        
        updateFPS();

        // ========================================
        // SCENE MANIPULATION FUNCTIONS
        // ========================================

        function addCube() {
            objectCount++;
            const cube = document.createElement('a-box');
            
            const x = (Math.random() - 0.5) * 8;
            const z = (Math.random() - 0.5) * 8 - 3;
            
            cube.setAttribute('position', `${x} 1 ${z}`);
            cube.setAttribute('color', `#${Math.floor(Math.random()*16777215).toString(16)}`);
            cube.setAttribute('shadow', 'cast: true');
            cube.setAttribute('class', 'interactive dynamic-object');
            cube.setAttribute('animation', {
                property: 'rotation',
                to: '0 360 0',
                loop: true,
                dur: 4000,
                easing: 'linear'
            });
            
            scene.appendChild(cube);
            
            notyf.success(`Cubo #${objectCount} añadido`);
        }

        function addSphere() {
            objectCount++;
            const sphere = document.createElement('a-sphere');
            
            const x = (Math.random() - 0.5) * 8;
            const z = (Math.random() - 0.5) * 8 - 3;
            
            sphere.setAttribute('position', `${x} 1.5 ${z}`);
            sphere.setAttribute('radius', '0.5');
            sphere.setAttribute('color', `#${Math.floor(Math.random()*16777215).toString(16)}`);
            sphere.setAttribute('shadow', 'cast: true');
            sphere.setAttribute('class', 'interactive dynamic-object');
            sphere.setAttribute('animation', {
                property: 'position',
                to: `${x} ${2 + Math.random()} ${z}`,
                dir: 'alternate',
                loop: true,
                dur: 2000,
                easing: 'easeInOutQuad'
            });
            
            scene.appendChild(sphere);
            
            notyf.success(`Esfera #${objectCount} añadida`);
        }

        function changeSky() {
            const colors = ['#87ceeb', '#ff6b6b', '#4ecdc4', '#ffe66d', '#a8dadc', '#1a1a1a'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            
            sky.setAttribute('color', randomColor);
            
            notyf.open({
                type: 'info',
                message: `Cielo cambiado a ${randomColor}`
            });
        }

        function clearScene() {
            Swal.fire({
                title: '¿Limpiar escena?',
                text: 'Se eliminarán todos los objetos dinámicos',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, limpiar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#00ff88',
                cancelButtonColor: '#ff4444',
                background: '#1a1a1a',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const dynamicObjects = document.querySelectorAll('.dynamic-object');
                    dynamicObjects.forEach(obj => obj.remove());
                    objectCount = 0;
                    
                    notyf.success('Escena limpiada');
                }
            });
        }

        // ========================================
        // UI CONTROLS
        // ========================================

        document.getElementById('toggle-ui-btn').addEventListener('click', function() {
            const overlay = document.getElementById('vr-ui-overlay');
            const controlsPanel = document.getElementById('controls-panel');
            
            if (isUIVisible) {
                controlsPanel.style.display = 'none';
                this.innerHTML = '<i class="bx bx-show"></i> Mostrar UI';
            } else {
                controlsPanel.style.display = 'block';
                this.innerHTML = '<i class="bx bx-hide"></i> Ocultar UI';
            }
            
            isUIVisible = !isUIVisible;
        });

        document.getElementById('enter-vr-btn').addEventListener('click', function() {
            const vrButton = document.querySelector('.a-enter-vr-button');
            if (vrButton) {
                vrButton.click();
            } else {
                Swal.fire({
                    title: 'WebXR no disponible',
                    text: 'Tu navegador o dispositivo no soporta WebXR. Prueba con Chrome en Android o un visor VR compatible.',
                    icon: 'error',
                    confirmButtonColor: '#00ff88',
                    background: '#1a1a1a',
                    color: '#fff'
                });
            }
        });

        // ========================================
        // SCENE EVENTS
        // ========================================

        scene.addEventListener('loaded', function() {
            console.log('%c✅ A-Frame scene cargada desde node_modules', 'color: #00ff88; font-size: 16px; font-weight: bold;');
            
            notyf.success('Escena VR inicializada correctamente');
        });

        // Click on objects
        document.querySelectorAll('.interactive').forEach(element => {
            element.addEventListener('click', function() {
                const currentColor = this.getAttribute('color');
                const newColor = `#${Math.floor(Math.random()*16777215).toString(16)}`;
                
                this.setAttribute('color', newColor);
                
                notyf.open({
                    type: 'info',
                    message: 'Color cambiado'
                });
            });
        });

        // ========================================
        // KEYBOARD SHORTCUTS
        // ========================================

        document.addEventListener('keydown', function(e) {
            switch(e.key.toLowerCase()) {
                case '1':
                    addCube();
                    break;
                case '2':
                    addSphere();
                    break;
                case '3':
                    changeSky();
                    break;
                case 'c':
                    if (e.ctrlKey) {
                        e.preventDefault();
                        clearScene();
                    }
                    break;
                case 'h':
                    document.getElementById('toggle-ui-btn').click();
                    break;
            }
        });

        // ========================================
        // WELCOME MESSAGE
        // ========================================

        setTimeout(() => {
            Swal.fire({
                title: '¡Bienvenido a HomeLab VR!',
                html: `
                    <p class="text-start mb-3">Controles disponibles:</p>
                    <ul class="text-start">
                        <li><strong>WASD</strong>: Mover cámara</li>
                        <li><strong>Mouse</strong>: Mirar alrededor</li>
                        <li><strong>Click</strong>: Interactuar con objetos</li>
                        <li><strong>1</strong>: Añadir cubo</li>
                        <li><strong>2</strong>: Añadir esfera</li>
                        <li><strong>3</strong>: Cambiar cielo</li>
                        <li><strong>H</strong>: Ocultar/Mostrar UI</li>
                        <li><strong>Ctrl+C</strong>: Limpiar escena</li>
                    </ul>
                    <p class="mt-3"><small>Todas las librerías cargadas desde <strong>node_modules</strong></small></p>
                `,
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#00ff88',
                background: '#1a1a1a',
                color: '#fff',
                width: '600px'
            });
        }, 1000);

        // ========================================
        // CONSOLE INFO
        // ========================================

        console.log('%c🥽 HomeLab VR - Template Moderno', 'color: #00ff88; font-size: 20px; font-weight: bold;');
        console.log({
            'A-Frame': typeof AFRAME !== 'undefined',
            'Three.js': typeof THREE !== 'undefined',
            'jQuery': typeof $ !== 'undefined',
            'Bootstrap': typeof bootstrap !== 'undefined',
            'SweetAlert2': typeof Swal !== 'undefined',
            'Notyf': typeof Notyf !== 'undefined'
        });
    </script>
</body>

</html>
