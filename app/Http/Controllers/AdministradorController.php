<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Usuario;
use App\Models\Bitacora; // ← Añadido
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::with('usuario')->get();
        return view('administradores.index', compact('administradores'));
    }

    public function create()
    {
        return view('administradores.create');
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

            $admin = new Administrador();
            $admin->id_usuario = $usuario->id_usuario;
            $admin->save();

            // Registrar en bitácora
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Creó al administrador '{$request->nombre}' (Email: {$request->email})",
            ]);

            DB::commit();
            return redirect()->route('administradores.index')->with('success', 'Administrador creado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Administrador $administrador)
    {
        $administrador->load('usuario');
        return view('administradores.show', compact('administrador'));
    }

    public function edit(Administrador $administrador)
    {
        $administrador->load('usuario');
        return view('administradores.edit', compact('administrador'));
    }
    
    public function update(Request $request, Administrador $administrador)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('usuario', 'email')->ignore($administrador->id_usuario, 'id_usuario')
            ],
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();
            
            $usuario = $administrador->usuario;
            $oldNombre = $usuario->nombre;
            $oldEmail = $usuario->email;

            $usuario->update($request->only('email', 'nombre', 'telefono'));

            if ($request->filled('password')) {
                $usuario->update(['password' => Hash::make($request->password)]);
            }

            // Registrar en bitácora
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Actualizó al administrador de '{$oldNombre} ({$oldEmail})' a '{$request->nombre} ({$request->email})'",
            ]);
            
            DB::commit();
            return redirect()->route('administradores.index')->with('success', 'Administrador actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Administrador $administrador)
    {
        $nombre = $administrador->usuario->nombre;
        $email = $administrador->usuario->email;

        // Registrar en bitácora antes de eliminar
        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => request()->ip(),
            'descripcion' => "Eliminó al administrador '{$nombre}' (Email: {$email})",
        ]);

        $administrador->usuario->delete();
        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado.');
    }
}
