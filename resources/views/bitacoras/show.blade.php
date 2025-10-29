@extends('layouts.app')
@section('title', 'Detalle de bitácora')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-4">
        <a href="{{ route('bitacoras.index') }}"
           class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
            <i class="fa-solid fa-arrow-left"></i>
            Volver a la bitácora
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-5 py-4 border-b">
            <h2 class="text-lg font-semibold">Registro de bitácora</h2>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500">Fecha/Hora</p>
                <p class="font-medium">
                    {{ optional($bitacora->fecha_hora)->format('d/m/Y H:i:s') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Usuario</p>
                <p class="font-medium">
                    {{ optional($bitacora->usuario)->nombre ?? optional($bitacora->usuario)->email ?? 'Sistema' }}
                </p>
            </div>

            <div class="md:col-span-2">
                <p class="text-xs text-gray-500">Descripción</p>
                <div class="mt-1 p-3 bg-gray-50 rounded min-h-[56px]">
                    <pre class="whitespace-pre-wrap text-sm text-gray-800">{{ $bitacora->descripcion ?? '-' }}</pre>
                </div>
            </div>

            <div>
                <p class="text-xs text-gray-500">IP Origen</p>
                <p class="font-medium">{{ $bitacora->ip_origen ?? '-' }}</p>
            </div>
        </div>

        <div class="px-5 py-4 border-t flex items-center justify-end gap-3">
            <form action="{{ route('bitacoras.destroy', $bitacora) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este registro de bitácora?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                    Eliminar
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
