@extends('layouts.app')
@section('title', 'Detalles del Grupo')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    
    {{-- 1. CABECERA (Estilo Docente) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">
            Grupo: {{ $grupo->nombre }}
        </h2>
        {{-- Botones de acción --}}
        <div class="flex-shrink-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('grupos.edit', $grupo) }}" 
               class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm font-medium">
               <i class="fas fa-pen mr-1"></i> Editar Grupo
            </a>
            <a href="{{ route('grupos.index') }}" 
               class="w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm font-medium">
               &larr; Volver
            </a>
        </div>
    </div>

    {{-- 2. INFORMACIÓN PRINCIPAL (Estilo Docente) --}}
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Principal</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Grupo</p>
                <p class="font-semibold font-mono">{{ $grupo->id_grupo }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre del Grupo</p>
                <p class="font-semibold">{{ $grupo->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Materia</p>
                <p class="font-semibold">{{ $grupo->materia->nombre ?? $grupo->sigla }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Gestión Académica</p>
                <p class="font-semibold">{{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- 3. HORARIOS ASIGNADOS (Estilo Docente: Tabla/Tarjetas) --}}
    <div class="mt-6">
        
        {{-- Cabecera con botón de agregar --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h3 class="text-lg font-semibold">Horarios Asignados</h3>
            <a href="{{ route('asignaciones.create', $grupo) }}"
                class="bg-[var(--blue-primary)] text-white px-3 py-1.5 rounded-md hover:bg-[var(--blue-hover)] text-xs font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Agregar Horario
            </a>
        </div>

        @if ($grupo->asignacionesHorario->count())
            {{-- 3.1. VISTA DE TABLA (Oculta en móvil) --}}
            <div class="overflow-x-auto hidden sm:block">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th class="border px-4 py-2 font-semibold">Día</th>
                            <th class="border px-4 py-2 font-semibold">Horario</th>
                            <th class="border px-4 py-2 font-semibold">Aula</th>
                            <th class="border px-4 py-2 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($grupo->asignacionesHorario as $horario)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 font-medium text-gray-800">{{ $horario->dia }}</td>
                                <td class="border px-4 py-2">{{ $horario->hora_inicio }} – {{ $horario->hora_fin }}</td>
                                <td class="border px-4 py-2">
                                    {{ $horario->aula->id_aula ?? 'N/A' }} ({{ $horario->aula->tipo ?? 'N/A' }})
                                </td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('asignaciones.edit', $horario) }}"
                                            class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors"
                                            title="Editar">
                                            <i class="fas fa-pen text-white/80"></i> Editar
                                        </a>
                                        
                                        <button type="button"
                                            class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors"
                                            title="Eliminar"
                                            data-action="{{ route('asignaciones.destroy', $horario) }}"
                                            data-name="el horario ({{ $horario->dia }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }})">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 3.2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="space-y-4 sm:hidden">
                @foreach ($grupo->asignacionesHorario as $horario)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    
                    <div class="flex justify-between items-center mb-2 pb-2 border-b">
                        <span class="text-sm font-semibold text-gray-500 uppercase">Día</span>
                        <span class="font-medium text-gray-800 text-right">{{ $horario->dia }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Horario</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ $horario->hora_inicio }} – {{ $horario->hora_fin }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-semibold text-gray-500">Aula</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ $horario->aula->id_aula ?? 'N/A' }} ({{ $horario->aula->tipo ?? 'N/A' }})
                        </span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center gap-2 border-t pt-3">
                        <a href="{{ route('asignaciones.edit', $horario) }}" class="w-full text-center inline-flex items-center justify-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                            <i class="fas fa-pen text-white/80"></i> Editar
                        </a>
                        <button type="button"
                            class="open-delete-modal w-full text-center inline-flex items-center justify-center gap-1 bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700"
                            data-action="{{ route('asignaciones.destroy', $horario) }}"
                            data-name="el horario ({{ $horario->dia }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }})">
                            <i class="fas fa-trash text-white/80"></i> Eliminar
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

        @else
            {{-- Estado vacío (Estilo Docente) --}}
            <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
                <p class="text-blue-700">Este grupo no tiene horarios asignados actualmente.</p>
            </div>
        @endif
    </div>
</div>


{{-- INICIO: Modal de Confirmación Único y Dinámico --}}
{{-- (Este código se queda igual, ya está perfecto) --}}
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
{{-- (Este código se queda igual, ya está perfecto) --}}
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
@endpush@extends('layouts.app')
@section('title', 'Detalles del Grupo')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    
    {{-- 1. CABECERA (Estilo Docente) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">
            Grupo: {{ $grupo->nombre }}
        </h2>
        {{-- Botones de acción --}}
        <div class="flex-shrink-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <a href="{{ route('grupos.edit', $grupo) }}" 
               class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm font-medium">
               <i class="fas fa-pen mr-1"></i> Editar Grupo
            </a>
            <a href="{{ route('grupos.index') }}" 
               class="w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm font-medium">
               &larr; Volver
            </a>
        </div>
    </div>

    {{-- 2. INFORMACIÓN PRINCIPAL (Estilo Docente) --}}
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Principal</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Grupo</p>
                <p class="font-semibold font-mono">{{ $grupo->id_grupo }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre del Grupo</p>
                <p class="font-semibold">{{ $grupo->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Materia</p>
                <p class="font-semibold">{{ $grupo->materia->nombre ?? $grupo->sigla }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Gestión Académica</p>
                <p class="font-semibold">{{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- 3. HORARIOS ASIGNADOS (Estilo Docente: Tabla/Tarjetas) --}}
    <div class="mt-6">
        
        {{-- Cabecera con botón de agregar --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h3 class="text-lg font-semibold">Horarios Asignados</h3>
            <a href="{{ route('asignaciones.create', $grupo) }}"
                class="bg-[var(--blue-primary)] text-white px-3 py-1.5 rounded-md hover:bg-[var(--blue-hover)] text-xs font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Agregar Horario
            </a>
        </div>

        @if ($grupo->asignacionesHorario->count())
            {{-- 3.1. VISTA DE TABLA (Oculta en móvil) --}}
            <div class="overflow-x-auto hidden sm:block">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th class="border px-4 py-2 font-semibold">Día</th>
                            <th class="border px-4 py-2 font-semibold">Horario</th>
                            <th class="border px-4 py-2 font-semibold">Aula</th>
                            <th class="border px-4 py-2 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($grupo->asignacionesHorario as $horario)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 font-medium text-gray-800">{{ $horario->dia }}</td>
                                <td class="border px-4 py-2">{{ $horario->hora_inicio }} – {{ $horario->hora_fin }}</td>
                                
                                {{-- INICIO CORRECCIÓN --}}
                                <td class="border px-4 py-2">
                                    {{ $horario->aula->id_aula ?? 'N/A' }} {{ $horario->aula->tipo ?? '' }}
                                </td>
                                {{-- FIN CORRECCIÓN --}}
                                
                                <td class="border px-4 py-2">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('asignaciones.edit', $horario) }}"
                                            class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors"
                                            title="Editar">
                                            <i class="fas fa-pen text-white/80"></i> Editar
                                        </a>
                                        
                                        <button type="button"
                                            class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors"
                                            title="Eliminar"
                                            data-action="{{ route('asignaciones.destroy', $horario) }}"
                                            data-name="el horario ({{ $horario->dia }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }})">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 3.2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="space-y-4 sm:hidden">
                @foreach ($grupo->asignacionesHorario as $horario)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    
                    <div class="flex justify-between items-center mb-2 pb-2 border-b">
                        <span class="text-sm font-semibold text-gray-500 uppercase">Día</span>
                        <span class="font-medium text-gray-800 text-right">{{ $horario->dia }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Horario</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ $horario->hora_inicio }} – {{ $horario->hora_fin }}
                        </span>
                    </div>

                    {{-- INICIO CORRECCIÓN --}}
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-semibold text-gray-500">Aula</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ $horario->aula->id_aula ?? 'N/A' }} {{ $horario->aula->tipo ?? '' }}
                        </span>
                    </div>
                    {{-- FIN CORRECCIÓN --}}
                    
                    <div class="flex flex-col items-center justify-center gap-2 border-t pt-3">
                        <a href="{{ route('asignaciones.edit', $horario) }}" class="w-full text-center inline-flex items-center justify-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                            <i class="fas fa-pen text-white/80"></i> Editar
                        </a>
                        <button type="button"
                            class="open-delete-modal w-full text-center inline-flex items-center justify-center gap-1 bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700"
                            data-action="{{ route('asignaciones.destroy', $horario) }}"
                            data-name="el horario ({{ $horario->dia }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }})">
                            <i class="fas fa-trash text-white/80"></i> Eliminar
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

        @else
            {{-- Estado vacío (Estilo Docente) --}}
            <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
                <p class="text-blue-700">Este grupo no tiene horarios asignados actualmente.</p>
            </div>
        @endif
    </div>
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