<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICCT - Sistema de Gestión Académica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --ficct-blue: #1a3e6f;
            --ficct-blue-light: #2c5aa0;
        }
        .bg-ficct-blue {
            background-color: var(--ficct-blue);
        }
        .bg-ficct-blue-light {
            background-color: var(--ficct-blue-light);
        }
        .text-ficct-blue {
            color: var(--ficct-blue);
        }
        .border-ficct-blue {
            border-color: var(--ficct-blue);
        }
        .login-bg {
            background-image: url('/img/background.jpg');
            background-size: cover;
            background-position: center;
        }
        .bg-gradient-ficct {
            background: linear-gradient(135deg, var(--ficct-blue) 0%, var(--ficct-blue-light) 100%);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Columna Izquierda - Background -->
        <div class="hidden lg:flex lg:w-3/5 login-bg relative">
            <div class="absolute inset-0 bg-gradient-ficct opacity-90"></div>
            <div class="relative z-10 flex flex-col justify-center items-center w-full text-white p-12 animate-fadeIn">
                <img src="/img/logoFicct.png" class="w-48 h-48 mb-8" alt="FICCT">
                <h1 class="text-5xl font-bold mb-4 text-center">Sistema FICCT</h1>
                <p class="text-2xl font-light mb-2">Gestión Académica Integral</p>
                <div class="w-16 h-1 bg-white rounded-full mb-6"></div>
                <p class="text-lg text-center text-blue-100 max-w-xl">
                    Plataforma integral para la gestión de horarios, aulas, materias y control de asistencia docente
                </p>
            </div>
        </div>

        <!-- Columna Derecha - Formulario -->
        <div class="w-full lg:w-2/5 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Logo para móvil -->
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <img src="/img/logoFicct.png" class="w-24 h-24 mb-4" alt="FICCT">
                    <h1 class="text-2xl font-bold text-gray-900">Sistema FICCT</h1>
                </div>

                <div class="bg-white rounded-2xl shadow-2xl p-8 animate-fadeIn">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">Iniciar Sesión</h2>
                        <p class="text-gray-600 mt-2">Ingresa a tu cuenta</p>
                    </div>

                    <form id="loginForm" class="space-y-6">
                        <div class="space-y-4">
                            <div>
                                <label for="registro" class="block text-sm font-medium text-gray-700 mb-1">
                                    Número de Registro
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    <input id="registro" name="registro" type="text" required 
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="218100001">
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Contraseña
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                    <input id="password" name="password" type="password" required 
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="••••••••">
                                    <button type="button" onclick="togglePassword()" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" 
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Recordar sesión</span>
                            </label>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        <button type="submit" 
                            class="w-full bg-gradient-ficct text-white py-3 px-4 rounded-lg font-semibold transform transition-all duration-200 hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Iniciar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Usuarios válidos
        const usuariosValidos = [
            {
                email: 'jvelizloayza@gmail.com',
                registro: '218100001',
                password: 'password',
                rol: 'admin',
                nombre: 'Administrador Principal'
            },
            {
                email: 'docente123@ficct.edu',
                registro: '218100002',
                password: 'docente123',
                rol: 'docente',
                nombre: 'Profesor Ejemplo'
            }
        ];

        // Función para mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const button = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                button.innerHTML = `
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>`;
            } else {
                passwordInput.type = 'password';
                button.innerHTML = `
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>`;
            }
        }

        // Función para mostrar notificaciones
        function showNotification(message, type = 'error') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg transition-all transform duration-300 ${
                type === 'error' ? 'bg-red-500' : 'bg-green-500'
            } text-white`;
            notification.style.zIndex = '9999';
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animar entrada
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 100);

            // Animar salida
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Manejo del formulario de login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>`;
            
            const registro = document.getElementById('registro').value;
            const password = document.getElementById('password').value;
            const recordar = document.getElementById('remember-me').checked;
            
            // Simular delay de red
            setTimeout(() => {
                const usuario = usuariosValidos.find(u => u.registro === registro && u.password === password);
                
                if (usuario) {
                    const sessionData = {
                        email: usuario.email,
                        registro: usuario.registro,
                        rol: usuario.rol,
                        nombre: usuario.nombre,
                        loggedIn: true,
                        recordar: recordar
                    };
                    
                    if (recordar) {
                        localStorage.setItem('usuario', JSON.stringify(sessionData));
                    } else {
                        sessionStorage.setItem('usuario', JSON.stringify(sessionData));
                    }
                    
                    showNotification('¡Inicio de sesión exitoso!', 'success');
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 1000);
                } else {
                    showNotification('Credenciales incorrectas');
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Iniciar Sesión';
                }
            }, 1000);
        });

        // Verificar si ya hay una sesión activa
        window.addEventListener('load', function() {
            const usuarioLocal = JSON.parse(localStorage.getItem('usuario'));
            const usuarioSession = JSON.parse(sessionStorage.getItem('usuario'));
            
            if (usuarioLocal?.loggedIn || usuarioSession?.loggedIn) {
                window.location.href = '/dashboard';
            }

            // Animación de entrada de elementos
            const elements = document.querySelectorAll('.animate-fadeIn');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>