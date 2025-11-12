@extends('layouts.app')
@section('title', 'Notificaciones')

@section('content')
<div class="max-w-6xl mx-auto space-y-5">

    {{-- CABECERA --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Centro de Notificaciones</h2>
                <p class="text-sm text-gray-600 mt-1">{{ count($notifications) }} notificaciones registradas</p>
            </div>

            {{-- Botón Crear Notificación (solo admin) --}}
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('notificaciones.create') }}" 
                       class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                        <i class="fas fa-plus mr-1"></i> Nueva Notificación
                    </a>
                @endif
            @endauth
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="px-5 py-6 bg-gray-50">

            @if(count($notifications) > 0)
                {{-- GRID DE TARJETAS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($notifications as $notification)
                        <div class="bg-white rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-all p-5">
                            {{-- Encabezado --}}
                            <div class="flex items-start gap-3 mb-3">
                                <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-base font-semibold text-gray-800 leading-tight">
                                        {{ $notification['title'] }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($notification['created_at'])->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Cuerpo --}}
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $notification['message'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- ESTADO VACÍO --}}
                <div class="py-12 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800 mb-1">No hay notificaciones</h3>
                    <p class="text-gray-500 text-sm mb-4">
                        No se han registrado notificaciones en el sistema.
                    </p>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('notificaciones.create') }}" 
                               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-[var(--blue-primary)] text-white rounded-md hover:bg-[var(--blue-hover)] transition-colors text-sm font-medium">
                                <i class="fas fa-plus"></i> Crear Primera Notificación
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
