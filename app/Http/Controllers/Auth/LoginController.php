<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Intentar autenticar
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            /** @var Usuario $user */
            $user = Auth::user();

            // Registrar en bitácora
            Bitacora::create([
                'id_usuario' => $user->id_usuario,
                'ip_origen' => $request->ip(),
                'descripcion' => "Inicio de sesión exitoso",
            ]);

            // Redirigir según rol
            if ($user->isAdmin()) {
                return redirect()->intended(route('administradores.index'));
            } elseif ($user->isDocente()) {
                return redirect()->intended(route('docentes.index'));
            }

            // Si no tiene rol, cerrar sesión
            Auth::logout();
            return back()->withErrors(['email' => 'El usuario no tiene un rol válido.']);
        }

        throw ValidationException::withMessages([
            'email' => ['Las credenciales no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Cierra la sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
