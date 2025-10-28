<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Académico FICCT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --ficct-blue: #2c5aa0;
        }
        .bg-ficct-blue {
            background-color: var(--ficct-blue);
        }
        .text-ficct-blue {
            color: var(--ficct-blue);
        }
        .hover\:bg-ficct-blue:hover {
            background-color: var(--ficct-blue);
        }
        .border-ficct-blue {
            border-color: var(--ficct-blue);
        }
    </style>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false, usuario: null }" x-init="
    usuario = JSON.parse(localStorage.getItem('usuario') || sessionStorage.getItem('usuario') || '{}');
    if (!usuario.loggedIn) {
        window.location.href = '/';
    }
">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-30 w-64 bg-ficct-blue text-white transform transition-transform duration-300 ease-in-out md:translate-x-0"
         :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-ficct-blue border-b border-blue-700">
            <img src="/img/logoFicct.png" alt="FICCT Logo" class="h-12">
        </div>
        
        <!-- Navigation -->
        <nav class="mt-5">
            <a href="/dashboard" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            
            <!-- Menú Admin -->
            <template x-if="usuario.rol === 'admin'">
                <div>
                    <a href="/usuarios" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Usuarios y Roles
                    </a>
                    <a href="/docentes" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Gestionar Docentes
                    </a>
                    <a href="/materias" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Gestionar Materias
                    </a>
                    <a href="/asignaciones" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Asignar Materias
                    </a>
                    <a href="/asignaciones/consulta" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Consultar Carga Docente
                    </a>
                </div>
            </template>

            <!-- Menú Docente -->
            <template x-if="usuario.rol === 'docente'">
                <div>
                    <a href="/asignaciones/consulta" class="flex items-center px-6 py-2 text-white hover:bg-blue-700">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Mi Carga Horaria
                    </a>
                </div>
            </template>
        </nav>
    </div>

    <!-- Content -->
    <div class="md:ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-4 py-3">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center">
                    <span class="text-gray-800" x-text="usuario.nombre"></span>
                    <button @click="logout()" class="ml-4 text-gray-500 hover:text-gray-600" title="Cerrar Sesión">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <script>
        function logout() {
            localStorage.removeItem('usuario');
            sessionStorage.removeItem('usuario');
            window.location.href = '/';
        }
    </script>
</body>
</html>