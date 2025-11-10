<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        // Solo administradores pueden ver la lista de usuarios
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home')
                           ->with('error', 'No tienes permisos para ver esta página.');
        }

        $usuarios = Usuario::with(['docente', 'administrador'])
            ->orderBy('nombre')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }
}