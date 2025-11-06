@extends('layouts.app')
@section('title', 'Editar Docente')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Docente: {{ $docente->usuario->nombre }}</h2>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('docentes.update', $docente->id_docente) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre Completo</label>
            <input type="text" 
                   name="nombre" 
                   value="{{ old('nombre', $docente->usuario->nombre) }}" 
                   required 
                   maxlength="255" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email', $docente->usuario->email) }}" 
                   required 
                   maxlength="255" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Teléfono <span class="text-gray-500 text-sm">(opcional)</span></label>
            <input type="text" 
                   name="telefono" 
                   value="{{ old('telefono', $docente->usuario->telefono) }}" 
                   maxlength="255" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <!-- INICIO DE CORRECCIÓN: Sección de Contraseña Actualizada -->
        <div class="mb-6 border-t border-gray-200 pt-6 mt-6">
            <p class="font-semibold text-lg mb-2">Cambiar Contraseña</p>
            <p class="text-gray-500 text-sm mb-4">
                Solo completa estos campos si deseas cambiar la contraseña. Déjalos en blanco para no cambiarla.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-semibold text-sm">Nueva Contraseña</label>
                    <input type="password" 
                           name="password" 
                           minlength="8" 
                           class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror"
                           placeholder="Mínimo 8 caracteres">
                    
                    {{-- Este error se activará si la confirmación falla --}}
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-sm">Confirmar Nueva Contraseña</label>
                    <input type="password" 
                           name="password_confirmation" {{-- ¡Este es el campo que faltaba! --}}
                           minlength="8" 
                           class="w-full border rounded px-3 py-2"
                           placeholder="Repite la contraseña">
                </div>
            </div>
        </div>
        <!-- FIN DE CORRECCIÓN -->

        <div class="flex justify-end space-x-3">
            <a href="{{ route('docentes.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection