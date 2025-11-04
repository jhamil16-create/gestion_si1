<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Docente FICCT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-full flex">

    <div class="hidden md:flex w-1/2 bg-cover bg-center relative items-center justify-center"
        style="background-image: url('{{ asset('img/backgroundHomePage.jpg') }}');">
        <div class="absolute inset-0 bg-blue-800 bg-opacity-40"></div>
        <div class="relative text-center p-8">
            <img src="{{ asset('img/logoFicct.png') }}" alt="Logo FICCT" class="mx-auto w-40 mb-4 drop-shadow-lg">
            <h1 class="text-white text-3xl font-bold">Facultad de Ingeniería en Ciencias de la Computación</h1>
            <p class="text-blue-100 mt-2">Sistema FICCT</p>
        </div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-2xl space-y-6">
            
            <img src="{{ asset('img/logoFicct.png') }}" alt="Logo FICCT" class="mx-auto w-24 mb-4 block md:hidden">
            
            <h2 class="text-3xl font-bold text-center text-blue-700">Iniciar Sesión</h2>

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 10.884l7.997-5H2.003zM18 7.116l-8 4.884-8-4.884V14a2 2 0 002 2h12a2 2 0 002-2V7.116z" />
                            </svg>
                        </span>
                        <input type="email" name="email" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pl-10 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        
                        <input type="password" name="password" id="passwordInput" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pl-10 pr-10 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm">
                        
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <svg id="eye-open" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eye-slash" class="h-5 w-5 text-gray-400 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="text-right text-sm">
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    Ingresar
                </button>
            </form>
        </div>
    </div>

    <script>
        // Espera a que el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function () {
            
            // Selecciona los elementos
            const toggleButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eye-open');
            const eyeSlash = document.getElementById('eye-slash');

            // Agrega el evento click al botón
            toggleButton.addEventListener('click', function () {
                // Revisa el tipo de input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Cambia los iconos usando la clase 'hidden' de Tailwind
                if (type === 'text') {
                    // Si es texto (visible), muestra el ojo tachado
                    eyeOpen.classList.add('hidden');
                    eyeSlash.classList.remove('hidden');
                } else {
                    // Si es password (oculto), muestra el ojo abierto
                    eyeOpen.classList.remove('hidden');
                    eyeSlash.classList.add('hidden');
                }
            });
        });
    </script>

</body>
</html>