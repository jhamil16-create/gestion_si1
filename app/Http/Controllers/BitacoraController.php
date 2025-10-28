<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    /**
     * Muestra una lista paginada de todos los registros de la bitácora.
     */
    public function index(Request $request)
    {
        // Cargar bitácoras con la info del usuario que hizo la acción
        // Ordenadas de más reciente a más antiguo
        $bitacoras = Bitacora::with('usuario')
                            ->orderBy('fecha_hora', 'desc')
                            ->paginate(25); // Paginar de 25 en 25

        return view('bitacoras.index', compact('bitacoras'));
    }

    /**
     * Muestra el detalle de un registro específico.
     */
    public function show(Bitacora $bitacora)
    {
        $bitacora->load('usuario');
        return view('bitacoras.show', compact('bitacora'));
    }

    /**
     * Elimina un registro de la bitácora (para purgar).
     */
    public function destroy(Bitacora $bitacora)
    {
        $bitacora->delete();
        return redirect()->route('bitacoras.index')->with('success', 'Registro de bitácora eliminado.');
    }
}
