/**
 * Auth Modal Handler con jQuery
 * HomeLab AR - Roepard Labs
 * 
 * Este script maneja la autenticación del modal de login/registro
 * Requiere: jQuery, Bootstrap, Notyf, SweetAlert2
 */

(function () {
    'use strict';

    console.log('🔐 Cargando Auth Modal Handler...');

    // Verificar que jQuery esté cargado
    if (typeof jQuery === 'undefined') {
        console.error('❌ jQuery no está cargado!');
        return;
    }

    console.log('✅ jQuery disponible, versión:', jQuery.fn.jquery);

    // Esperar a que el DOM esté listo
    $(document).ready(function () {
        console.log(' Formulario login encontrado:', $('#loginForm').length > 0);
        console.log('🔍 Formulario registro encontrado:', $('#registerForm').length > 0);

        // Inicializar Tippy cuando el modal se muestre
        $('#authModal').on('shown.bs.modal', function () {
            console.log('📦 Modal mostrado, inicializando Tippy...');

            if (typeof tippy !== 'undefined') {
                const forgotLink = document.getElementById('forgotPasswordLink');
                if (forgotLink) {
                    tippy(forgotLink, {
                        content: 'Contacta con los administradores para recuperar tu contraseña',
                        placement: 'top',
                        animation: 'scale',
                        theme: 'light-border'
                    });
                    console.log('✅ Tippy inicializado correctamente');
                } else {
                    console.warn('⚠️ Elemento #forgotPasswordLink no encontrado');
                }
            } else {
                console.warn('⚠️ Tippy.js no está disponible');
            }
        });

        // ==========================================
        // HANDLER ALTERNATIVO: Click en botón de login
        // ==========================================
        $(document).on('click', '#loginBtn', function (e) {
            e.preventDefault();
            console.log('🖱️ Click en botón LOGIN detectado');
            $('#loginForm').trigger('submit');
        });

        // ==========================================
        // FORMULARIO LOGIN con jQuery - Event Delegation
        // ==========================================
        $(document).on('submit', '#loginForm', function (e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('🔐 Submit LOGIN interceptado con event delegation - NO recargará la página');
            console.log('🔍 Tipo de evento:', e.type, '| Target:', e.target.id);

            const username = $.trim($('#loginUsername').val());
            const password = $.trim($('#loginPassword').val());
            const loginBtn = $('#loginBtn');
            const loginAlert = $('#loginAlert');

            // Validación de campos vacíos
            if (!username || !password) {
                console.error('❌ Campos vacíos');
                $('#loginAlertMessage').text('Por favor completa todos los campos');
                loginAlert.removeClass('d-none');
                return false;
            }

            // Deshabilitar botón y mostrar loading
            loginBtn.prop('disabled', true);
            loginBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Iniciando sesión...');
            loginAlert.addClass('d-none');

            console.log('🔐 Intentando autenticación...');
            console.log('📤 Username:', username, '| Password length:', password.length);

            // AJAX con jQuery - formato que espera el backend
            // IMPORTANTE: xhrFields con credentials para compartir sesiones entre dominios
            $.ajax({
                url: window.ENV_CONFIG?.API_URL + '/routes/user/auth_user.php' || 'http://localhost:3000/routes/user/auth_user.php',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json',
                xhrFields: {
                    withCredentials: true  // Importante para sesiones CORS
                },
                crossDomain: true,
                success: function (response) {
                    console.log('📥 Respuesta del servidor:', response);

                    if (response.status === 'success') {
                        // Éxito en el login
                        console.log('✅ Login exitoso');
                        console.log('👤 Datos del usuario:', response.user_data);

                        // Cerrar modal
                        const modalElement = document.getElementById('authModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        // Notificación de éxito
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Bienvenido!',
                                text: response.user_data?.first_name ? `Hola ${response.user_data.first_name}!` : 'Has iniciado sesión correctamente',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }

                        // Disparar evento personalizado para que el header se actualice
                        const userLoggedInEvent = new CustomEvent('userLoggedIn', {
                            detail: {
                                userData: response.user_data
                            }
                        });
                        window.dispatchEvent(userLoggedInEvent);
                        console.log('📢 Evento userLoggedIn disparado');

                        // Actualizar header dinámicamente SIN recargar
                        setTimeout(function () {
                            if (typeof window.updateHeaderAfterLogin === 'function') {
                                window.updateHeaderAfterLogin(response.user_data);
                                console.log('✅ Header actualizado sin recargar página');
                            } else {
                                console.warn('⚠️ updateHeaderAfterLogin no disponible');
                            }
                        }, 100);

                    } else {
                        // Error en la respuesta
                        $('#loginAlertMessage').text(response.message || 'Error al iniciar sesión');
                        loginAlert.removeClass('d-none');
                        loginBtn.prop('disabled', false);
                        loginBtn.html('<i class="bx bx-log-in-circle me-2"></i>Iniciar Sesión');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('❌ Error AJAX:', error);
                    const errorMessage = xhr.responseJSON?.message || 'Error de conexión con el servidor';
                    $('#loginAlertMessage').text(errorMessage);
                    loginAlert.removeClass('d-none');
                    loginBtn.prop('disabled', false);
                    loginBtn.html('<i class="bx bx-log-in-circle me-2"></i>Iniciar Sesión');
                }
            });

            return false; // Extra seguridad para prevenir submit
        });

        // ==========================================
        // HANDLER ALTERNATIVO: Click en botón de registro
        // ==========================================
        $(document).on('click', '#registerBtn', function (e) {
            e.preventDefault();
            console.log('🖱️ Click en botón REGISTRO detectado');
            $('#registerForm').trigger('submit');
        });

        // ==========================================
        // FORMULARIO REGISTRO con jQuery - Event Delegation
        // ==========================================
        $(document).on('submit', '#registerForm', function (e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('📝 Submit REGISTRO interceptado con event delegation - NO recargará la página');

            const name = $.trim($('#registerName').val());
            const username = $.trim($('#registerUsername').val());
            const email = $.trim($('#registerEmail').val());
            const phone = $.trim($('#registerPhone').val());
            const password = $('#registerPassword').val();
            const password2 = $('#registerPassword2').val();
            const registerBtn = $('#registerBtn');
            const registerAlert = $('#registerAlert');

            // Separar nombre y apellido
            const nameParts = name.split(' ');
            const first_name = nameParts[0];
            const last_name = nameParts.slice(1).join(' ') || '';

            // Validación de contraseñas
            if (password !== password2) {
                $('#registerAlertMessage').text('Las contraseñas no coinciden');
                registerAlert.removeClass('d-none');
                return false;
            }

            // Validación de campos vacíos
            if (!first_name || !username || !email || !phone || !password) {
                $('#registerAlertMessage').text('Por favor completa todos los campos');
                registerAlert.removeClass('d-none');
                return false;
            }

            // Deshabilitar botón y mostrar loading
            registerBtn.prop('disabled', true);
            registerBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Creando cuenta...');
            registerAlert.addClass('d-none');

            console.log('📝 Intentando registro...');

            // AJAX con jQuery - formato que espera el backend
            $.ajax({
                url: window.ENV_CONFIG?.API_URL + '/routes/user/reg_user.php' || 'http://localhost:3000/routes/user/reg_user.php',
                method: 'POST',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    username: username,
                    email: email,
                    phone: phone,
                    password: password
                },
                dataType: 'json',
                success: function (response) {
                    console.log('📥 Respuesta del servidor:', response);

                    if (response.status === 'success') {
                        // Éxito en el registro
                        console.log('✅ Registro exitoso');

                        // Cerrar modal
                        const modalElement = document.getElementById('authModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        // Notificación de éxito
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Cuenta creada!',
                                text: response.message || 'Tu cuenta ha sido creada exitosamente',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }

                        // Recargar página después de 2 segundos
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);

                    } else {
                        // Error en la respuesta
                        $('#registerAlertMessage').text(response.message || 'Error al crear la cuenta');
                        registerAlert.removeClass('d-none');
                        registerBtn.prop('disabled', false);
                        registerBtn.html('<i class="bx bx-user-plus me-2"></i>Crear Cuenta');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('❌ Error AJAX:', error);
                    const errorMessage = xhr.responseJSON?.message || 'Error de conexión con el servidor';
                    $('#registerAlertMessage').text(errorMessage);
                    registerAlert.removeClass('d-none');
                    registerBtn.prop('disabled', false);
                    registerBtn.html('<i class="bx bx-user-plus me-2"></i>Crear Cuenta');
                }
            });

            return false; // Extra seguridad para prevenir submit
        });

        // ==========================================
        // FUNCIÓN PARA ACTUALIZAR HEADER DINÁMICAMENTE
        // ==========================================
        function updateHeaderWithUser(userData) {
            console.log('🔄 Actualizando header con datos del usuario:', userData);

            if (!userData) {
                console.warn('⚠️ No hay datos de usuario para actualizar header');
                return;
            }

            // Buscar el contenedor del botón "Identifícate"
            const authContainer = $('.header-auth-container');
            const authButton = $('#authModalTrigger');

            if (authButton.length === 0) {
                console.warn('⚠️ Botón de autenticación no encontrado');
                return;
            }

            // Crear dropdown HTML
            const userName = userData.first_name || userData.user_name || 'Usuario';
            const userRole = userData.role_id == 2 ? 'Administrador' : 'Usuario';
            const dashboardUrl = userData.role_id == 2 ? '/admin' : '/user';

            const dropdownHtml = `
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user-circle me-1"></i>
                        ${userName}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li class="px-3 py-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-gradient rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="bx bx-user text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">${userName}</div>
                                    <small class="text-muted">${userRole}</small>
                                </div>
                            </div>
                        </li>
                        <li><a class="dropdown-item py-2" href="${dashboardUrl}"><i class="bx bx-dashboard me-2 text-primary"></i>Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="/homelab"><i class="bx bx-cube me-2 text-primary"></i>HomeLab VR</a></li>
                        <li><a class="dropdown-item py-2" href="/profile"><i class="bx bx-user me-2 text-primary"></i>Mi Perfil</a></li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="#" id="logoutBtn">
                                <i class="bx bx-log-out me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            `;

            // Reemplazar botón con dropdown
            authContainer.html(dropdownHtml);

            console.log('✅ Header actualizado con usuario:', userName);
        }

        // Hacer la función global para que pueda ser llamada desde otros scripts
        window.updateHeaderWithUser = updateHeaderWithUser;

        console.log('✅ Auth Modal Handler completamente inicializado');

    }); // Fin $(document).ready()

})();
