@extends('layouts.app')
@section('title', 'Detalle: ' . $aula->id_aula)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- 
      - Cabecera se apila en móvil (flex-col) y se alinea al inicio
      - En 'sm' vuelve a ser fila (sm:flex-row)
      - Padding ajustado para móvil (p-6)
    --}}
    <div class="bg-white sm:rounded-lg shadow-xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-sm font-medium text-gray-500">Detalle del Aula</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $aula->id_aula }}</p>
        </div>
        {{-- Botones se apilan (flex-col) y ocupan ancho completo (w-full) en móvil --}}
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="{{ route('aulas.index') }}" 
               class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-arrow-left mr-1"></i>
                Volver
            </a>
            <a href="{{ route('aulas.edit', $aula) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-pen mr-1"></i>
                Editar
            </a>
        </div>
    </div>

    {{-- 
      - Tarjeta de información general: padding ajustado y sin redondeo en móvil 
      - El grid 'md:grid-cols-2' ya es responsivo (1 col en móvil, 2 en md). ¡Bien hecho!
    --}}
    <div class="bg-white sm:rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Información General</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <p class="text-gray-500 text-sm font-medium">ID Aula (Código)</p>
                <p class="font-semibold text-lg text-gray-800">{{ $aula->id_aula }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Tipo</p>
                <p class="font-semibold text-lg text-gray-800">{{ $aula->tipo }}</p>
            </div>
            
        </div>
    </div>

    {{-- Tarjeta de horarios: sin redondeo en móvil --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 p-6 border-b">Horarios Asignados</h3>
        @if($aula->asignacionesHorario && $aula->asignacionesHorario->count() > 0)
            {{-- 'overflow-x-auto' ya hace esta tabla responsiva (con scroll horizontal) --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    {{-- ... (contenido de la tabla sin cambios) ... --}}
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">Esta aula no tiene horarios asignados actualmente.</p>
            </div>
        @endif
    </div>

    {{-- Zona de peligro: padding ajustado y botón responsivo --}}
    <div class="bg-white sm:rounded-lg shadow-xl border-l-4 border-red-500 p-6">
        <h3 class="text-lg font-semibold text-red-700 mb-2">Zona de Peligro</h3>
        <p class="text-sm text-gray-600 mb-4">
            Al eliminar esta aula, se perderá permanentemente. Esta acción no se puede deshacer.
        </p>
        <form action="{{ route('aulas.destroy', $aula) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar el aula {{ $aula->id_aula }}? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            {{-- Botón ahora es w-full en móvil y sm:w-auto para pantallas más grandes --}}
            <button type="submit"
                    class="bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-700 text-sm font-medium transition-colors w-full sm:w-auto">
                <i class="fas fa-trash-alt mr-1"></i>
                Eliminar Aula
            </button>
        </form>
    </div>
</div>
@endsection