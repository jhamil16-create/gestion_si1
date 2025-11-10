@extends('layouts.app')

@section('title', 'Nueva Notificación')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Nueva Notificación
        </h1>
        <a href="{{ route('notificaciones.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
            Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-lg shadow-xl p-6">
        <form action="{{ route('notificaciones.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Título --}}
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">
                        Título
                    </label>
                    <input type="text" 
                           name="titulo" 
                           id="titulo"
                           value="{{ old('titulo') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('titulo') border-red-500 @enderror"
                           required>
                    @error('titulo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mensaje --}}
                <div>
                    <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-1">
                        Mensaje
                    </label>
                    <textarea name="mensaje" 
                              id="mensaje"
                              rows="4"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('mensaje') border-red-500 @enderror"
                              required>{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo --}}
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo
                    </label>
                    <select name="tipo" 
                            id="tipo"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('tipo') border-red-500 @enderror"
                            required>
                        <option value="info" {{ old('tipo') === 'info' ? 'selected' : '' }}>
                            Informativa
                        </option>
                        <option value="alerta" {{ old('tipo') === 'alerta' ? 'selected' : '' }}>
                            Alerta
                        </option>
                        <option value="urgente" {{ old('tipo') === 'urgente' ? 'selected' : '' }}>
                            Urgente
                        </option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Destinatario --}}
                <div>
                    <label for="destinatario" class="block text-sm font-medium text-gray-700 mb-1">
                        Destinatario
                    </label>
                    <select name="destinatario" 
                            id="destinatario"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('destinatario') border-red-500 @enderror"
                            required>
                        <option value="todos" {{ old('destinatario') === 'todos' ? 'selected' : '' }}>
                            Todos los usuarios
                        </option>
                        <option value="docentes" {{ old('destinatario') === 'docentes' ? 'selected' : '' }}>
                            Solo docentes
                        </option>
                        <option value="administradores" {{ old('destinatario') === 'administradores' ? 'selected' : '' }}>
                            Solo administradores
                        </option>
                    </select>
                    @error('destinatario')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" 
                        onclick="window.history.back()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Enviar Notificación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection