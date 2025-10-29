@extends('layouts.app')
@section('title', 'Bitácora')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Registros de bitácora</h2>
            <div class="text-sm text-gray-500">
                Página {{ $bitacoras->currentPage() }} de {{ $bitacoras->lastPage() }} — {{ $bitacoras->total() }} registros
            </div>
        </div>

        <div class="p-5 overflow-x-auto">
            <table class="w-full min-w-[780px] border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-left text-sm text-gray-600">
                        <th class="px-3 py-2 border-b">Fecha/Hora</th>
                        <th class="px-3 py-2 border-b">Usuario</th>
                        <th class="px-3 py-2 border-b">Descripción</th>
                        <th class="px-3 py-2 border-b">IP Origen</th>
                        <th class="px-3 py-2 border-b text-center w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($bitacoras as $b)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border-b whitespace-nowrap">
                                {{ optional($b->fecha_hora)->format('d/m/Y H:i:s') ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border-b">
                                {{ optional($b->usuario)->nombre ?? optional($b->usuario)->email ?? 'Sistema' }}
                            </td>
                            <td class="px-3 py-2 border-b">
                                <div class="font-medium text-gray-800">
                                    {{ $b->descripcion ?? '-' }}
                                </div>
                            </td>
                            <td class="px-3 py-2 border-b">
                                {{ $b->ip_origen ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border-b">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Pasar la instancia activa el route-model binding con tu PK id_bitacora --}}
                                    <a href="{{ route('bitacoras.show', $b) }}"
                                       class="px-3 py-1 text-xs rounded bg-blue-600 text-white hover:bg-blue-700">
                                        Ver
                                    </a>
                                    <form action="{{ route('bitacoras.destroy', $b) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este registro de bitácora?');">
                                        @csrf
                                       
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-10 text-center text-gray-500">
                                No hay registros en la bitácora.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t">
            {{ $bitacoras->links() }}
        </div>
    </div>
</div>
@endsection
