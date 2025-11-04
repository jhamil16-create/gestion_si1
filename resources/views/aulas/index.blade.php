@extends('layouts.app')
@section('title', 'Aulas')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- MENSAJES FLASH MEJORADOS --}}
    @if(session('success'))
        <div class="mb-4 p-4 flex items-center bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 flex items-center bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md">
            <i class="fas fa-exclamation-circle text-red-600 mr-3 text-lg"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Listado de Aulas</h2>
            <a href="{{ route('aulas.create') }}"
               class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nueva Aula
            </a>
        </div>

        {{-- 
          - El 'overflow-x-auto' ya no es estrictamente necesario si no hay min-w,
          - pero no hace daño y puede ayudar si el contenido es impredecible.
        --}}
        <div class="overflow-x-auto">
            {{-- 
              - ¡CAMBIO CLAVE! Se eliminó 'min-w-[640px]' 
              - Ahora la tabla se ajustará al 100% del contenedor.
            --}}
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <th class="px-4 py-3 border-b font-semibold">ID Aula</th>
                        <th class="px-4 py-3 border-b font-semibold">Tipo</th>
                        {{-- 
                          - ¡CAMBIO CLAVE! Se eliminó 'w-48'
                          - La columna ahora tomará el ancho de su contenido (los botones apilados).
                        --}}
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($aulas as $aula)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-mono font-medium text-gray-800">{{ $aula->id_aula }}</td>
                            <td class="px-4 py-3 border-b">{{ $aula->tipo }}</td>
                            <td class="px-4 py-3 border-b">
                                {{-- 
                                  - Esta parte ya estaba perfecta. 
                                  - 'flex-col' apila los botones en móvil.
                                  - 'sm:flex-row' los pone en fila en pantallas grandes.
                                --}}
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route('aulas.show', $aula) }}"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto"
                                       title="Ver detalles">
                                        <i class="fas fa-eye text-white/80"></i> Ver
                                    </a>
                                    <a href="{{ route('aulas.edit', $aula) }}"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto"
                                       title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="{{ route('aulas.destroy', $aula) }}" method="POST"
                                          class="w-full sm:w-auto"
                                          onsubmit="return confirm('¿Estás seguro de eliminar el aula {{ $aula->id_aula }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full"
                                                title="Eliminar">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-10 text-center text-gray-500">
                                No hay aulas registradas. 
                                <a href="{{ route('aulas.create') }}" class="text-blue-600 underline">Crear una</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection