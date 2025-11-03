/**
 * Auth.js - Sistema de Autenticación
 * HomeLab AR - Roepard Labs
 */

const Auth = {

    // ===================================
    // CONFIGURACIÓN
    // ===================================
    config: {
        apiUrl: window.API_URL || 'https://api.thepearlodyssey.com',
        endpoints: {
            login: '/auth/login',
            register: '/auth/register',
            logout: '/auth/logout',
            verify: '/auth/verify'
        }
    },

    // ===================================
    // LOGIN
    // ===================================
    login: async function (email, password) {
        try {
            console.log('🔐 Intentando login...');

            const response = await axios.post(
                this.config.apiUrl + this.config.endpoints.login,
                { email, password }
            );

            if (response.data.success) {
                // Guardar token y usuario
                localStorage.setItem('token', response.data.token);
                localStorage.setItem('user', JSON.stringify(response.data.user));

                console.log('✅ Login exitoso');

                // Notificación
                if (typeof Notyf !== 'undefined') {
                    const notyf = new Notyf();
                    notyf.success('¡Bienvenido de vuelta!');
                }

                // Recargar página
                setTimeout(() => {
                    window.location.reload();
                }, 1000);

                return { success: true, data: response.data };
            }

        } catch (error) {
            console.error('❌ Error en login:', error);

            const message = error.response?.data?.message || 'Error al iniciar sesión';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            } else {
                alert(message);
            }

            return { success: false, error: message };
        }
    },

    // ===================================
    // REGISTER
    // ===================================
    register: async function (userData) {
        try {
            console.log('📝 Intentando registro...');

            const response = await axios.post(
                this.config.apiUrl + this.config.endpoints.register,
                userData
            );

            if (response.data.success) {
                console.log('✅ Registro exitoso');

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: 'Ahora puedes iniciar sesión',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    alert('¡Registro exitoso! Ahora puedes iniciar sesión.');
                }

                return { success: true, data: response.data };
            }

        } catch (error) {
            console.error('❌ Error en registro:', error);

            const message = error.response?.data?.message || 'Error al registrarse';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            } else {
                alert(message);
            }

            return { success: false, error: message };
        }
    },

    // ===================================
    // LOGOUT
    // ===================================
    logout: async function () {
        try {
            console.log('👋 Cerrando sesión...');

            const token = localStorage.getItem('token');

            if (token) {
                await axios.post(
                    this.config.apiUrl + this.config.endpoints.logout,
                    {},
                    {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    }
                );
            }

            // Limpiar localStorage
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            console.log('✅ Sesión cerrada');

            // Redirigir
            window.location.href = '/';

        } catch (error) {
            console.error('❌ Error al cerrar sesión:', error);

            // Limpiar de todas formas
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/';
        }
    },

    // ===================================
    // VERIFY TOKEN
    // ===================================
    verify: async function () {
        try {
            const token = localStorage.getItem('token');

            if (!token) {
                return { success: false, error: 'No token found' };
            }

            const response = await axios.post(
                this.config.apiUrl + this.config.endpoints.verify,
                {},
                {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }
            );

            return { success: true, data: response.data };

        } catch (error) {
            console.error('❌ Token inválido:', error);

            // Limpiar token inválido
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            return { success: false, error: 'Invalid token' };
        }
    },

    // ===================================
    // HELPERS
    // ===================================
    isAuthenticated: function () {
        return !!localStorage.getItem('token');
    },

    getUser: function () {
        const userJson = localStorage.getItem('user');
        return userJson ? JSON.parse(userJson) : null;
    },

    getToken: function () {
        return localStorage.getItem('token');
    }
};

// ===================================
// FORMULARIO LOGIN
// ===================================
document.addEventListener('DOMContentLoaded', function () {

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const submitBtn = this.querySelector('button[type="submit"]');

            // Deshabilitar botón
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Iniciando...';

            // Intentar login
            await Auth.login(email, password);

            // Rehabilitar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Iniciar Sesión';
        });
    }

    // ===================================
    // FORMULARIO REGISTER
    // ===================================
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const userData = {
                username: document.getElementById('registerUsername').value,
                email: document.getElementById('registerEmail').value,
                password: document.getElementById('registerPassword').value
            };

            const password2 = document.getElementById('registerPassword2').value;

            // Validar contraseñas
            if (userData.password !== password2) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden'
                    });
                } else {
                    alert('Las contraseñas no coinciden');
                }
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');

            // Deshabilitar botón
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registrando...';

            // Intentar registro
            const result = await Auth.register(userData);

            // Rehabilitar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Crear Cuenta';

            // Si fue exitoso, cambiar a tab de login
            if (result.success) {
                const loginTab = document.querySelector('button[data-bs-target="#loginTab"]');
                if (loginTab) {
                    setTimeout(() => {
                        loginTab.click();
                        registerForm.reset();
                    }, 1500);
                }
            }
        });
    }
});

console.log('✅ Auth.js cargado');
