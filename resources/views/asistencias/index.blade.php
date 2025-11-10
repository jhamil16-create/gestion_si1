@extends('layouts.app')

@section('title', 'Registro de Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Registro de Asistencia
        </h1>

        @if(Auth::user()->isAdmin())
            <a href="{{ route('asistencias.create') }}" 
               class="mt-4 sm:mt-0 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Registrar Nueva Asistencia
            </a>
        @endif
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('asistencias.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" 
                       name="fecha" 
                       id="fecha" 
                       value="{{ request('fecha') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="flex-1 min-w-[200px]">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" 
                        id="estado"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Todos</option>
                    <option value="presente" {{ request('estado') === 'presente' ? 'selected' : '' }}>Presente</option>
                    <option value="ausente" {{ request('estado') === 'ausente' ? 'selected' : '' }}>Ausente</option>
                    <option value="tardanza" {{ request('estado') === 'tardanza' ? 'selected' : '' }}>Tardanza</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla de Asistencias --}}
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Docente
                        </th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hora Entrada
                        </th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hora Salida
                        </th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        @if(Auth::user()->isAdmin())
                            <th class="px-6 py-3 border-b text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($asistencias as $asistencia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asistencia->fecha->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asistencia->docente->usuario->nombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asistencia->hora_entrada }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asistencia->hora_salida }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $asistencia->estado === 'presente' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $asistencia->estado === 'ausente' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $asistencia->estado === 'tardanza' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($asistencia->estado) }}
                                </span>
                            </td>
                            @if(Auth::user()->isAdmin())
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('asistencias.edit', $asistencia) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Editar
                                    </a>
                                    <form action="{{ route('asistencias.destroy', $asistencia) }}" 
                                          method="POST" 
                                          class="inline ml-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('¿Estás seguro de eliminar esta asistencia?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isAdmin() ? '6' : '5' }}" class="px-6 py-4 text-center text-gray-500">
                                No hay registros de asistencia que mostrar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $asistencias->links() }}
        </div>
    </div>
</div>
@endsection