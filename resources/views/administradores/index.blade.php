@extends('layouts.app')
@section('title', 'Administradores')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    <div class="bg-white sm:rounded-lg shadow-xl">
        {{-- CABECERA RESPONSIVA --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Administradores del Sistema</h2>
                <p class="mt-1 text-sm text-gray-600">Gestiona los administradores del sistema académico</p>
            </div>
            <a href="{{ route('administradores.create') }}"
               class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nuevo Administrador
            </a>
        </div>

        <div>
            
            {{-- 1. VISTA DE TABLA (Oculta en móvil, visible en 'sm' y más) --}}
            <table class="w-full border-collapse hidden sm:table">
                <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 border-b font-semibold">Nombre</th>
                        <th class="px-4 py-3 border-b font-semibold">Email</th>
                        <th class="px-4 py-3 border-b font-semibold">Teléfono</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($administradores as $administrador)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b">{{ $administrador->usuario->nombre ?? 'USUARIO NO ENCONTRADO' }}</td>
                            <td class="px-4 py-3 border-b">{{ $administrador->usuario->email ?? 'EMAIL NO ENCONTRADO' }}</td>
                            <td class="px-4 py-3 border-b">{{ $administrador->usuario->telefono ?? 'N/A' }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route('administradores.show', $administrador->id_administrador) }}" 
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye text-white/80"></i> Ver
                                    </a>
                                    <a href="{{ route('administradores.edit', $administrador->id_administrador) }}" 
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto" 
                                       title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="{{ route('administradores.destroy', $administrador->id_administrador) }}" 
                                          method="POST" 
                                          class="w-full sm:w-auto" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar este administrador?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" 
                                                title="Eliminar">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-10 text-center text-gray-500">
                                No hay administradores registrados. 
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- 2. VISTA DE TARJETAS (Visible SÓLO en móvil) --}}
            <div class="sm:hidden px-4 py-4 space-y-4">
                @forelse ($administradores as $administrador)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        
                        <div class="flex justify-between items-center mb-2 pb-2 border-b">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Nombre</span>
                            <span class="font-medium text-gray-800 text-right">{{ $administrador->usuario->nombre ?? 'USUARIO NO ENCONTRADO' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Email</span>
                            <span class="text-sm text-gray-700 truncate">{{ $administrador->usuario->email ?? 'EMAIL NO ENCONTRADO' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Teléfono</span>
                            <span class="text-sm text-gray-700">{{ $administrador->usuario->telefono ?? 'N/A' }}</span>
                        </div>

                        <div class="flex flex-col items-center justify-center gap-2 border-t pt-4">
                            <a href="{{ route('administradores.show', $administrador->id_administrador) }}" 
                               class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full" 
                               title="Ver detalles">
                                <i class="fas fa-eye text-white/80"></i> Ver
                            </a>
                            <a href="{{ route('administradores.edit', $administrador->id_administrador) }}" 
                               class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full" 
                               title="Editar">
                                <i class="fas fa-pen text-white/80"></i> Editar
                            </a>
                            <form action="{{ route('administradores.destroy', $administrador->id_administrador) }}" 
                                  method="POST" 
                                  class="w-full" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este administrador?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full" 
                                        title="Eliminar">
                                    <i class="fas fa-trash text-white/80"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-3 py-10 text-center text-gray-500">
                        No hay administradores registrados. 
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

</div>
@endsection