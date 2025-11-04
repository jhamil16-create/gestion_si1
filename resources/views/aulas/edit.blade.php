@extends('layouts.app')
@section('title', 'Editar Aula: ' . $aula->id_aula)

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    {{-- Se ha ajustado el padding para móviles (p-6) y se mantiene (p-8) para pantallas sm y superiores --}}
    <div class="bg-white rounded-lg shadow-xl p-6 sm:p-8">
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md">
                {{-- ... (contenido sin cambios) ... --}}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 flex items-center bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md">
                {{-- ... (contenido sin cambios) ... --}}
            </div>
        @endif

        <form action="{{ route('aulas.update', $aula) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- CAMPO 'id_aula' (deshabilitado) --}}
            <div>
                <label for="id_aula" class="block text-sm font-semibold text-gray-700 mb-1">
                    <i class="fas fa-hashtag w-5 mr-1 text-gray-400"></i>
                    ID de Aula
                </label>
                <input type="number" name="id_aula" id="id_aula" value="{{ $aula->id_aula }}"
                       class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 bg-gray-100 cursor-not-allowed"
                       readonly disabled>
                <p class="text-sm text-gray-500 mt-1">El ID de Aula no se puede modificar.</p>
            </div>

            {{-- CAMPO 'tipo' --}}
            <div>
                <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-1">
                    <i class="fas fa-tag w-5 mr-1 text-gray-400"></i>
                    Tipo <span class="text-red-600">*</span>
                </label>
                <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $aula->tipo) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 @error('tipo') border-red-500 @enderror"
                       maxlength="30" placeholder="p. ej. Laboratorio, Teoría, Auditorio" required>
                @error('tipo')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- BOTONES --}}
            {{-- 
              - Se apilan en columna en móvil (flex-col-reverse)
              - Se ponen en fila desde 'sm' (sm:flex-row)
              - Se añade espacio (gap-3)
            --}}
            <div class="pt-6 mt-6 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <a href="{{ route('aulas.index') }}"
                   class="bg-white border border-gray-300 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-50 text-sm font-medium transition-colors w-full sm:w-auto text-center">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-[var(--blue-primary)] text-white px-5 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto">
                    Actualizar Aula
                </button>
            </div>
        </form>
    </div>

    {{-- Se ha ajustado el padding para móviles (p-6) --}}
    <div class="bg-white rounded-lg shadow-xl border-l-4 border-red-500 p-6">
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