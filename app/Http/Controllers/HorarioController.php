<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;

class HorarioController extends Controller
{
    /**
     * Lista de docentes para admin
     */
    public function listaDocentes()
    {
        if (!Auth::user()->administrador) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        $docentes = Docente::with('usuario')->paginate(10);
        return view('horarios.lista-docentes', compact('docentes'));
    }

    /**
     * Horario específico de un docente (para admin)
     */
    public function horarioDocente($id)
    {
        if (!Auth::user()->administrador) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        $docente = Docente::with('usuario')->findOrFail($id);
        $horarioData = $this->obtenerHorarioReal($docente->id_docente);
        
        return view('docentes.horario', array_merge($horarioData, [
            'docente' => $docente,
            'esAdmin' => true
        ]));
    }

    /**
     * Horario del docente actual - CORREGIDO
     */
    public function miHorario()
    {
        // Buscar si el usuario actual es docente
        $docente = Docente::where('id_usuario', Auth::id())->first();
        
        if (!$docente) {
            abort(403, 'No tienes permisos para acceder a esta página. No se encontró información de docente.');
        }

        $horarioData = $this->obtenerHorarioReal($docente->id_docente);
        
        return view('docentes.horario', array_merge($horarioData, [
            'docente' => $docente,
            'esAdmin' => false
        ]));
    }

    /**
     * CONSULTA REAL - Usando tu estructura de base de datos
     */
    private function obtenerHorarioReal($idDocente)
    {
        $dias = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES'];
        
        try {
            // CONSULTA CORREGIDA - usando tus tablas reales
            $clases = DB::table('asignacion_horario as a')
                ->select(
                    'u.nombre as docente',
                    'g.nombre as grupo_nombre',
                    'g.sigla as materia_sigla',
                    'a.dia',
                    'a.hora_inicio',
                    'a.hora_fin',
                    'a.id_aula'
                )
                ->join('grupo as g', 'a.id_grupo', '=', 'g.id_grupo')
                ->join('docente_grupo as dg', 'g.id_grupo', '=', 'dg.id_grupo')
                ->join('docente as d', 'dg.id_docente', '=', 'd.id_docente')
                ->join('usuario as u', 'd.id_usuario', '=', 'u.id_usuario')
                ->where('d.id_docente', $idDocente)
                ->orderByRaw("
                    CASE a.dia
                        WHEN 'LUNES' THEN 1
                        WHEN 'MARTES' THEN 2
                        WHEN 'MIERCOLES' THEN 3
                        WHEN 'JUEVES' THEN 4
                        WHEN 'VIERNES' THEN 5
                        ELSE 6
                    END,
                    a.hora_inicio
                ")
                ->get();

        } catch (\Exception $e) {
            // Si hay error en la consulta, retornar vacío
            return [
                'dias' => $dias,
                'horario' => [],
                'total_clases' => 0,
                'error' => $e->getMessage()
            ];
        }

        // Organizar por días
        $horario = [];
        foreach ($dias as $dia) {
            $horario[$dia] = [];
        }

        foreach ($clases as $clase) {
            $dia = $clase->dia;
            
            $horario[$dia][] = [
                'materia' => $clase->materia_sigla ?? 'Sin materia',
                'sigla' => $clase->materia_sigla ?? 'N/A',
                'grupo' => $clase->grupo_nombre ?? 'Sin grupo',
                'aula' => $clase->id_aula ?? 'Sin aula',
                'hora_inicio' => $clase->hora_inicio,
                'hora_fin' => $clase->hora_fin,
                'tipo' => 'normal'
            ];
        }

        return [
            'dias' => $dias,
            'horario' => $horario,
            'total_clases' => $clases->count(),
            'clases_raw' => $clases // Para debug
        ];
    }

    /**
     * Función para DEBUG - ver qué datos hay realmente
     */
    public function debugDatos($idDocente = null)
    {
        if (!$idDocente) {
            $docente = Docente::where('id_usuario', Auth::id())->first();
            if ($docente) {
                $idDocente = $docente->id_docente;
            } else {
                return "No se encontró docente";
            }
        }

        echo "<h3>DEBUG para docente ID: $idDocente</h3>";

        // 1. Ver grupos del docente
        $grupos = DB::table('docente_grupo')
            ->where('id_docente', $idDocente)
            ->get();
        echo "<h4>Grupos del docente:</h4>";
        dump($grupos->toArray());

        if ($grupos->isNotEmpty()) {
            $gruposIds = $grupos->pluck('id_grupo')->toArray();
            
            // 2. Ver horarios de esos grupos
            $horarios = DB::table('asignacion_horario')
                ->whereIn('id_grupo', $gruposIds)
                ->get();
            echo "<h4>Horarios de los grupos:</h4>";
            dump($horarios->toArray());

            // 3. Ver información completa (CONSULTA REAL)
            $completo = DB::table('asignacion_horario as a')
                ->select(
                    'u.nombre as docente',
                    'g.nombre as grupo',
                    'g.sigla as materia',
                    'a.dia',
                    'a.hora_inicio',
                    'a.hora_fin',
                    'a.id_aula'
                )
                ->join('grupo as g', 'a.id_grupo', '=', 'g.id_grupo')
                ->join('docente_grupo as dg', 'g.id_grupo', '=', 'dg.id_grupo')
                ->join('docente as d', 'dg.id_docente', '=', 'd.id_docente')
                ->join('usuario as u', 'd.id_usuario', '=', 'u.id_usuario')
                ->where('d.id_docente', $idDocente)
                ->get();
                
            echo "<h4>Información completa (consulta real):</h4>";
            dump($completo->toArray());
        }

        exit();
    }
}