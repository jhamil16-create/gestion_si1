<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Docente;

class DocentePanelController extends Controller
{
    /**
     * Esta función maneja /mi-carga con parámetro opcional
     */
    public function miCarga()
    {
        $usuario = Auth::user();

        // Si es DOCENTE, muestra SU carga
        if ($docente = $usuario->docente) {
            return $this->mostrarCarga($docente);
        }

        // Si es ADMIN, muestra lista de docentes
        if ($usuario->administrador) { 
            $docentes = Docente::with('usuario')->get();
            return view('docentes.lista-para-admin', compact('docentes'));
        }

        return redirect()->back()->with('error', 'No tienes permisos para ver esta sección.');
    }

    /**
     * Esta función muestra la carga específica de un docente
     */
    public function mostrarCarga(Docente $docente)
    {
        // Tu lógica existente aquí...
        $gruposPublicados = $docente->grupos()
            ->whereHas('gestionAcademica', function ($query) {
                $query->where('estado', 'publicado');
            })
            ->with(['materia', 'gestionAcademica', 'asignacionesHorario'])
            ->get();

        $cargaDetallada = [];
        $totalHorasSemana = 0;
        $totalGrupos = $gruposPublicados->count();

        foreach ($gruposPublicados as $grupo) {
            $horasGrupo = 0;
            
            foreach ($grupo->asignacionesHorario as $horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin = Carbon::parse($horario->hora_fin);
                $minutos = $fin->diffInMinutes($inicio);
                $horasGrupo += $minutos / 60;
            }
            
            $totalHorasSemana += $horasGrupo;

            $cargaDetallada[] = [
                'materia_nombre' => $grupo->materia->nombre,
                'materia_sigla' => $grupo->materia->sigla,
                'grupo_nombre' => $grupo->nombre,
                'gestion_nombre' => $grupo->gestionAcademica->nombre,
                'horas_semana' => $horasGrupo
            ];
        }

        return view('docentes.mi-carga', compact(
            'cargaDetallada', 
            'totalHorasSemana',
            'totalGrupos',
            'docente'
        ));
    }
}