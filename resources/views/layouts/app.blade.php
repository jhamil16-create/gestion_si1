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
      <!-- Marca -->
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
        :title="collapsed ? 'Expandir' : 'Colapsar'"
      >
        <i class="fa-solid" :class="collapsed ? 'fa-angles-right' : 'fa-angles-left'"></i>
      </button>

      <!-- Botón cerrar (móvil) -->
      <button
        class="lg:hidden inline-flex items-center justify-center size-8 rounded-md hover:bg-blue-800/40"
        @click="sidebarOpen=false"
        title="Cerrar"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- NAV -->
    <nav class="mt-3 px-2 overflow-y-auto custom-scrollbar" :style="`height: calc(100vh - 4rem);`">
      <!-- helper: item de menú -->
      <template x-for="item in menu" :key="item.href">
        <a :href="item.href"
           class="group flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium hover:bg-[var(--blue-hover)] transition-colors"
           :class="isActive(item) ? 'bg-[var(--blue-active)]' : ''"
           :title="collapsed ? item.text : null"
        >
          <i :class="`w-5 text-center ${item.icon}`"></i>
          <span class="transition-all duration-200"
                :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100 w-auto'">
            <span x-text="item.text"></span>
          </span>
        </a>
      </template>
    </nav>
  </aside>

  <!-- Overlay móvil -->
  <div
    class="fixed inset-0 bg-black/50 z-40 transition-opacity lg:hidden"
    x-show="sidebarOpen"
    x-transition
    x-cloak
    @click="sidebarOpen=false">
  </div>

  <!-- HEADER + CONTENIDO -->
  <div class="transition-all duration-300" :style="contentStyle">
    <!-- HEADER SUPERIOR -->
    <header class="bg-white shadow-sm sticky top-0 z-30">
      <div class="flex items-center justify-between px-4 h-16">
        <!-- Botón abrir sidebar (móvil) -->
        <button @click="sidebarOpen=true" class="p-2 rounded-lg hover:bg-gray-100 lg:hidden">
          <i class="fas fa-bars text-gray-600"></i>
        </button>

        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Sistema FICCT')</h1>

        <!-- Perfil -->
        <div x-data="{ open:false }" class="relative">
          <button @click="open=!open" class="flex items-center text-sm bg-white border border-gray-200 rounded-full px-3 py-1">
            <span class="mr-2 text-gray-700">{{ auth()->user()?->usuario->nombre ?? 'Usuario' }}</span>
            <i class="fas fa-user-circle text-gray-500"></i>
          </button>
          <div x-show="open" x-cloak @click.away="open=false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg py-2">
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

    <!-- FLASHES + CONTENIDO -->
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

  <!-- ALPINE STORE / LÓGICA -->
  <script>
    function layoutApp(){
      return {
        // estado
        sidebarOpen: false,    // visible en móvil
        collapsed: false,      // colapsado en desktop (solo íconos)
        route: window.location.pathname,

        // menú (ajusta tus rutas Laravel)
        menu: [
          { text:'Inicio',            href:"{{ route('home') }}",               icon:'fas fa-home',                 match:['/','/home'] },
          { text:'Bitácora',          href:"{{ route('bitacoras.index') }}",    icon:'fas fa-history',              match:['/bitacoras'] },
          { text:'Materias',          href:"{{ route('materias.index') }}",     icon:'fas fa-book',                 match:['/materias'] },
          { text:'Docentes',          href:"{{ route('docentes.index') }}",     icon:'fas fa-chalkboard-teacher',   match:['/docentes'] },
          { text:'Administradores',   href:"{{ route('administradores.index') }}", icon:'fas fa-user-shield',     match:['/administradores'] },
          { text:'Gestiones',         href:"{{ route('gestiones.index') }}",    icon:'fas fa-calendar-alt',         match:['/gestiones'] },
          { text:'Aulas',             href:"{{ route('aulas.index') }}",        icon:'fas fa-door-open',            match:['/aulas'] },
          { text:'Grupos',            href:"{{ route('grupos.index') }}",       icon:'fas fa-users',                match:['/grupos'] },
        ],

        // init
        init(){
          // recuperar preferencias
          this.collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
          // en móvil, el sidebar inicia cerrado; en desktop queda a criterio del colapso (si está colapsado, no necesita overlay)
          this.sidebarOpen = false;

          // re-cálculo de layout al redimensionar
          window.addEventListener('resize', () => { this.$nextTick(() => {}); });
        },

        // helpers
        isMobile(){ return window.innerWidth < 1024; }, // < lg

        toggleCollapse(){
          this.collapsed = !this.collapsed;
          localStorage.setItem('sidebarCollapsed', this.collapsed);
        },

        isActive(item){
          const p = this.route;
          return item.match.some(m => p === m || p.startsWith(m));
        },

        // estilos calculados
        get sidebarWidth(){
          // móvil: ancho fijo cuando está abierto (64 = 16rem), cerrado: 0
          if (this.isMobile()) return this.sidebarOpen ? 256 : 0;
          // desktop: expandido 256px, colapsado 80px (w-20)
          return this.collapsed ? 80 : 256;
        },

        get sidebarStyle(){
          const w = this.sidebarWidth;
          // en móvil, el sidebar entra/sale por la izquierda
          const trans = this.isMobile()
            ? `translateX(${this.sidebarOpen ? '0' : '-100%'})`
            : 'translateX(0)';
          return `width:${w}px; transform:${trans};`;
        },

        get contentStyle(){
          // margen izquierdo = ancho del sidebar solo en desktop
          const ml = this.isMobile() ? 0 : this.sidebarWidth;
          return `margin-left:${ml}px;`;
        },
      }
    }
  </script>
</body>
</html>
