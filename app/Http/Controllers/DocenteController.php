<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Usuario;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('usuario')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }
    public function listaParaAdmin()
    {
        try {
            $docentes = Docente::with('usuario')->get();
            
            // Cambia por una vista que sí tengas:
            return view('docentes.index', compact('docentes'));
            // O:
            return view('admin.docentes.index', compact('docentes'));
            // O incluso:
            return view('admin.planificar-horarios', compact('docentes'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar la lista: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|min:8|confirmed',
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $usuario = Usuario::create([
                'email' => $request->email,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
            ]);

            $docente = new Docente();
            $docente->id_usuario = $usuario->id_usuario;
            $docente->save();

            // Registrar en bitácora
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Creó al docente '{$request->nombre}' (Email: {$request->email})",
            ]);

            DB::commit();
            return redirect()->route('docentes.index')->with('success', 'Docente creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear docente: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Docente $docente)
    {
        $docente->load('usuario', 'grupos.materia', 'grupos.gestionAcademica');
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        $docente->load('usuario');
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('usuario', 'email')->ignore($docente->id_usuario, 'id_usuario')
            ],
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();
            
            $usuario = $docente->usuario;
            $oldNombre = $usuario->nombre;
            $oldEmail = $usuario->email;

            $usuario->update([
                'email' => $request->email,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
            ]);

            if ($request->filled('password')) {
                $usuario->update(['password' => Hash::make($request->password)]);
            }

            // Registrar en bitácora
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Actualizó al docente de '{$oldNombre} ({$oldEmail})' a '{$request->nombre} ({$request->email})'",
            ]);

            DB::commit();
            return redirect()->route('docentes.index')->with('success', 'Docente actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Docente $docente)
    {
        try {
            $nombre = $docente->usuario->nombre;
            $email = $docente->usuario->email;

            // Registrar antes de eliminar
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó al docente '{$nombre}' (Email: {$email})",
            ]);

            $docente->usuario->delete();
            return redirect()->route('docentes.index')->with('success', 'Docente eliminado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
