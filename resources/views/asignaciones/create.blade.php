@extends('layouts.app')
@section('title', 'Asignar Horario')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Asignar Horario a Grupo: <span class="text-blue-600">{{ $grupo->nombre }}</span></h2>

    <form action="{{ route('asignaciones.store', $grupo) }}" method="POST">
        @csrf
        <input type="hidden" name="id_grupo" value="{{ $grupo->id_grupo }}">

        {{-- =================================================== --}}
        {{-- INICIO DE LA CORRECCIÓN (Campo Día) --}}
        {{-- =================================================== --}}
        <div class="mb-4">
            <label for="dia" class="block text-sm font-medium mb-1">Día</label>
            {{-- Se cambió de input a select para asegurar datos correctos --}}
            <select name="dia" id="dia" required 
                    class="w-full border rounded px-3 py-2 @error('dia') border-red-500 @enderror">
                <option value="">Seleccione un día</option>
                <option value="LUNES" {{ old('dia') == 'LUNES' ? 'selected' : '' }}>LUNES</option>
                <option value="MARTES" {{ old('dia') == 'MARTES' ? 'selected' : '' }}>MARTES</option>
                <option value="MIERCOLES" {{ old('dia') == 'MIERCOLES' ? 'selected' : '' }}>MIERCOLES</option>
                <option value="JUEVES" {{ old('dia') == 'JUEVES' ? 'selected' : '' }}>JUEVES</option>
                <option value="VIERNES" {{ old('dia') == 'VIERNES' ? 'selected' : '' }}>VIERNES</option>
                <option value="SABADO" {{ old('dia') == 'SABADO' ? 'selected' : '' }}>SABADO</option>
            </select>
            @error('dia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        {{-- =================================================== --}}
        {{-- FIN DE LA CORRECCIÓN --}}
        {{-- =================================================== --}}


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Hora Inicio</label>
                <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                       class="w-full border rounded px-3 py-2 @error('hora_inicio') border-red-500 @enderror">
                @error('hora_inicio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Hora Fin</label>
                <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required
                       class="w-full border rounded px-3 py-2 @error('hora_fin') border-red-500 @enderror">
                @error('hora_fin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- =================================================== --}}
        {{-- INICIO DE LA CORRECCIÓN (Campo Aula) --}}
        {{-- =================================================== --}}
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Aula</label>
            <select name="id_aula" required class="w-full border rounded px-3 py-2">
                <option value="">Seleccione un aula</option>
                @foreach ($aulas as $aula)
                    {{-- 
                      Aquí está el cambio:
                      Se muestra el ID del aula + el Tipo.
                      Se quitó la Capacidad.
                    --}}
                    <option value="{{ $aula->id_aula }}" {{ old('id_aula') == $aula->id_aula ? 'selected' : '' }}>
                        {{ $aula->id_aula }} {{ $aula->tipo }}
                    </option>
                @endforeach
            </select>
            @error('id_aula')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        {{-- =================================================== --}}
        {{-- FIN DE LA CORRECCIÓN --}}
        {{-- =================================================== --}}


        <div class="flex justify-end space-x-3">
            <a href="{{ route('grupos.show', $grupo) }}" class="px-4 py-2 border rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Asignar Horario</button>
        </div>
    </form>
</div>
@endsection