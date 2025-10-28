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
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-100"
      x-data="{
          sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
          route: window.location.pathname,
          toggleSidebar() {
              this.sidebarOpen = !this.sidebarOpen;
              localStorage.setItem('sidebarOpen', this.sidebarOpen);
          }
      }">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 bg-[var(--blue-primary)] text-white transition-all duration-300 ease-in-out transform"
           :class="sidebarOpen ? 'w-64' : 'w-16 -translate-x-0 lg:translate-x-0'">
        <div class="h-16 flex items-center justify-between px-4 border-b border-blue-800">
            <div class="flex items-center min-w-0">
                <div class="transition-opacity duration-300 whitespace-nowrap overflow-hidden"
                     :class="{'opacity-100': sidebarOpen, 'opacity-0': !sidebarOpen}">
                    <div class="text-lg font-bold">Sistema FICCT</div>
                    <div class="text-xs text-blue-200">Gestión Académica</div>
                </div>
            </div>
        </div>

        <nav class="mt-4 px-2 overflow-y-auto custom-scrollbar" style="height: calc(100vh - 4rem);">
            <!-- Dashboard -->
            <a href="{{ route('home') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route === '/' || route === '/home'}">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Inicio</span>
            </a>

            <!-- Bitácora (todos los roles) -->
            <a href="{{ route('bitacoras.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/bitacoras')}">
                <i class="fas fa-history w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Bitácora</span>
            </a>

            <!-- Materias -->
            <a href="{{ route('materias.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/materias')}">
                <i class="fas fa-book w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Materias</span>
            </a>

            <!-- Docentes -->
            <a href="{{ route('docentes.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/docentes')}">
                <i class="fas fa-chalkboard-teacher w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Docentes</span>
            </a>

            <!-- Administradores -->
            <a href="{{ route('administradores.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/administradores')}">
                <i class="fas fa-user-shield w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Administradores</span>
            </a>

            <!-- Gestiones -->
            <a href="{{ route('gestiones.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/gestiones')}">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Gestiones</span>
            </a>

            <!-- Aulas -->
            <a href="{{ route('aulas.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/aulas')}">
                <i class="fas fa-door-open w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Aulas</span>
            </a>

            <!-- Grupos -->
            <a href="{{ route('grupos.index') }}" 
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
               :class="{'bg-[var(--blue-active)]': route.startsWith('/grupos')}">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="ml-3" :class="{'hidden': !sidebarOpen}">Grupos</span>
            </a>
        </nav>
    </aside>

    <!-- Overlay móvil -->
    <div class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity"
         x-show="sidebarOpen"
         x-transition
         @click="sidebarOpen = false"
         style="display: none;"></div>

    <!-- Contenido principal -->
    <div class="ml-0 lg:ml-16 transition-all duration-300" :class="{'ml-64': sidebarOpen && window.innerWidth >= 1024}">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-4 h-16">
                <button @click="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Sistema FICCT')</h1>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-sm bg-white border border-gray-200 rounded-full px-3 py-1">
                        <span class="mr-2 text-gray-700">{{ auth()->user()?->usuario->nombre ?? 'Usuario' }}</span>
                        <i class="fas fa-user-circle text-gray-500"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg py-2">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="p-4 bg-gray-50 min-h-screen">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>