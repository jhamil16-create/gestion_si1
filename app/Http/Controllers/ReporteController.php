<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Asistencia;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la página principal de reportes.
     */
    public function index()
    {
        $docentes = Auth::user()->isAdmin() 
            ? Docente::with('usuario')->get() 
            : collect([Auth::user()->docente]);

        return view('reportes.index', compact('docentes'));
    }

    /**
     * Genera el reporte solicitado.
     */
    public function generar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:asistencia,carga_horaria,rendimiento',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'id_docente' => 'required_if:tipo,asistencia,rendimiento|exists:docente,id_docente'
        ]);

        // Verificar permisos
        if (!Auth::user()->isAdmin() && 
            $request->id_docente != Auth::user()->docente->id_docente) {
            return redirect()->route('reportes.index')
                           ->with('error', 'No puedes generar reportes de otros docentes.');
        }

        $data = [];
        $titulo = '';

        switch ($request->tipo) {
            case 'asistencia':
                $data = $this->generarReporteAsistencia(
                    $request->id_docente,
                    $request->fecha_inicio,
                    $request->fecha_fin
                );
                $titulo = 'Reporte de Asistencia';
                break;

            case 'carga_horaria':
                $data = $this->generarReporteCargaHoraria(
                    $request->fecha_inicio,
                    $request->fecha_fin
                );
                $titulo = 'Reporte de Carga Horaria';
                break;

            case 'rendimiento':
                $data = $this->generarReporteRendimiento(
                    $request->id_docente,
                    $request->fecha_inicio,
                    $request->fecha_fin
                );
                $titulo = 'Reporte de Rendimiento';
                break;
        }

        // Registrar en bitácora
        Bitacora::create([
            'id_usuario' => Auth::id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Generó {$titulo} del {$request->fecha_inicio} al {$request->fecha_fin}",
        ]);

        if ($request->formato === 'pdf') {
            $pdf = PDF::loadView('reportes.pdf', compact('data', 'titulo'));
            return $pdf->download("reporte_{$request->tipo}.pdf");
        }

        return view('reportes.show', compact('data', 'titulo'));
    }

 /**
 * Genera reporte de asistencia para un docente.
 */
    private function generarReporteAsistencia($idDocente, $fechaInicio, $fechaFin): array
    {
        // SOLUCIÓN SIN AULA - Más simple
        $asistencias = Asistencia::select('asistencia.*', 'usuario.nombre as docente_nombre')
            ->join('asignacion_horario', 'asistencia.id_asignacion', '=', 'asignacion_horario.id_asignacion')
            ->join('grupo', 'asignacion_horario.id_grupo', '=', 'grupo.id_grupo')
            ->join('docente_grupo', 'grupo.id_grupo', '=', 'docente_grupo.id_grupo')
            ->join('docente', 'docente_grupo.id_docente', '=', 'docente.id_docente')
            ->join('usuario', 'docente.id_usuario', '=', 'usuario.id_usuario')
            ->where('docente.id_docente', $idDocente)
            ->whereBetween('asistencia.fecha', [$fechaInicio, $fechaFin])
            ->get();

        $resumen = [
            'total_dias' => $asistencias->count(),
            'presentes' => $asistencias->where('estado', 'presente')->count(),
            'ausentes' => $asistencias->where('estado', 'ausente')->count(),
            'tardanzas' => $asistencias->where('estado', 'tardanza')->count(),
        ];

        return [
            'tipo' => 'asistencia',
            'docente' => $asistencias->first()->docente_nombre ?? 'N/A',
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'resumen' => $resumen,
            'detalle' => $asistencias
        ];
    }

    /**
     * Genera reporte de carga horaria global o por docente.
     */
    private function generarReporteCargaHoraria($fechaInicio, $fechaFin): array
    {
        $docentes = Auth::user()->isAdmin()
            ? Docente::with(['grupos.asignacionesHorario', 'grupos.materia', 'usuario'])
                ->get()
            : collect([Auth::user()->docente->load(['grupos.asignacionesHorario', 'grupos.materia', 'usuario'])]);

        $cargaHoraria = [];
        foreach ($docentes as $docente) {
            $horasTotales = 0;
            $materias = [];

            foreach ($docente->grupos as $grupo) {
                foreach ($grupo->asignacionesHorario as $horario) {
                    $inicio = Carbon::parse($horario->hora_inicio);
                    $fin = Carbon::parse($horario->hora_fin);
                    $horas = $fin->diffInMinutes($inicio) / 60;
                    $horasTotales += $horas;

                    $materias[$grupo->materia->sigla] = ($materias[$grupo->materia->sigla] ?? 0) + $horas;
                }
            }

            $cargaHoraria[] = [
                'docente' => $docente->usuario->nombre,
                'horas_totales' => $horasTotales,
                'materias' => $materias
            ];
        }

        return [
            'tipo' => 'carga_horaria',
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'detalle' => $cargaHoraria
        ];
    }

    /**
     * Genera reporte de rendimiento (asistencia + carga horaria).
     */
/**
 * Genera reporte de rendimiento (asistencia + carga horaria).
 */
    private function generarReporteRendimiento($idDocente, $fechaInicio, $fechaFin): array
    {
        $asistencia = $this->generarReporteAsistencia($idDocente, $fechaInicio, $fechaFin);
        
        // Obtener el docente
        $docente = Docente::with(['usuario'])->find($idDocente);
        
        // Calcular horas programadas (necesitas ajustar según tu lógica de negocio)
        $horasProgramadas = 0;
        $materias = [];

        // Aquí va tu lógica para calcular horas programadas
        // Esto es un ejemplo - ajusta según tu sistema
        $horasProgramadas = $asistencia['resumen']['total_dias'] * 8; // Ejemplo: 8 horas por día

        // Calcular horas realmente impartidas
        $totalDias = max(1, $asistencia['resumen']['total_dias']);
        $presentes = $asistencia['resumen']['presentes'];
        $horasImpartidas = $horasProgramadas * ($presentes / $totalDias);

        return [
            'tipo' => 'rendimiento',
            'docente' => $docente->usuario->nombre ?? 'N/A',
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'asistencia' => $asistencia['resumen'],
            'horas_programadas' => $horasProgramadas,
            'horas_impartidas' => $horasImpartidas,
            'porcentaje_asistencia' => ($presentes / $totalDias) * 100,
            'materias' => $materias
        ];
    }
}