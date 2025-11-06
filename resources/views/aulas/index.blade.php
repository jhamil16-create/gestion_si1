@extends('layouts.app')
@section('title', 'Aulas')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- INICIO CORRECCIÓN:
         Se quita TODO el bloque de @if(session('success/error'))...@endif
         Esto evita que los mensajes de éxito/error salgan duplicados.
         Tu 'layouts.app' se debe encargar de mostrarlos.
    --}}

    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Listado de Aulas</h2>
            <a href="{{ route('aulas.create') }}"
                class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nueva Aula
            </a>
        </div>

        <div>

            {{-- INICIO CORRECCIÓN: 1. VISTA DE TABLA (Oculta en móvil) --}}
            <table class="w-full border-collapse hidden sm:table">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <th class="px-4 py-3 border-b font-semibold">ID Aula</th>
                        <th class="px-4 py-3 border-b font-semibold">Tipo</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($aulas as $aula)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-mono font-medium text-gray-800">{{ $aula->id_aula }}</td>
                            <td class="px-4 py-3 border-b">{{ $aula->tipo }}</td>
                            <td class="px-4 py-3 border-b">
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

                                    {{-- INICIO CORRECCIÓN: Botón de Modal (Tabla) --}}
                                    {{-- SE AÑADIÓ 'sm:w-auto' para que sea responsivo igual que los otros botones --}}
                                    <button type="button" 
                                            class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full sm:w-auto" 
                                            title="Eliminar"
                                            data-action="{{ route('aulas.destroy', $aula) }}"
                                            data-name="{{ $aula->id_aula }} ({{ $aula->tipo }})">
                                        <i class="fas fa-trash text-white/80"></i> Eliminar
                                    </button>
                                    {{-- FIN CORRECCIÓN --}}

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-10 text-center text-gray-500">
                                No hay aulas registradas.
                                {{-- INICIO CORRECCIÓN: Se quita el <a> duplicado --}}
                                {{-- <a href="{{ route('aulas.create') }}" class="text-blue-600 underline">Crear una</a> --}}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- FIN CORRECCIÓN: 1. VISTA DE TABLA --}}


            {{-- INICIO CORRECCIÓN: 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="sm:hidden px-4 py-4 space-y-4">
                @forelse ($aulas as $aula)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        
                        <div class="flex justify-between items-center mb-2 pb-2 border-b">
                            <span class="text-sm font-semibold text-gray-500 uppercase">ID Aula</span>
                            <span class="font-mono font-medium text-gray-800 text-right">{{ $aula->id_aula }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Tipo</span>
                            <span class="text-sm text-gray-700">{{ $aula->tipo }}</span>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-2 border-t pt-4">
                            <a href="{{ route('aulas.show', $aula) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full" title="Ver detalles">
                                <i class="fas fa-eye text-white/80"></i> Ver
                            </a>
                            <a href="{{ route('aulas.edit', $aula) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" title="Editar">
                                <i class="fas fa-pen text-white/80"></i> Editar
                            </a>

                            {{-- INICIO CORRECCIÓN: Botón de Modal (Móvil) --}}
                            {{-- Este ya estaba bien con 'w-full' para la vista de tarjeta --}}
                            <button type="button" 
                                    class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" 
                                    title="Eliminar"
                                    data-action="{{ route('aulas.destroy', $aula) }}"
                                    data-name="{{ $aula->id_aula }} ({{ $aula->tipo }})">
                                <i class="fas fa-trash text-white/80"></i> Eliminar
                            </button>
                            {{-- FIN CORRECCIÓN --}}
                        </div>
                    </div>
                @empty
                    <div class="px-3 py-10 text-center text-gray-500">
                        No hay aulas registradas.
                        {{-- INICIO CORRECCIÓN: Se quita el <a> duplicado --}}
                    </div>
                @endforelse
            </div>
            {{-- FIN CORRECCIÓN: 2. VISTA DE TARJETAS --}}

        </div>
    </div>
</div>


{{-- INICIO CORRECCIÓN: Modal de Confirmación Único y Dinámico --}}
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
                ¿Realmente deseas eliminar el aula "<span id="modal-item-name" class="font-bold"></span>"?
                <br>Esta acción no se puede deshacer.
            </p>
        </div>

        {{-- Este formulario se llenará dinámicamente con la URL correcta --}}
        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button id="cancel-delete" type="button" class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Cancelar
                </button>
                <button id="confirm-delete" type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Sí, Eliminar
                </button>
            </div>
        </form>

    </div>
</div>
{{-- FIN CORRECCIÓN: Modal --}}


{{-- INICIO CORRECCIÓN: Script para el Modal Dinámico --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Elementos del Modal
        const modal = document.getElementById('delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-form');
        const modalItemName = document.getElementById('modal-item-name'); // ID Genérico
        
        // Todos los botones que abren el modal (tanto en tabla como en tarjeta)
        const openButtons = document.querySelectorAll('.open-delete-modal');

        // Asignar evento a cada botón de "Eliminar"
        openButtons.forEach(button => {
            button.addEventListener('click', function () {
                // 1. Obtener los datos del botón que fue clickeado
                const actionUrl = this.getAttribute('data-action');
                const itemName = this.getAttribute('data-name');
                
                // 2. Configurar el modal con esos datos
                deleteForm.setAttribute('action', actionUrl);
                modalItemName.textContent = itemName; // Usamos el ID genérico
                
                // 3. Mostrar el modal
                modal.classList.remove('hidden');
            });
        });

        // Evento para el botón "Cancelar"
        cancelButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    });
</script>
@endpush
{{-- FIN CORRECCIÓN: Script --}}

@endsection