@extends('layouts.app')
@section('title', 'Editar Gestión')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Editar Gestión Académica</h2>
        <a href="{{ route('gestiones.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
           Volver
        </a>
    </div>

    {{-- INICIO CORRECCIÓN:
         Se quita el bloque @if(session('error'))...@endif
         Asumimos que tu layout principal 'layouts.app' ya se encarga
         de mostrar TODOS los mensajes (success y error) una sola vez.
         Esto soluciona el problema de mensajes duplicados.
    --}}

    <form action="{{ route('gestiones.update', $gestione) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nombre <span class="text-red-600">*</span></label>
            <input type="text" name="nombre" value="{{ old('nombre', $gestione->nombre) }}"
                   class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                   maxlength="30">
            @error('nombre')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Fecha Inicio <span class="text-red-600">*</span></label>
                <input type="date" name="fecha_inicio"
                       value="{{ old('fecha_inicio', optional($gestione->fecha_inicio)->format('Y-m-d')) }}"
                       class="w-full border rounded px-3 py-2 @error('fecha_inicio') border-red-500 @enderror">
                @error('fecha_inicio')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Fecha Fin <span class="text-red-600">*</span></label>
                <input type="date" name="fecha_fin"
                       value="{{ old('fecha_fin', optional($gestione->fecha_fin)->format('Y-m-d')) }}"
                       class="w-full border rounded px-3 py-2 @error('fecha_fin') border-red-500 @enderror">
                @error('fecha_fin')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-2 flex items-center gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>

            {{-- INICIO CORRECCIÓN:
                 El formulario de eliminar ahora no tiene 'onsubmit'.
                 El botón de abajo (fuera del form) lo activará.
            --}}
            <form action="{{ route('gestiones.destroy', $gestione) }}" method="POST" id="delete-form">
                @csrf
                @method('DELETE')
                
                {{-- INICIO CORRECCIÓN:
                     Se cambia el botón de 'submit' a 'button'
                     y se le da un ID para que lo controle el script.
                --}}
                <button type="button" id="open-delete-modal"
                        class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700">
                    Eliminar
                </button>
            </form>
        </div>
    </form>
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
                ¿Realmente deseas eliminar la gestión "{{ $gestione->nombre }}"?
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
    // Espera a que el documento esté listo
    document.addEventListener('DOMContentLoaded', function () {
        
        // Obtenemos los elementos
        const modal = document.getElementById('delete-modal');
        const openButton = document.getElementById('open-delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const confirmButton = document.getElementById('confirm-delete');
        const deleteForm = document.getElementById('delete-form');

        // Función para mostrar el modal
        if (openButton) {
            openButton.addEventListener('click', function () {
                modal.classList.remove('hidden');
            });
        }

        // Función para ocultar el modal
        if (cancelButton) {
            cancelButton.addEventListener('click', function () {
                modal.classList.add('hidden');
            });
        }

        // Función para enviar el formulario de eliminar
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