@extends('layouts.app')
@section('title', 'Detalles del Administrador')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    
    {{-- 1. CABECERA (Mismo estilo que Grupos) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">
            Administrador: {{ $usuario->nombre }}
        </h2>
        {{-- Botones de acción --}}
        <div class="flex-shrink-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('administradores.edit', $administrador->id_administrador) }}" 
               class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm font-medium">
               <i class="fas fa-pen mr-1"></i> Editar Administrador
            </a>
            <a href="{{ route('administradores.index') }}" 
               class="w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm font-medium">
               &larr; Volver
            </a>
        </div>
    </div>

    {{-- 2. INFORMACIÓN PRINCIPAL (Mismo estilo que Grupos) --}}
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Principal</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Administrador</p>
                <p class="font-semibold font-mono">{{ $administrador->id_administrador }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre Completo</p>
                <p class="font-semibold">{{ $usuario->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Correo Electrónico</p>
                <p class="font-semibold">{{ $usuario->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Rol</p>
                <p class="font-semibold">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Administrador
                    </span>
                </p>
            </div>
        </div>
    </div>

    {{-- 3. ACCIONES (Mismo estilo que Grupos) --}}
    <div class="mt-6">
        
        {{-- Cabecera --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h3 class="text-lg font-semibold">Acciones Disponibles</h3>
        </div>

        {{-- Botones de acción --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('administradores.edit', $administrador->id_administrador) }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors font-medium text-center">
                <i class="fas fa-pen"></i>
                <span>Editar Administrador</span>
            </a>

            <form action="{{ route('administradores.destroy', $administrador->id_administrador) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('¿Estás seguro de eliminar a {{ $usuario->nombre }}? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors font-medium">
                    <i class="fas fa-trash"></i>
                    <span>Eliminar Administrador</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Modal de Confirmación (Mismo que Grupos) --}}
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden">
    <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg shadow-lg">
        
        <div class="text-center">
            <span class="text-red-500">
                <svg class="mx-auto mb-4 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </span>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">¿Estás seguro?</h3>
            <p class="text-gray-600 mb-6">
                ¿Realmente deseas eliminar <span id="modal-item-name" class="font-bold"></span>?
                <br>Esta acción no se puede deshacer.
            </p>
        </div>

        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button id="cancel-delete" type="button" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 font-medium">
                    Cancelar
                </button>
                <button id="confirm-delete" type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                    Sí, Eliminar
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const modal = document.getElementById('delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-form');
        const modalItemName = document.getElementById('modal-item-name');
        const openButtons = document.querySelectorAll('.open-delete-modal');

        openButtons.forEach(button => {
            button.addEventListener('click', function () {
                const actionUrl = this.getAttribute('data-action');
                const itemName = this.getAttribute('data-name');
                
                deleteForm.setAttribute('action', actionUrl);
                modalItemName.textContent = itemName;
                
                modal.classList.remove('hidden');
            });
        });

        cancelButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    });
</script>
@endpush