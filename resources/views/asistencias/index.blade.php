@extends('layouts.app')

@section('title', 'Lista de Asistencias')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- Información del usuario (solo docentes) --}}
    @if(!Auth::user()->isAdmin())
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-user-circle text-blue-500 mr-3 text-xl"></i>
                <div>
                    <p class="text-blue-800 font-medium text-sm">Docente: {{ Auth::user()->nombre }}</p>
                    <p class="text-blue-600 text-xs">Solo puedes ver tus propias asistencias</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Filtros (solo para administradores) --}}
    @if(Auth::user()->isAdmin() && isset($docentes) && $docentes->count() > 0)
        <div class="bg-white sm:rounded-lg shadow-xl">
            <div class="px-5 py-4 border-b">
                <h2 class="text-lg font-bold text-gray-700">Filtros de Búsqueda</h2>
            </div>
            <div class="px-5 py-6">
                <form action="{{ route('asistencias.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Filtro por Docente --}}
                        <div>
                            <label for="id_docente" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[var(--blue-primary)] mr-2"></i>Docente
                            </label>
                            <select name="id_docente" 
                                    id="id_docente"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-[var(--blue-primary)] focus:border-transparent transition-colors text-sm">
                                <option value="">Todos los docentes</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id_docente }}" 
                                            {{ request('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                                        {{ $docente->usuario->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filtro por Fecha Inicio --}}
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-[var(--blue-primary)] mr-2"></i>Fecha Inicio
                            </label>
                            <input type="date" 
                                   name="fecha_inicio" 
                                   id="fecha_inicio"
                                   value="{{ request('fecha_inicio') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-[var(--blue-primary)] focus:border-transparent transition-colors text-sm">
                        </div>

                        {{-- Filtro por Fecha Fin --}}
                        <div>
                            <label for="fecha_fin" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-[var(--blue-primary)] mr-2"></i>Fecha Fin
                            </label>
                            <input type="date" 
                                   name="fecha_fin" 
                                   id="fecha_fin"
                                   value="{{ request('fecha_fin') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-[var(--blue-primary)] focus:border-transparent transition-colors text-sm">
                        </div>
                    </div>

                    {{-- Botones de Filtro --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t">
                        <a href="{{ route('asistencias.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm font-medium w-full sm:w-auto">
                            <i class="fas fa-times"></i>
                            Limpiar Filtros
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-[var(--blue-primary)] text-white rounded-md hover:bg-[var(--blue-hover)] transition-colors text-sm font-medium w-full sm:w-auto">
                            <i class="fas fa-filter"></i>
                            Aplicar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Lista de Asistencias --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        {{-- CABECERA RESPONSIVA --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">
                    @if(Auth::user()->isAdmin())
                        Listado de Asistencias
                    @else
                        Mis Asistencias
                    @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $asistencias->total() }} registros encontrados</p>
            </div>
            
            @if(Auth::user()->isAdmin())
                <a href="{{ route('asistencias.create') }}" 
                   class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                    <i class="fas fa-plus mr-1"></i>
                    Nueva Asistencia
                </a>
            @else
                <a href="{{ route('asistencias.create') }}" 
                   class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                    <i class="fas fa-plus mr-1"></i>
                    Registrar Asistencia
                </a>
            @endif
        </div>

        <div>
            @if($asistencias->count() > 0)
                
                {{-- 1. VISTA DE TABLA (Oculta en móvil, visible en 'sm' y más) --}}
                <table class="w-full border-collapse hidden sm:table">
                    <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <tr>
                            @if(Auth::user()->isAdmin())
                                <th class="px-4 py-3 border-b font-semibold">Docente</th>
                            @endif
                            <th class="px-4 py-3 border-b font-semibold">Grupo/Materia</th>
                            <th class="px-4 py-3 border-b font-semibold">Fecha</th>
                            <th class="px-4 py-3 border-b font-semibold">Estado</th>
                            <th class="px-4 py-3 border-b font-semibold">Observaciones</th>
                            @if(Auth::user()->isAdmin())
                                <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($asistencias as $asistencia)
                            <tr class="hover:bg-gray-50">
                                @if(Auth::user()->isAdmin())
                                    <td class="px-4 py-3 border-b">
                                        <div class="font-medium text-gray-800">
                                            {{ $asistencia->asignacionHorario->grupo->docentes->first()->usuario->nombre ?? 'N/A' }}
                                        </div>
                                    </td>
                                @endif
                                <td class="px-4 py-3 border-b">
                                    <div class="font-medium text-gray-800">
                                        {{ $asistencia->asignacionHorario->grupo->materia->nombre ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Grupo {{ $asistencia->asignacionHorario->grupo->nombre ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <div class="text-gray-700">
                                        {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-b">
                                    @php
                                        $estadoConfig = [
                                            'P' => ['color' => 'green', 'text' => 'Presente', 'icon' => 'check-circle'],
                                            'A' => ['color' => 'red', 'text' => 'Ausente', 'icon' => 'times-circle'],
                                            'T' => ['color' => 'yellow', 'text' => 'Tardanza', 'icon' => 'clock'],
                                            'L' => ['color' => 'blue', 'text' => 'Licencia', 'icon' => 'file-alt']
                                        ];
                                        $config = $estadoConfig[$asistencia->estado] ?? $estadoConfig['A'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                                        <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                        {{ $config['text'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border-b text-gray-600">
                                    {{ $asistencia->observaciones ? \Str::limit($asistencia->observaciones, 50) : '---' }}
                                </td>
                                @if(Auth::user()->isAdmin())
                                    <td class="px-4 py-3 border-b">
                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                            <a href="{{ route('asistencias.edit', $asistencia->id_asistencia) }}" 
                                               class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" 
                                               title="Editar">
                                                <i class="fas fa-pen text-white/80"></i> Editar
                                            </a>
                                            
                                            <button type="button" 
                                                    class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full sm:w-auto" 
                                                    title="Eliminar"
                                                    data-action="{{ route('asistencias.destroy', $asistencia->id_asistencia) }}"
                                                    data-name="{{ $asistencia->asignacionHorario->grupo->materia->nombre ?? 'N/A' }} - Grupo {{ $asistencia->asignacionHorario->grupo->nombre ?? 'N/A' }} ({{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }})">
                                                <i class="fas fa-trash text-white/80"></i> Eliminar
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
                <div class="sm:hidden px-4 py-4 space-y-4">
                    @foreach ($asistencias as $asistencia)
                        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                            
                            @if(Auth::user()->isAdmin())
                                <div class="flex justify-between items-center mb-2 pb-2 border-b">
                                    <span class="text-sm font-semibold text-gray-500 uppercase">Docente</span>
                                    <span class="font-medium text-gray-800 text-right text-sm">
                                        {{ $asistencia->asignacionHorario->grupo->docentes->first()->usuario->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center mb-2 {{ Auth::user()->isAdmin() ? '' : 'pb-2 border-b' }}">
                                <span class="text-sm font-semibold text-gray-500 uppercase">Materia</span>
                                <span class="text-sm text-gray-700 text-right">
                                    {{ $asistencia->asignacionHorario->grupo->materia->nombre ?? 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-500 uppercase">Grupo</span>
                                <span class="text-sm text-gray-700 text-right">
                                    {{ $asistencia->asignacionHorario->grupo->nombre ?? 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-500 uppercase">Fecha</span>
                                <span class="text-sm text-gray-700 text-right">
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-500 uppercase">Estado</span>
                                <span class="text-right">
                                    @php
                                        $estadoConfig = [
                                            'P' => ['color' => 'green', 'text' => 'Presente', 'icon' => 'check-circle'],
                                            'A' => ['color' => 'red', 'text' => 'Ausente', 'icon' => 'times-circle'],
                                            'T' => ['color' => 'yellow', 'text' => 'Tardanza', 'icon' => 'clock'],
                                            'L' => ['color' => 'blue', 'text' => 'Licencia', 'icon' => 'file-alt']
                                        ];
                                        $config = $estadoConfig[$asistencia->estado] ?? $estadoConfig['A'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                                        <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                        {{ $config['text'] }}
                                    </span>
                                </span>
                            </div>
                            
                            @if($asistencia->observaciones)
                                <div class="flex justify-between items-start mb-4 pt-2 border-t">
                                    <span class="text-sm font-semibold text-gray-500 uppercase">Observaciones</span>
                                    <span class="text-sm text-gray-700 text-right ml-2">
                                        {{ \Str::limit($asistencia->observaciones, 50) }}
                                    </span>
                                </div>
                            @endif
                            
                            @if(Auth::user()->isAdmin())
                                {{-- Acciones --}}
                                <div class="flex flex-col items-center justify-center gap-2 border-t pt-4">
                                    <a href="{{ route('asistencias.edit', $asistencia->id_asistencia) }}" 
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full" 
                                       title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    
                                    <button type="button" 
                                            class="open-delete-modal inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" 
                                            title="Eliminar"
                                            data-action="{{ route('asistencias.destroy', $asistencia->id_asistencia) }}"
                                            data-name="{{ $asistencia->asignacionHorario->grupo->materia->nombre ?? 'N/A' }} - Grupo {{ $asistencia->asignacionHorario->grupo->nombre ?? 'N/A' }} ({{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }})">
                                        <i class="fas fa-trash text-white/80"></i> Eliminar
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="px-5 py-4 border-t">
                    {{ $asistencias->links() }}
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="px-3 py-10 text-center text-gray-500">
                    <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay asistencias registradas</h3>
                    <p class="text-gray-500 mb-4 text-sm">
                        @if(Auth::user()->isAdmin())
                            No se encontraron registros de asistencia con los filtros aplicados.
                        @else
                            Aún no has registrado ninguna asistencia.
                        @endif
                    </p>
                    <a href="{{ route('asistencias.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-[var(--blue-primary)] text-white rounded-md hover:bg-[var(--blue-hover)] transition-colors text-sm font-medium">
                        <i class="fas fa-plus"></i>
                        Registrar Primera Asistencia
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de Confirmación Único y Dinámico --}}
@if(Auth::user()->isAdmin())
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
                ¿Realmente deseas eliminar la asistencia de "<span id="modal-item-name" class="font-bold"></span>"?
                <br>Esta acción no se puede deshacer.
            </p>
        </div>

        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            
            <!-- Botones del Modal -->
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
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(Auth::user()->isAdmin())
        // Elementos del Modal
        const modal = document.getElementById('delete-modal');
        const cancelButton = document.getElementById('cancel-delete');
        const deleteForm = document.getElementById('delete-form');
        const modalItemName = document.getElementById('modal-item-name');
        
        // Todos los botones que abren el modal
        const openButtons = document.querySelectorAll('.open-delete-modal');

        // Asignar evento a cada botón de "Eliminar"
        openButtons.forEach(button => {
            button.addEventListener('click', function () {
                const actionUrl = this.getAttribute('data-action');
                const itemName = this.getAttribute('data-name');
                
                deleteForm.setAttribute('action', actionUrl);
                modalItemName.textContent = itemName;
                
                modal.classList.remove('hidden');
            });
        });

        // Evento para el botón "Cancelar"
        cancelButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
        @endif
    });
</script>
@endpush

<style>
    .bg-green-100 { background-color: #dcfce7; }
    .text-green-800 { color: #166534; }
    .bg-red-100 { background-color: #fee2e2; }
    .text-red-800 { color: #991b1b; }
    .bg-yellow-100 { background-color: #fef3c7; }   
    .text-yellow-800 { color: #92400e; }
    .bg-blue-100 { background-color: #dbeafe; }
    .text-blue-800 { color: #1e40af; }
</style>

@endsection