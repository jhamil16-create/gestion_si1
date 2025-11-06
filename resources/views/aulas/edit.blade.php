@extends('layouts.app')
@section('title', 'Editar Aula: ' . $aula->id_aula)

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <div class="bg-white rounded-lg shadow-xl p-6 sm:p-8">
        
        {{-- INICIO CORRECCIÓN:
             Se quitan los bloques @if($errors->any()) y @if(session('error'))
             para evitar los mensajes duplicados que viste en tus imágenes.
             Tu 'layouts.app' se debe encargar de mostrar estos mensajes.
        --}}

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

    {{-- Zona de Peligro con Modal --}}
    <div class="bg-white rounded-lg shadow-xl border-l-4 border-red-500 p-6">
        <h3 class="text-lg font-semibold text-red-700 mb-2">Zona de Peligro</h3>
        <p class="text-sm text-gray-600 mb-4">
            Al eliminar esta aula, se perderá permanentemente. Esta acción no se puede deshacer.
        </p>
        
        {{-- INICIO CORRECCIÓN: 
             - Se quita el 'onsubmit'
             - Se da un ID al formulario
             - Se cambia el botón a type="button" y se le da un ID
        --}}
        <form action="{{ route('aulas.destroy', $aula) }}" 
              method="POST" 
              id="delete-form">
            @csrf
            @method('DELETE')
            <button type="button"
                    id="open-delete-modal"
                    class="bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-700 text-sm font-medium transition-colors w-full sm:w-auto">
                <i class="fas fa-trash-alt mr-1"></i>
                Eliminar Aula
            </button>
        </form>
        {{-- FIN CORRECCIÓN --}}
    </div>

</div>


{{-- INICIO CORRECCIÓN: Modal de Confirmación Bonito --}}
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
    <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg shadow-lg">
        
        <!-- Contenido del Modal -->
        <div class="text-center">
            <span class="text-red-500">
                <svg class="mx-auto mb-4 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </span>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">¿Estás seguro?</h3>
            <p class="text-gray-600 mb-6">
                ¿Realmente deseas eliminar el aula "{{ $aula->id_aula }} - {{ $aula->tipo }}"?
                <br>Esta acción no se puede deshacer.
            </p>
        </div>

        <!-- Botones del Modal -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button id="cancel-delete" type="button" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Cancelar
            </button>
            <button id="confirm-delete" type="button" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Sí, Eliminar
            </button>
        </div>
    </div>
</div>
{{-- FIN CORRECCIÓN: Modal --}}


{{-- INICIO CORRECCIÓN: Script para el Modal --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const modal = document.getElementById('delete-modal');
        const openButton = document.getElementById('open-delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const confirmButton = document.getElementById('confirm-delete');
        const deleteForm = document.getElementById('delete-form');

        if (openButton) {
            openButton.addEventListener('click', function () {
                modal.classList.remove('hidden');
            });
        }

        if (cancelButton) {
            cancelButton.addEventListener('click', function () {
                modal.classList.add('hidden');
            });
        }

        if (confirmButton) {
            confirmButton.addEventListener('click', function () {
                deleteForm.submit();
            });
        }
    });
</script>
@endpush
{{-- FIN CORRECCIÓN: Script --}}

@endsection