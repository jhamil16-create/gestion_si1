@extends('layouts.app')
@section('title', 'Gestiones Académicas')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Flashes --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Gestiones Académicas</h2>
            <a href="{{ route('gestiones.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               Nueva Gestión
            </a>
        </div>

        <div class="p-5 overflow-x-auto">
            <table class="w-full min-w-[720px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-left text-sm text-gray-600">
                        <th class="px-3 py-2 border-b">ID</th>
                        <th class="px-3 py-2 border-b">Nombre</th>
                        <th class="px-3 py-2 border-b">Fecha Inicio</th>
                        <th class="px-3 py-2 border-b">Fecha Fin</th>
                        <th class="px-3 py-2 border-b text-center w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($gestiones as $g)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border-b">{{ $g->id_gestion }}</td>
                            <td class="px-3 py-2 border-b font-medium text-gray-800">{{ $g->nombre }}</td>
                            <td class="px-3 py-2 border-b">
                                {{ optional($g->fecha_inicio)->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-3 py-2 border-b">
                                {{ optional($g->fecha_fin)->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-3 py-2 border-b">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('gestiones.edit', $g) }}"
                                       class="px-3 py-1 text-xs rounded bg-yellow-500 text-white hover:bg-yellow-600">
                                       Editar
                                    </a>
                                    <form action="{{ route('gestiones.destroy', $g) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta gestión?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded bg-red-600 text-white hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-10 text-center text-gray-500">
                                No hay gestiones registradas. 
                                <a href="{{ route('gestiones.create') }}" class="text-blue-600 underline">Crear una</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
