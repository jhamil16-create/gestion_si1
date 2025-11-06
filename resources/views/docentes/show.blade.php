@extends('layouts.app')
@section('title', 'Detalle de Docente')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    
    <!-- Botones responsivos -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">
            Docente: {{ $docente->usuario->nombre ?? '—' }}
        </h2>
        <div class="flex-shrink-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('docentes.edit', $docente->id_docente) }}" 
               class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('docentes.index') }}" 
               class="w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>

    {{-- Información del Docente --}}
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Personal</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Nombre Completo</p>
                <p class="font-semibold">{{ $docente->usuario->nombre ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold">{{ $docente->usuario->email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Teléfono</p>
                <p class="font-semibold">{{ $docente->usuario->telefono ?? 'No registrado' }}</p>
            </div>
        </div>
    </div>

    {{-- Grupos que imparte --}}
    @if($docente->grupos && $docente->grupos->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Grupos que Imparte</h3>
            
            {{-- 1. Tabla (Solo para Desktop) --}}
            <div class="overflow-x-auto hidden sm:block">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th class="border px-4 py-2 font-semibold">Nombre Grupo</th>
                            <th class="border px-4 py-2 font-semibold">Materia</th>
                            {{-- <th class="border px-4 py-2">Capacidad</th> --}} {{-- CORRECCIÓN: Columna eliminada --}}
                            <th class="border px-4 py-2 font-semibold">Gestión</th>
                            <th class="border px-4 py-2 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($docente->grupos as $grupo)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $grupo->nombre ?? '—' }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($grupo->materia)->nombre ?? 'N/A' }}
                                    @if(!empty($grupo->sigla))
                                        <span class="text-gray-500 text-sm">({{ $grupo->sigla }})</span>
                                    @endif
                                </td>
                                
                                {{-- <td class="border px-4 py-2">{{ $grupo->capacidad ?? 0 }} estudiantes</td> --}} {{-- CORRECCIÓN: Columna eliminada --}}
                                
                                {{-- INICIO CORRECCIÓN: Mostrar nombre de gestión --}}
                                <td class="border px-4 py-2">
                                    {{ optional($grupo->gestionAcademica)->nombre ?? 'N/A' }}
                                </td>
                                {{-- FIN CORRECCIÓN --}}

                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('grupos.show', $grupo->id_grupo) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                        Ver Grupo
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- 2. Tarjetas (Solo para Móvil) --}}
            <div class="space-y-4 sm:hidden">
                @foreach($docente->grupos as $grupo)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="flex justify-between items-center mb-2 pb-2 border-b">
                        <span class="text-sm font-semibold text-gray-500 uppercase">Grupo</span>
                        <span class="font-medium text-gray-800 text-right">{{ $grupo->nombre ?? '—' }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Materia</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ optional($grupo->materia)->nombre ?? 'N/A' }}
                            @if(!empty($grupo->sigla))
                                ({{ $grupo->sigla }})
                            @endif
                        </span>
                    </div>

                    {{-- INICIO CORRECCIÓN: Mostrar nombre de gestión --}}
                    <div class="flex justify-between items-center mb-4"> {{-- Se agregó mb-4 --}}
                        <span class="text-sm font-semibold text-gray-500">Gestión</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ optional($grupo->gestionAcademica)->nombre ?? 'N/A' }}
                        </span>
                    </div>
                    {{-- FIN CORRECCIÓN --}}
                    
                    {{-- CORRECCIÓN: Div de Capacidad eliminado --}}
                    
                    <div class="flex flex-col items-center justify-center gap-2 border-t pt-3">
                         <a href="{{ route('grupos.show', $grupo->id_grupo) }}" 
                            class="w-full text-center bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                            Ver Grupo
                         </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">Este docente no tiene grupos asignados actualmente.</p>
        </div>
    @endif

    {{-- INICIO CORRECCIÓN: Botón de Eliminar con Modal --}}
    <div class="mt-6 pt-6 border-t">
        <button type="button"
                class="open-delete-modal bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-medium"
                data-action="{{ route('docentes.destroy', $docente->id_docente) }}"
                data-name="al docente {{ $docente->usuario->nombre }} (esta acción también eliminará su usuario asociado)">
            Eliminar Docente
        </button>
    </div>
    {{-- FIN CORRECCIÓN --}}

</div>


{{-- INICIO: Modal de Confirmación Único y Dinámico --}}
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
{{-- FIN: Modal --}}
@endsection


{{-- INICIO: Script para el Modal Dinámico --}}
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