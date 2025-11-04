@extends('layouts.app')
@section('title', 'Gestiones Académicas')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- MENSAJES FLASH MEJORADOS --}}
    @if(session('success'))
        <div class="mb-4 p-4 flex items-center bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md" 
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <i class="fas fa-check-circle text-green-600 mr-3 text-lg"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 flex items-center bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md">
            <i class="fas fa-exclamation-circle text-red-600 mr-3 text-lg"></i>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white sm:rounded-lg shadow-xl">
        {{-- CABECERA RESPONSIVA --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Listado de Gestiones Académicas</h2>
            <a href="{{ route('gestiones.create') }}"
               class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nueva Gestión
            </a>
        </div>

        <div>
            
            {{-- 1. VISTA DE TABLA (Oculta en móvil) --}}
            <table class="w-full border-collapse hidden sm:table">
                <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 border-b font-semibold">Gestión (Nombre)</th>
                        <th class="px-4 py-3 border-b font-semibold">Fecha Inicio</th>
                        <th class="px-4 py-3 border-b font-semibold">Fecha Fin</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($gestiones as $gestion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-medium text-gray-800">{{ $gestion->nombre }}</td>
                            
                            {{-- ¡CAMBIO AQUÍ! Se aplica el formato 'Y-m-d' --}}
                            <td class="px-4 py-3 border-b">{{ $gestion->fecha_inicio?->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 border-b">{{ $gestion->fecha_fin?->format('Y-m-d') }}</td>
                            
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route('gestiones.show', $gestion) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto" title="Ver detalles">
                                        <i class="fas fa-eye text-white/80"></i> Ver
                                    </a>
                                    <a href="{{ route('gestiones.edit', $gestion) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="{{ route('gestiones.destroy', $gestion) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('¿Estás seguro de eliminar la gestión {{ $gestion->nombre }}?');">
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
                            <td colspan="4" class="px-3 py-10 text-center text-gray-500">
                                No hay gestiones registradas. 
                                <a href="{{ route('gestiones.create') }}" class="text-blue-600 underline">Crear una</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="sm:hidden px-4 py-4 space-y-4">
                @forelse ($gestiones as $gestion)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        
                        <div class="flex justify-between items-center mb-2 pb-2 border-b">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Gestión</span>
                            <span class="font-medium text-gray-800 text-right">{{ $gestion->nombre }}</span>
                        </div>
                        
                        {{-- ¡CAMBIO AQUÍ! Se aplica el formato 'Y-m-d' --}}
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Inicio</span>
                            <span class="text-sm text-gray-700">{{ $gestion->fecha_inicio?->format('Y-m-d') }}</span>
                        </div>
                        
                        {{-- ¡CAMBIO AQUÍ! Se aplica el formato 'Y-m-d' --}}
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Fin</span>
                            <span class="text-sm text-gray-700">{{ $gestion->fecha_fin?->format('Y-m-d') }}</span>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-2 border-t pt-4">
                            <a href="{{ route('gestiones.show', $gestion) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full" title="Ver detalles">
                                <i class="fas fa-eye text-white/80"></i> Ver
                            </a>
                            <a href="{{ route('gestiones.edit', $gestion) }}" class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" title="Editar">
                                <i class="fas fa-pen text-white/80"></i> Editar
                            </a>
                            <form action="{{ route('gestiones.destroy', $gestion) }}" method="POST" class="w-full" onsubmit="return confirm('¿Estás seguro de eliminar la gestión {{ $gestion->nombre }}?');">
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
                        No hay gestiones registradas. 
                        <a href="{{ route('gestiones.create') }}" class="text-blue-600 underline">Crear una</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection