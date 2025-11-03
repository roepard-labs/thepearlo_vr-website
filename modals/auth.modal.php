<!-- Auth Modal - Modal de Autenticación -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="authModalLabel">
                    <i class='bx bx-user-circle me-2'></i>
                    Acceso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                
                <!-- Tabs de Login / Registro -->
                <ul class="nav nav-pills nav-justified mb-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#loginTab" type="button" role="tab">
                            <i class='bx bx-log-in me-2'></i>
                            Iniciar Sesión
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="pill" data-bs-target="#registerTab" type="button" role="tab">
                            <i class='bx bx-user-plus me-2'></i>
                            Registrarse
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content">
                    
                    <!-- ========================================
                         TAB LOGIN
                    ========================================= -->
                    <div class="tab-pane fade show active" id="loginTab" role="tabpanel">
                        <form id="loginForm">
                            
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">
                                    <i class='bx bx-envelope me-2'></i>
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="loginEmail" 
                                    placeholder="tu@email.com"
                                    required
                                >
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">
                                    <i class='bx bx-lock-alt me-2'></i>
                                    Contraseña
                                </label>
                                <div class="input-group">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="loginPassword" 
                                        placeholder="********"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('loginPassword')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Recordar / Olvidé -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Recordarme
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none small">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                            
                            <!-- Botón Submit -->
                            <button type="submit" class="btn btn-primary w-100">
                                <i class='bx bx-log-in me-2'></i>
                                Iniciar Sesión
                            </button>
                            
                        </form>
                        
                        <!-- Divider -->
                        <div class="text-center my-4">
                            <span class="text-muted">o continuar con</span>
                        </div>
                        
                        <!-- Social Login -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-dark">
                                <i class='bx bxl-google me-2'></i>
                                Google
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class='bx bxl-github me-2'></i>
                                GitHub
                            </button>
                        </div>
                    </div>
                    
                    <!-- ========================================
                         TAB REGISTER
                    ========================================= -->
                    <div class="tab-pane fade" id="registerTab" role="tabpanel">
                        <form id="registerForm">
                            
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="registerUsername" class="form-label">
                                    <i class='bx bx-user me-2'></i>
                                    Nombre de usuario
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="registerUsername" 
                                    placeholder="usuario123"
                                    minlength="3"
                                    maxlength="20"
                                    required
                                >
                                <div class="form-text">3-20 caracteres, solo letras, números, _ y -</div>
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">
                                    <i class='bx bx-envelope me-2'></i>
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="registerEmail" 
                                    placeholder="tu@email.com"
                                    required
                                >
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">
                                    <i class='bx bx-lock-alt me-2'></i>
                                    Contraseña
                                </label>
                                <div class="input-group">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="registerPassword" 
                                        placeholder="********"
                                        minlength="8"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('registerPassword')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                                <div class="form-text">Mínimo 8 caracteres, incluye mayúsculas, minúsculas y números</div>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="registerPassword2" class="form-label">
                                    <i class='bx bx-lock-alt me-2'></i>
                                    Confirmar contraseña
                                </label>
                                <div class="input-group">
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="registerPassword2" 
                                        placeholder="********"
                                        minlength="8"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('registerPassword2')">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Términos -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                                <label class="form-check-label small" for="acceptTerms">
                                    Acepto los <a href="/legal/terminos" target="_blank">términos y condiciones</a> 
                                    y la <a href="/legal/privacidad" target="_blank">política de privacidad</a>
                                </label>
                            </div>
                            
                            <!-- Botón Submit -->
                            <button type="submit" class="btn btn-primary w-100">
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

<style>
/* Estilos adicionales para el modal */
#authModal .nav-pills .nav-link {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

#authModal .nav-pills .nav-link:not(.active):hover {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}

#authModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

#authModal .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}

#authModal .btn {
    border-radius: 8px;
    padding: 0.625rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

#authModal .btn-outline-dark:hover,
#authModal .btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
