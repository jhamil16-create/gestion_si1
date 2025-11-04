<!DOCTYPE html>
<html lang="es" x-data="layoutApp()" x-init="init()" :class="{'overflow-hidden': isMobile() && sidebarOpen}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistema Académico FICCT</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

  <style>
    :root{
      --blue-primary:#1a3e6f;
      --blue-hover:#2c5aa0;
      --blue-active:#2563eb;
    }
    .custom-scrollbar::-webkit-scrollbar{ width:6px; }
    .custom-scrollbar::-webkit-scrollbar-track{ background:transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb{ background-color:rgba(0,0,0,.2); border-radius:3px; }
    [x-cloak]{ display:none !important; }

    /* Mejoras de responsividad */
    @media (max-width: 1024px) {
      aside { width: 256px !important; }
      main { padding: 1rem; }
    }

    aside { height: 100vh; overflow-y: auto; }
  </style>
</head>
<body class="bg-gray-100">

  <!-- SIDEBAR -->
  <aside
    class="fixed inset-y-0 left-0 z-50 bg-[var(--blue-primary)] text-white transition-all duration-300 ease-in-out transform"
    :style="sidebarStyle"
    @keydown.window.escape="isMobile() ? sidebarOpen=false : null"
  >
    <!-- Header del sidebar -->
    <div class="h-16 flex items-center justify-between px-3 border-b border-blue-800">
      <div class="flex items-center gap-3 min-w-0">
        <i class="fa-solid fa-graduation-cap text-xl shrink-0"></i>
        <div class="transition-opacity duration-200 whitespace-nowrap overflow-hidden"
             :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
          <div class="text-base font-bold leading-5">Sistema FICCT</div>
          <div class="text-[11px] text-blue-200 leading-3">Gestión Académica</div>
        </div>
      </div>

      <!-- Botón colapsar (desktop) -->
      <button
        class="hidden lg:inline-flex items-center justify-center size-8 rounded-md hover:bg-blue-800/40"
        @click="toggleCollapse()"
        :title="collapsed ? 'Expandir' : 'Colapsar'">
        <i class="fa-solid" :class="collapsed ? 'fa-angles-right' : 'fa-angles-left'"></i>
      </button>

      <!-- Botón cerrar (móvil) -->
      <button
        class="lg:hidden inline-flex items-center justify-center size-8 rounded-md hover:bg-blue-800/40"
        @click="sidebarOpen=false"
        title="Cerrar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- NAV ACORDEÓN -->
    <nav class="mt-3 px-2 overflow-y-auto custom-scrollbar" :style="`height: calc(100vh - 4rem);`">

      @if (auth()->user()->docente)
      <!-- ================= DOCENTE ================= -->
      <div class="space-y-1">

        <!-- Consulta y Operación Docente -->
        <div class="rounded-md" :class="openMenus.consulta ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('consulta')"
            class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.consulta ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-search w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Consulta y Operación Docente</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.consulta, 'opacity-0': collapsed}"></i>
          </button>

          <!-- subitems -->
          <div x-show="openMenus.consulta && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="{{ route('grupos.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-tasks w-4"></i><span>Consultar carga del docente</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-clock w-4"></i><span>Consultar horario del docente</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-pen-to-square w-4"></i><span>Registrar dictado de clase</span>
            </a>
          </div>
        </div>

        <!-- Reportes, Notificaciones y Auditoría -->
        <div class="rounded-md" :class="openMenus.reportes ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('reportes')"
            class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.reportes ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-chart-bar w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Reportes, Notificaciones y Auditoría</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.reportes, 'opacity-0': collapsed}"></i>
          </button>

          <div x-show="openMenus.reportes && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-bell w-4"></i><span>Generar notificaciones</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-file-invoice w-4"></i><span>Reportes académicos</span>
            </a>
          </div>
        </div>

      </div>

      @else
      <!-- ================= ADMINISTRADOR ================= -->
      <div class="space-y-1">

        <!-- Gestión Académica -->
        <div class="rounded-md" :class="openMenus.gestion ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('gestion')"
            class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.gestion ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-university w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Gestión Académica</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.gestion, 'opacity-0': collapsed}"></i>
          </button>

          <div x-show="openMenus.gestion && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="{{ route('docentes.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-chalkboard-teacher w-4"></i><span>Gestionar docentes</span>
            </a>
            <a href="{{ route('materias.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-book w-4"></i><span>Gestionar materias</span>
            </a>
            <a href="{{ route('gestiones.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-calendar-alt w-4"></i><span>Gestionar gestiones académicas</span>
            </a>
            <a href="{{ route('aulas.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-door-open w-4"></i><span>Gestionar aulas</span>
            </a>
            <a href="{{ route('grupos.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-users w-4"></i><span>Gestionar grupos</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-file-export w-4"></i><span>Importar/Exportar catálogos</span>
            </a>
          </div>
        </div>

        <!-- Asignación y Planificación Académica -->
        <div class="rounded-md" :class="openMenus.asignacion ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('asignacion')"
            class="flex items-center gap-3 w-full px-3 py-2 mt-1 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.asignacion ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-clipboard-list w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Asignación y Planificación Académica</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.asignacion, 'opacity-0': collapsed}"></i>
          </button>

          <div x-show="openMenus.asignacion && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-user-plus w-4"></i><span>Asignar materias a docente</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-calendar-check w-4"></i><span>Planificar y publicar horarios</span>
            </a>
          </div>
        </div>

        <!-- Consulta y Operación -->
        <div class="rounded-md" :class="openMenus.consulta ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('consulta')"
            class="flex items-center gap-3 w-full px-3 py-2 mt-1 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.consulta ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-search w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Consulta y Operación</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.consulta, 'opacity-0': collapsed}"></i>
          </button>

          <div x-show="openMenus.consulta && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-tasks w-4"></i><span>Consultar carga del docente</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-clock w-4"></i><span>Consultar horario del docente</span>
            </a>
          </div>
        </div>

        <!-- Reportes, Notificaciones y Auditoría -->
        <div class="rounded-md" :class="openMenus.reportes ? 'bg-[rgba(255,255,255,0.04)]' : ''">
          <button
            @click="toggleMenu('reportes')"
            class="flex items-center gap-3 w-full px-3 py-2 mt-1 text-sm font-medium rounded-md hover:bg-[var(--blue-hover)] transition"
            :class="openMenus.reportes ? 'shadow-inner' : ''">
            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
              <i class="fas fa-chart-bar w-4"></i>
            </span>

            <span :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">Reportes, Notificaciones y Auditoría</span>

            <i class="fa-solid ml-auto transition-transform"
               :class="{'rotate-180': openMenus.reportes, 'opacity-0': collapsed}"></i>
          </button>

          <div x-show="openMenus.reportes && !collapsed" x-transition class="pl-12 pr-3 pb-2 pt-1 space-y-1">
            <a href="{{ route('bitacoras.index') }}" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-history w-4"></i><span>Bitácora / Auditoría</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-bell w-4"></i><span>Generar notificaciones</span>
            </a>
            <a href="#" class="flex items-center gap-2 px-3 py-1 text-sm rounded hover:bg-[var(--blue-hover)]">
              <i class="fas fa-file-invoice w-4"></i><span>Reportes académicos</span>
            </a>
          </div>
        </div>

      </div>
      @endif

    </nav>
  </aside>

  <!-- Overlay móvil -->
  <div class="fixed inset-0 bg-black/50 z-40 transition-opacity lg:hidden"
       x-show="sidebarOpen" x-transition x-cloak @click="sidebarOpen=false"></div>

  <!-- HEADER + CONTENIDO -->
  <div class="transition-all duration-300" :style="contentStyle">
    <header class="bg-white shadow-sm sticky top-0 z-30">
      <div class="flex items-center justify-between px-4 h-16">
        <button @click="sidebarOpen=true" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
          <i class="fas fa-bars text-gray-600"></i>
        </button>

        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Sistema FICCT')</h1>

        <div x-data="{ open:false }" class="relative">
          <button @click="open=!open" class="flex items-center text-sm bg-white border border-gray-200 rounded-full px-3 py-1">
            <span class="mr-2 text-gray-700">{{ auth()->user()?->usuario->nombre ?? 'Usuario' }}</span>
            <i class="fas fa-user-circle text-gray-500"></i>
          </button>
          <div x-show="open" x-cloak @click.away="open=false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg py-2">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Cerrar sesión</button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <main class="p-4 bg-gray-50 min-h-screen">
      {{-- MENSAJES FLASH CENTRALIZADOS (una sola vez aquí) --}}
      @if(session('success'))
        <div class="mb-4 p-4 flex items-center bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md max-w-7xl mx-auto" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
      @endif
      
      @if(session('error'))
        <div class="mb-4 p-4 flex items-center bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md max-w-7xl mx-auto" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <i class="fas fa-exclamation-circle text-red-600 mr-3 text-lg"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <!-- ALPINE STORE -->
  <script>
    function layoutApp(){
      return {
        sidebarOpen: false,
        collapsed: false,
        openMenus: {}, // guarda los submenús (se persistirá en localStorage)
        route: window.location.pathname,

        init(){
          // restaurar colapso
          this.collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
          // restaurar openMenus, si existe
          const saved = localStorage.getItem('openMenus');
          this.openMenus = saved ? JSON.parse(saved) : {};

          // cerrar sidebar al cambiar tamaño a móvil
          window.addEventListener('resize', () => {
            if (this.isMobile()) this.sidebarOpen = false;
          });
        },

        isMobile(){ return window.innerWidth < 1024; },

        toggleCollapse(){
          this.collapsed = !this.collapsed;
          localStorage.setItem('sidebarCollapsed', this.collapsed);
          if(this.collapsed){
            // al colapsar, cerrar submenus (evita que aparezcan al expandir)
            this.openMenus = {};
            localStorage.setItem('openMenus', JSON.stringify(this.openMenus));
          }
        },

        toggleMenu(menu){
          // alterna el menú sin afectar a los otros (persistente)
          this.openMenus[menu] = !this.openMenus[menu];
          localStorage.setItem('openMenus', JSON.stringify(this.openMenus));
        },

        get sidebarWidth(){
          if (this.isMobile()) return this.sidebarOpen ? 256 : 0;
          return this.collapsed ? 80 : 256;
        },

        get sidebarStyle(){
          const w = this.sidebarWidth;
          const trans = this.isMobile()
            ? `translateX(${this.sidebarOpen ? '0' : '-100%'})`
            : 'translateX(0)';
          return `width:${w}px; transform:${trans};`;
        },

        get contentStyle(){
          const ml = this.isMobile() ? 0 : this.sidebarWidth;
          return `margin-left:${ml}px; transition: margin-left 0.3s ease;`;
        },
      }
    }
  </script>
</body>
</html>