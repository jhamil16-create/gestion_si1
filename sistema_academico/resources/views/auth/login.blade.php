<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FICCT - Sistema de Gestión Académica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root{
            --blue-primary: #1a3e6f;
            --blue-hover: #2c5aa0;
            --blue-active: #2563eb;
        }
        html, body {
            overflow-x: hidden;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="h-full">
    <div class="flex h-screen w-screen">
        <!-- Columna Izquierda (50%) -->
        <div class="hidden md:flex md:w-1/2 relative">
            <!-- Fondo con imagen -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/img/backgroundHomePage.jpg');"></div>
            <!-- Overlay azul -->
            <div class="absolute inset-0 bg-blue-900/40"></div>
            <!-- Contenido -->
            <div class="relative z-10 flex flex-col items-center justify-center w-full text-white p-8">
                <img src="/img/logoFicct.png" alt="FICCT" class="w-48 h-48 mb-6">
                <h1 class="text-4xl font-bold text-center">Sistema FICCT</h1>
                <p class="text-xl mt-2">Gestión Académica</p>
                <div class="w-16 h-1 bg-white rounded-full my-6"></div>
                <p class="text-center text-blue-100 max-w-md">
                    Plataforma integral para la gestión de horarios, aulas y materias en la Facultad de Ingeniería en Ciencias de la Computación.
                </p>
            </div>
        </div>

        <!-- Columna Derecha (50%) - Formulario -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Logo móvil -->
                <div class="md:hidden text-center mb-8">
                    <img src="/img/logoFicct.png" alt="FICCT" class="w-24 h-24 mx-auto mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Sistema FICCT</h1>
                </div>

                <!-- Card del formulario -->
                <div class="bg-white/95 backdrop-blur-sm shadow-2xl rounded-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">Iniciar Sesión</h2>
                        <p class="text-gray-600 mt-2">Accede a tu cuenta</p>
                    </div>

                    <form id="loginForm" class="space-y-6">
                        <!-- Campo Registro -->
                        <div class="space-y-2">
                            <label for="registro" class="block text-sm font-medium text-gray-700">
                                Número de Registro
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="registro" name="registro" type="text" required 
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[var(--blue-primary)] focus:border-transparent"
                                    placeholder="218100001">
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Contraseña
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" required 
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[var(--blue-primary)] focus:border-transparent"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Recordar sesión y Olvidé contraseña -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center space-x-2 text-sm">
                                <input type="checkbox" id="remember-me" name="remember-me" 
                                    class="w-4 h-4 text-[var(--blue-primary)] border-gray-300 rounded focus:ring-[var(--blue-primary)]">
                                <span class="text-gray-700">Recordar sesión</span>
                            </label>
                            <a href="#" class="text-sm text-[var(--blue-primary)] hover:text-[var(--blue-hover)] transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        <!-- Botón Submit -->
                        <button type="submit" 
                            class="w-full bg-[var(--blue-primary)] hover:bg-[var(--blue-hover)] text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                            <span>Iniciar Sesión</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar contraseña
        function togglePassword(){
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        }

        // Login simple (mantener usuarios ya definidos en la app o reutilizar los existentes)
        const usuariosValidos = [
            { email: 'jvelizloayza@gmail.com', registro: '218100001', password: 'password', rol: 'admin', nombre: 'Administrador Principal' },
            { email: 'docente123@ficct.edu', registro: '218100002', password: 'docente123', rol: 'docente', nombre: 'Profesor Ejemplo' }
        ];

        document.getElementById('loginForm').addEventListener('submit', function(e){
            e.preventDefault();
            const registro = document.getElementById('registro').value.trim();
            const password = document.getElementById('password').value.trim();
            const recordar = document.getElementById('remember-me').checked;

            const usuario = usuariosValidos.find(u => u.registro === registro && u.password === password);
            if(usuario){
                const sessionData = { email: usuario.email, registro: usuario.registro, rol: usuario.rol, nombre: usuario.nombre, loggedIn: true };
                if(recordar) localStorage.setItem('usuario', JSON.stringify(sessionData)); else sessionStorage.setItem('usuario', JSON.stringify(sessionData));
                window.location.href = '/dashboard';
            } else {
                alert('Credenciales incorrectas');
            }
        });
    </script>
</body>
</html>

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