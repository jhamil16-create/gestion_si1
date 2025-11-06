@extends('layouts.app')
@section('title', 'Detalle: ' . $aula->id_aula)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-white sm:rounded-lg shadow-xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-sm font-medium text-gray-500">Detalle del Aula</h2>
            <p class="text-2xl font-bold text-gray-800">{{ $aula->id_aula }} - {{ $aula->tipo }}</p>
        </div>
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

    <div class="bg-white sm:rounded-lg shadow-xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-0 p-6 border-b">Horarios Asignados</h3>
        
        @if($aula->asignacionesHorario && $aula->asignacionesHorario->count() > 0)
            
            {{-- INICIO CORRECCIÓN: 1. VISTA DE TABLA (Oculta en móvil) --}}
            <div class="overflow-x-auto hidden sm:block">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left text-sm text-gray-600">
                        <tr>
                            <th class="px-6 py-3 font-medium">Grupo</th>
                            <th class="px-6 py-3 font-medium">Materia</th>
                            <th class="px-6 py-3 font-medium">Día</th>
                            <th class="px-6 py-3 font-medium">Hora</th>
                            <th class="px-6 py-3 font-medium text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($aula->asignacionesHorario as $horario)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $horario->grupo->materia->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $horario->dia }}</td>
                            <td class="px-6 py-4">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('grupos.show', $horario->id_grupo) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    Ver Grupo
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- FIN CORRECCIÓN: 1. VISTA DE TABLA --}}


            {{-- INICIO CORRECCIÓN: 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="space-y-4 sm:hidden p-4">
                @foreach($aula->asignacionesHorario as $horario)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="flex justify-between items-center mb-2 pb-2 border-b">
                        <span class="text-sm font-semibold text-gray-500 uppercase">Grupo</span>
                        <span class="font-medium text-gray-800 text-right">{{ $horario->grupo->nombre ?? 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Materia</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ $horario->grupo->materia->nombre ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Día</span>
                        <span class="text-sm text-gray-700 text-right">{{ $horario->dia }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-semibold text-gray-500">Hora</span>
                        <span class="text-sm text-gray-700 text-right">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center gap-2 border-t pt-3">
                         <a href="{{ route('grupos.show', $horario->id_grupo) }}" 
                            class="w-full text-center bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                             Ver Grupo
                         </a>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- FIN CORRECCIÓN: 2. VISTA DE TARJETAS --}}

        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">Esta aula no tiene horarios asignados actualmente.</p>
            </div>
        @endif
    </div>

    {{-- Zona de peligro --}}
    <div class="bg-white sm:rounded-lg shadow-xl border-l-4 border-red-500 p-6">
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