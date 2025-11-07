<!-- Auth Modal - Modal de Autenticación con Router.js -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true"
    data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header del Modal -->
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title w-100 text-center" id="authModalLabel">
                    <i class='bx bx-user-circle fs-1 text-primary d-block mb-2'></i>
                    <div class="fw-bold">HomeLab AR</div>
                    <small class="text-muted fw-normal">Realidad aumentada</small>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5">

                <!-- Tabs de Login / Registro con diseño mejorado -->
                <ul class="nav nav-pills nav-justified mb-4 gap-2" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-3 rounded-3" id="login-tab" data-bs-toggle="pill"
                            data-bs-target="#loginTab" type="button" role="tab">
                            <i class='bx bx-log-in-circle fs-5 me-2'></i>
                            <span class="fw-semibold">Iniciar Sesión</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3 rounded-3" id="register-tab" data-bs-toggle="pill"
                            data-bs-target="#registerTab" type="button" role="tab">
                            <i class='bx bx-user-plus fs-5 me-2'></i>
                            <span class="fw-semibold">Registrarse</span>
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- TAB LOGIN -->
                    <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
                        <form id="loginForm" class="needs-validation" novalidate>

                            <!-- Username/Email -->
                            <div class="mb-4">
                                <label for="loginUsername" class="form-label fw-semibold">
                                    <i class='bx bx-user me-2 text-primary'></i>
                                    Usuario o Email
                                </label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="loginUsername"
                                    name="username" placeholder="usuario o correo@ejemplo.com" autocomplete="username"
                                    required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu usuario o email
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="loginPassword" class="form-label fw-semibold">
                                    <i class='bx bx-lock-alt me-2 text-primary'></i>
                                    Contraseña
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control rounded-start-3" id="loginPassword"
                                        name="password" placeholder="Tu contraseña segura"
                                        autocomplete="current-password" required>
                                    <button class="btn btn-outline-secondary rounded-end-3" type="button"
                                        onclick="togglePassword('loginPassword')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu contraseña
                                </div>
                            </div>

                            <!-- Recordar / Olvidé -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="#" class="text-decoration-none" id="forgotPasswordLink">
                                    <small>¿Olvidaste tu contraseña?</small>
                                </a>
                            </div>

                            <!-- Alert para errores -->
                            <div id="loginAlert" class="alert alert-danger d-none" role="alert">
                                <i class='bx bx-error me-2'></i>
                                <span id="loginAlertMessage"></span>
                            </div>

                            <!-- Botón Submit - Cambiado a button para control total -->
                            <button type="button"
                                class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-3 shadow-sm" id="loginBtn">
                                <i class='bx bx-log-in-circle me-2'></i>
                                Iniciar Sesión
                            </button>

                        </form>
                    </div>

                    <!-- TAB REGISTER -->
                    <div class="tab-pane fade" id="registerTab" role="tabpanel">
                        <form id="registerForm" class="needs-validation" novalidate>

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="registerName" class="form-label fw-semibold">
                                    <i class='bx bx-user me-2 text-primary'></i>
                                    Nombre Completo
                                </label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="registerName"
                                    name="name" placeholder="Juan Pérez" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu nombre completo
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="registerUsername" class="form-label fw-semibold">
                                    <i class='bx bx-at me-2 text-primary'></i>
                                    Usuario
                                </label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="registerUsername"
                                    name="username" placeholder="juanperez" minlength="3" maxlength="20" required>
                                <div class="form-text">3-20 caracteres, solo letras, números, _ y -</div>
                                <div class="invalid-feedback">
                                    Usuario debe tener entre 3 y 20 caracteres
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label fw-semibold">
                                    <i class='bx bx-envelope me-2 text-primary'></i>
                                    Email
                                </label>
                                <input type="email" class="form-control form-control-lg rounded-3" id="registerEmail"
                                    name="email" placeholder="tu@email.com" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un email válido
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-3">
                                <label for="registerPhone" class="form-label fw-semibold">
                                    <i class='bx bx-phone me-2 text-primary'></i>
                                    Teléfono
                                </label>
                                <input type="tel" class="form-control form-control-lg rounded-3" id="registerPhone"
                                    name="phone" placeholder="+52 123 456 7890" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu teléfono
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label fw-semibold">
                                    <i class='bx bx-lock-alt me-2 text-primary'></i>
                                    Contraseña
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control rounded-start-3" id="registerPassword"
                                        name="password" placeholder="Mínimo 8 caracteres" autocomplete="new-password"
                                        minlength="8" required>
                                    <button class="btn btn-outline-secondary rounded-end-3" type="button"
                                        onclick="togglePassword('registerPassword')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                <div class="form-text">Mínimo 8 caracteres, incluye mayúsculas, minúsculas y números
                                </div>
                                <div class="invalid-feedback">
                                    La contraseña debe tener al menos 8 caracteres
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="registerPassword2" class="form-label fw-semibold">
                                    <i class='bx bx-lock-alt me-2 text-primary'></i>
                                    Confirmar Contraseña
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control rounded-start-3" id="registerPassword2"
                                        name="password2" placeholder="Repite tu contraseña" autocomplete="new-password"
                                        required>
                                    <button class="btn btn-outline-secondary rounded-end-3" type="button"
                                        onclick="togglePassword('registerPassword2')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Las contraseñas deben coincidir
                                </div>
                            </div>

                            <!-- Términos -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="acceptTerms" required checked>
                                <label class="form-check-label" for="acceptTerms">
                                    Acepto los <a href="/terms" target="_blank">Términos y Condiciones</a> y la
                                    <a href="/privacy" target="_blank">Política de Privacidad</a>
                                </label>
                                <div class="invalid-feedback">
                                    Debes aceptar los términos y condiciones
                                </div>
                            </div>

                            <!-- Alert para errores -->
                            <div id="registerAlert" class="alert alert-danger d-none" role="alert">
                                <i class='bx bx-error me-2'></i>
                                <span id="registerAlertMessage"></span>
                            </div>

                            <!-- Botón Submit - Cambiado a button para control total -->
                            <button type="button"
                                class="btn btn-primary btn-lg w-100 py-3 fw-semibold rounded-3 shadow-sm"
                                id="registerBtn">
                                <i class='bx bx-user-plus me-2'></i>
                                Crear Cuenta
                            </button>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Script para toggle de contraseña -->
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        } else {
            input.type = 'password';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        }
    }
</script>

<!-- 
    NOTA: El script de autenticación se ha movido a /js/auth-modal.js
    Este archivo se carga en AppLayout.php después de jQuery para evitar errores de dependencias
-->

<style>
    #authModal .modal-content {
        border-radius: 20px;
        overflow: hidden;
    }

    #authModal .nav-pills .nav-link {
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    #authModal .nav-pills .nav-link:not(.active) {
        color: var(--bs-body-color);
        background-color: transparent;
    }

    #authModal .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        border-color: rgba(var(--bs-primary-rgb), 0.2);
    }

    #authModal .nav-pills .nav-link.active {
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
        box-shadow: 0 4px 15px rgba(var(--bs-primary-rgb), 0.3);
    }

    #authModal .form-control:focus,
    #authModal .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.15);
    }

    #authModal .form-control-lg {
        padding: 0.75rem 1.25rem;
    }

    #authModal .btn {
        transition: all 0.3s ease;
    }

    #authModal .btn-primary {
        background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
        border: none;
    }

    #authModal .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb), 0.4);
    }

    #authModal .alert {
        border-radius: 10px;
        border: none;
    }

    #authModal a {
        color: var(--bs-primary);
        transition: color 0.2s ease;
    }

    #authModal a:hover {
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        #authModal .modal-dialog {
            margin: 0.5rem;
        }

        #authModal .modal-body {
            padding: 2rem 1.5rem !important;
        }
    }
</style>