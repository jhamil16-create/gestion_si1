@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <i class="fas fa-bell text-5xl text-blue-400 mb-6"></i>
            <h3 class="text-2xl font-semibold text-gray-700 mb-3">Sistema de Notificaciones</h3>
            
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">
                    Total: {{ count($notifications) }} notificaciones
                </p>
                
                @if(count($notifications) > 0)
                    <span class="text-green-600 font-medium">
                        {{ count($notifications) }} notificaciones activas
                    </span>
                @endif
            </div>
        </div>

        <!-- Botón Crear Notificación (Solo Admin) -->
        @auth
            @if(Auth::user()->isAdmin())
                <div class="mb-6 text-right">
                    <a href="{{ route('notificaciones.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Crear Notificación
                    </a>
                </div>
            @endif
        @endauth

        <!-- Lista de Notificaciones -->
        @if(count($notifications) > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $notification['title'] }}</h4>
                                <p class="text-gray-600 mt-1">{{ $notification['message'] }}</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <a href="{{ route('notificaciones.show', $notification['id']) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <form action="{{ route('notificaciones.destroy', $notification['id']) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600">No hay notificaciones para mostrar.</p>
            </div>
        @endif
    </div>
</div>
@endsection