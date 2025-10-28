<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sistema Académico FICCT</title>

    <!-- Tailwind CDN (para desarrollo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <style>
        :root {
            --blue-primary: #1a3e6f;
            --blue-hover: #2c5aa0;
            --blue-active: #2563eb;
        }

        /* Custom scrollbar (opcional) */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.2); border-radius: 6px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.32); }

        /* Evitar que textos de los navs se corten al colapsar */
        .nav-label { transition: opacity .2s ease, transform .2s ease; transform-origin: left center; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased"
      x-data="sidebarData()"
      x-init="init()"
>

<script>
    function sidebarData() {
        return {
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || window.innerWidth >= 1024,
            usuario: JSON.parse(localStorage.getItem('usuario') || sessionStorage.getItem('usuario') || '{}'),
            route: window.location.pathname,
            init() {
                // redirigir si no está logueado
                if (!this.usuario || !this.usuario.loggedIn) {
                    window.location.href = '/';
                }
                // Escuchar cambios de tamaño para comportamientos responsive
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        // en desktop mantener visible si no está explícitamente colapsado
                        if (localStorage.getItem('sidebarOpen') === null) this.sidebarOpen = true;
                    }
                });
            },
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
            }
        }
    }
</script>

<!-- Overlay móvil -->
<div
    x-show="sidebarOpen && window.innerWidth < 1024"
    x-transition
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    style="display: none;"
></div>

<div class="flex">
    <!-- SIDEBAR -->
    <aside
        id="sidebar"
        class="fixed z-50 top-0 left-0 h-screen bg-[var(--blue-primary)] text-white transition-all duration-300 ease-in-out overflow-hidden"
        :class="sidebarOpen ? 'w-64' : 'w-16 lg:w-16'"
        aria-label="Sidebar"
    >
        <!-- Header -->
        <div class="h-16 flex items-center px-3 border-b border-blue-800">
            <div class="flex items-center w-full">
                <div class="flex items-center">
                    
                </div>
                <div class="ml-2">
                    <div class="text-lg font-bold transition-opacity" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Sistema FICCT</div>
                    <div class="text-xs text-blue-200 transition-opacity" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Gestión Académica</div>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="mt-4 px-2 py-4 overflow-y-auto custom-scrollbar" style="height: calc(100vh - 4rem);">
            <!-- Dashboard -->
            <a :class="{'bg-[var(--blue-active)]': route === '/dashboard'}"
               href="/dashboard"
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors group"
               title="Dashboard"
            >
                <i class="fas fa-chart-line w-5 text-center flex-shrink-0"></i>
                <span class="ml-3 nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Dashboard</span>
            </a>

            <!-- Menú Admin -->
            <template x-if="usuario.rol === 'admin'">
                <div class="mt-3 space-y-1">
                    <a :class="{'bg-[var(--blue-active)]': route === '/usuarios'}" href="/usuarios"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Gestionar Usuarios">
                        <i class="fas fa-users w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Gestionar Usuarios</span>
                    </a>

                    <a :class="{'bg-[var(--blue-active)]': route === '/docentes'}" href="/docentes"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Gestionar Docentes">
                        <i class="fas fa-chalkboard-teacher w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Gestionar Docentes</span>
                    </a>

                    <a :class="{'bg-[var(--blue-active)]': route === '/materias'}" href="/materias"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Gestionar Materias">
                        <!-- Ícono corregido: mantener flex-shrink-0 y espacio -->
                        <i class="fas fa-book w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Gestionar Materias</span>
                    </a>

                    <a :class="{'bg-[var(--blue-active)]': route === '/asignaciones'}" href="/asignaciones"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Asignar Materias">
                        <i class="fas fa-plus-circle w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Asignar Materias</span>
                    </a>

                    <a :class="{'bg-[var(--blue-active)]': route === '/asignaciones/consulta'}" href="/asignaciones/consulta"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Consultar Carga">
                        <i class="fas fa-search w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Consultar Carga</span>
                    </a>
                </div>
            </template>

            <!-- Menú Docente -->
            <template x-if="usuario.rol === 'docente'">
                <div class="mt-3">
                    <a :class="{'bg-[var(--blue-active)]': route === '/asignaciones/consulta'}" href="/asignaciones/consulta"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors" title="Mi Carga Horaria">
                        <i class="fas fa-calendar-alt w-5 text-center flex-shrink-0 mr-3"></i>
                        <span class="nav-label" x-bind:class="sidebarOpen ? 'opacity-100' : 'opacity-0'">Mi Carga Horaria</span>
                    </a>
                </div>
            </template>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 min-h-screen transition-margin duration-300"
         :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-16'">
        <!-- Header -->
        <header class="bg-white shadow-sm z-30 sticky top-0">
            <div class="flex items-center justify-between px-4 h-16">
                <div class="flex items-center">
                    <button @click="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 mr-4" aria-label="Toggle sidebar">
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="flex items-center">
                        <img src="/img/logoFicct.png" class="h-8" alt="logo" />
                        <h1 class="text-xl font-semibold text-gray-800 ml-3">Sistema FICCT</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="hidden sm:flex items-center mr-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-800" title="Notificaciones">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-3 3H9a3 3 0 01-3-3v-1m9 0H6"/>
                            </svg>
                            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-sm bg-white border border-gray-200 rounded-full px-3 py-1 hover:shadow" aria-expanded="false">
                            <span class="mr-2 text-gray-700" x-text="usuario.nombre || 'Usuario'"></span>
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.61 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg py-2">
                            <div class="px-4 py-2 text-sm text-gray-700"> <strong x-text="usuario.nombre || 'Nombre'"></strong></div>
                            <div class="px-4 py-2 text-xs text-gray-500" x-text="usuario.rol || 'Rol'"></div>
                            <div class="border-t border-gray-100 mt-2"></div>
                            <button @click="() => { localStorage.removeItem('usuario'); sessionStorage.removeItem('usuario'); window.location.href = '/'; }" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 custom-scrollbar p-6">
            <div class="container mx-auto px-4">
                @yield('content')
            </div>
        </main>
    </div>
</div>

</body>
</html>
