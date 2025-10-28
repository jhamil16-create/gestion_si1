@extends('layouts.app')
@section('title', 'Detalle de Administrador')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Administrador: {{ $administrador->usuario->nombre }}</h2>
        <div class="space-x-2">
            <a href="{{ route('administradores.edit', $administrador->id_administrador) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('administradores.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>

    <!-- Información del Administrador -->
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Personal</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Administrador</p>
                <p class="font-semibold">{{ $administrador->id_administrador }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">ID Usuario</p>
                <p class="font-semibold">{{ $administrador->usuario->id_usuario }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre Completo</p>
                <p class="font-semibold">{{ $administrador->usuario->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold">{{ $administrador->usuario->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Teléfono</p>
                <p class="font-semibold">{{ $administrador->usuario->telefono ?? 'No registrado' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Fecha de Registro</p>
                <p class="font-semibold">{{ $administrador->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Actividades recientes (Bitácora) -->
    @if($administrador->usuario->bitacoras && $administrador->usuario->bitacoras->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Actividad Reciente (Últimos 10 registros)</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Fecha</th>
                            <th class="border px-4 py-2 text-left">IP</th>
                            <th class="border px-4 py-2 text-left">Acción</th>
                            <th class="border px-4 py-2 text-left">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($administrador->usuario->bitacoras->take(10) as $bitacora)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">
                                    {{ $bitacora->fecha_hora->format('d/m/Y H:i') }}
                                </td>
                                <td class="border px-4 py-2">{{ $bitacora->ip }}</td>
                                <td class="border px-4 py-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                        {{ $bitacora->accion }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 text-sm text-gray-600">
                                    {{ $bitacora->observaciones ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">No hay registros de actividad para este administrador.</p>
        </div>
    @endif

    <!-- Botón de Eliminar -->
    <div class="mt-6 pt-6 border-t">
        <form action="{{ route('administradores.destroy', $administrador->id_administrador) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar este administrador? Esta acción eliminará también su usuario asociado.');">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Administrador
            </button>
        </form>
    </div>
</div>
@endsection