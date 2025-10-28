<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Académico FICCT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --blue-primary: #1a3e6f;
            --blue-hover: #2c5aa0;
            --blue-active: #2563eb;
        }
        html, body {
            height: 100%;
            overflow: hidden;
        }
        /* Estilos para scroll personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 2px;
        }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body class="h-full bg-gray-100" 
      x-data="{ 
          sidebarOpen: localStorage.getItem('sidebarOpen') === 'true',
          usuario: JSON.parse(localStorage.getItem('usuario') || sessionStorage.getItem('usuario') || '{}'),
          route: window.location.pathname,
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              localStorage.setItem('sidebarOpen', this.sidebarOpen);
          }
      }" 
      x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))">
    <!-- Verificación de sesión -->
    <script>
        if (!JSON.parse(localStorage.getItem('usuario') || sessionStorage.getItem('usuario') || '{}').loggedIn) {
            window.location.href = '/';
        }
    </script>

    <!-- Overlay para móviles -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="toggleMenu()"></div>

    <!-- Contenedor principal con flexbox -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar con fondo azul completo -->
        <aside id="sidebar" class="fixed lg:relative h-full bg-[var(--blue-primary)] text-white transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 z-50"
               :class="sidebarOpen ? 'w-64' : 'w-0 lg:w-16'">
            <!-- Header del sidebar -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-blue-800 overflow-hidden">
                <div class="flex items-center min-w-[16rem] overflow-hidden">
                    <!-- Eliminado logo duplicado -->
                    <div class="transition-opacity duration-300 whitespace-nowrap"
                         :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}">
                        <div class="text-lg font-bold">Sistema FICCT</div>
                        <div class="text-xs text-blue-200">Gestión Académica</div>
                    </div>
                </div>
            </div>

        <!-- Navegación con scroll vertical -->
        <nav class="mt-4 px-2 overflow-y-auto custom-scrollbar" style="height: calc(100vh - 4rem);">
            <!-- Dashboard -->
            <a :class="{ 'bg-[var(--blue-active)]': route === '/dashboard' }" 
               href="/dashboard" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors group relative min-w-[16rem]">
                <i class="fas fa-chart-line w-5 text-center flex-shrink-0"></i>
                <span class="ml-3 transition-opacity duration-300 whitespace-nowrap"
                      :class="{'opacity-0 lg:opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}">
                    Dashboard
                </span>
                <!-- Tooltip para estado colapsado -->
                <div class="hidden lg:group-hover:block absolute left-16 bg-gray-900 text-white px-2 py-1 rounded text-sm whitespace-nowrap"
                     x-show="!sidebarOpen">
                    Dashboard
                </div>
            </a>            <!-- Menú Admin -->
            <template x-if="usuario.rol === 'admin'">
                <div class="mt-3 space-y-1">
                    <a :class="{ 'bg-[var(--blue-active)]': route === '/usuarios' }" 
                       href="/usuarios" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-users w-5 text-center mr-3"></i>
                        <span>Gestionar Usuarios</span>
                    </a>

                    <a :class="{ 'bg-[var(--blue-active)]': route === '/docentes' }" 
                       href="/docentes" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-chalkboard-teacher w-5 text-center mr-3"></i>
                        <span>Gestionar Docentes</span>
                    </a>

                    <a :class="{ 'bg-[var(--blue-active)]': route === '/materias' }" 
                       href="/materias" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-book w-5 text-center mr-3"></i>
                        <span>Gestionar Materias</span>
                    </a>

                    <a :class="{ 'bg-[var(--blue-active)]': route === '/asignaciones' }" 
                       href="/asignaciones" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-plus-circle w-5 text-center mr-3"></i>
                        <span>Asignar Materias</span>
                    </a>

                    <a :class="{ 'bg-[var(--blue-active)]': route === '/asignaciones/consulta' }" 
                       href="/asignaciones/consulta" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-search w-5 text-center mr-3"></i>
                        <span>Consultar Carga</span>
                    </a>
                </div>
            </template>

            <!-- Menú Docente -->
            <template x-if="usuario.rol === 'docente'">
                <div class="mt-3">
                    <a :class="{ 'bg-[var(--blue-active)]': route === '/asignaciones/consulta' }" 
                       href="/asignaciones/consulta" 
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors">
                        <i class="fas fa-calendar-alt w-5 text-center mr-3"></i>
                        <span>Mi Carga Horaria</span>
                    </a>
                </div>
            </template>
        </nav>
    </aside>    <!-- Overlay para móviles -->
    <div class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity" 
         x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         style="display: none;"></div>

    <!-- Contenido principal -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm z-30">
            <div class="flex items-center justify-between px-4 h-16">
                <div class="flex items-center">
                    <!-- Botón hamburguesa SIEMPRE visible -->
                    <button onclick="toggleMenu()" class="p-2 rounded-lg hover:bg-gray-100 mr-4">
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                            <path id="menuIcon" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="flex items-center">
                        <img src="/img/logoFicct.png" class="h-8" alt="logo">
                        <h1 class="text-xl font-semibold text-gray-800 ml-3">Sistema FICCT</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="hidden sm:flex items-center mr-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-3 3H9a3 3 0 01-3-3v-1m9 0H6"/></svg>
                            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-sm bg-white border border-gray-200 rounded-full px-3 py-1 hover:shadow">
                            <span class="mr-2 text-gray-700" x-text="usuario.nombre"></span>
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.61 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg py-2">
                            <div class="px-4 py-2 text-sm text-gray-700"> <strong x-text="usuario.nombre"></strong></div>
                            <div class="px-4 py-2 text-xs text-gray-500" x-text="usuario.rol"></div>
                            <div class="border-t border-gray-100 mt-2"></div>
                            <button @click="() => { localStorage.removeItem('usuario'); sessionStorage.removeItem('usuario'); window.location.href = '/'; }" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Área de contenido principal -->
        <main class="flex-1 overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="container mx-auto px-4 py-6">
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
                
                // Toggle clases para mostrar/ocultar
                if (window.innerWidth >= 1024) { // Desktop
                    sidebar.classList.toggle('lg:w-64');
                    sidebar.classList.toggle('lg:w-16');
                    mainContent.classList.toggle('lg:ml-64');
                    mainContent.classList.toggle('lg:ml-16');
                    toggleIcon.classList.toggle('rotate-180');
                    
                    // Toggle textos
                    const isCollapsed = sidebar.classList.contains('lg:w-16');
                    if (isCollapsed) {
                        sidebarText.style.opacity = '0';
                        navTexts.forEach(text => text.style.opacity = '0');
                    } else {
                        sidebarText.style.opacity = '1';
                        navTexts.forEach(text => text.style.opacity = '1');
                    }
                    
                    // Guardar preferencia
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                } else { // Mobile
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }
            }

            // Inicializar estado del sidebar
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('main-content');
                const sidebarText = document.getElementById('sidebar-text');
                const navTexts = document.querySelectorAll('#nav-text');
                const toggleIcon = document.getElementById('toggle-icon');
                
                // Cargar estado guardado
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                
                if (isCollapsed && window.innerWidth >= 1024) {
                    sidebar.classList.remove('lg:w-64');
                    sidebar.classList.add('lg:w-16');
                    mainContent.classList.remove('lg:ml-64');
                    mainContent.classList.add('lg:ml-16');
                    toggleIcon.classList.add('rotate-180');
                    sidebarText.style.opacity = '0';
                    navTexts.forEach(text => text.style.opacity = '0');
                }
            });

            // Reiniciar estado en cambio de tamaño de ventana
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    if (overlay) overlay.classList.add('hidden');
                }
            });
        </script>
</body>
</html>