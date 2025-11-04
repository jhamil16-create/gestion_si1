@extends('layouts.app')
@section('title', 'Grupos')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- 
      EL BLOQUE DE MENSAJES FLASH SE OMITE AQUÍ.
      Se maneja centralmente en 'app.blade.php'.
    --}}

    <div class="bg-white sm:rounded-lg shadow-xl">
        {{-- CABECERA RESPONSIVA --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Listado de Grupos</h2>
            <a href="{{ route('grupos.create') }}"
               class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nuevo Grupo
            </a>
        </div>

        <div>
            
            {{-- 1. VISTA DE TABLA (Oculta en móvil, visible en 'sm' y más) --}}
            <table class="w-full border-collapse hidden sm:table">
                <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 border-b font-semibold">Nombre</th>
                        <th class="px-4 py-3 border-b font-semibold">Capacidad</th>
                        <th class="px-4 py-3 border-b font-semibold">Materia</th>
                        <th class="px-4 py-3 border-b font-semibold">Docente</th>
                        <th class="px-4 py-3 border-b font-semibold">Gestión</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($grupos as $grupo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-medium text-gray-800">{{ $grupo->nombre }}</td>
                            <td class="px-4 py-3 border-b">{{ $grupo->capacidad }}</td>
                            <td class="px-4 py-3 border-b">{{ $grupo->materia->nombre ?? $grupo->sigla }}</td>
                            <td class="px-4 py-3 border-b">{{ $grupo->docente->usuario->nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-3 border-b">{{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route('grupos.show', $grupo) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto" title="Ver detalles">
                                        <i class="fas fa-eye text-white/80"></i> Ver
                                    </a>
                                    <a href="{{ route('grupos.edit', $grupo) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('¿Estás seguro de eliminar este grupo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" title="Eliminar">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-10 text-center text-gray-500">
                                No hay grupos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="sm:hidden px-4 py-4 space-y-4">
                @forelse ($grupos as $grupo)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        
                        <div class="flex justify-between items-center mb-2 pb-2 border-b">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Grupo</span>
                            <span class="font-medium text-gray-800 text-right">{{ $grupo->nombre }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Materia</span>
                            <span class="text-sm text-gray-700 text-right">{{ $grupo->materia->nombre ?? $grupo->sigla }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Docente</span>
                            <span class="text-sm text-gray-700 text-right">{{ $grupo->docente->usuario->nombre ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Gestión</span>
                            <span class="text-sm text-gray-700 text-right">{{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Capacidad</span>
                            <span class="text-sm text-gray-700 text-right">{{ $grupo->capacidad }}</span>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex flex-col items-center justify-center gap-2 border-t pt-4">
                            <a href="{{ route('grupos.show', $grupo) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full" title="Ver detalles">
                                <i class="fas fa-eye text-white/80"></i> Ver
                            </a>
                            <a href="{{ route('grupos.edit', $grupo) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full" title="Editar">
                                <i class="fas fa-pen text-white/80"></i> Editar
                            </a>
                            <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="w-full" onsubmit="return confirm('¿Estás seguro de eliminar este grupo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" title="Eliminar">
                                    <i class="fas fa-trash text-white/80"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-3 py-10 text-center text-gray-500">
                        No hay grupos registrados.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection