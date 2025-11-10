<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Asistencia;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF; // Requiere laravel-dompdf

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
        $asistencias = Asistencia::where('id_docente', $idDocente)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with('docente.usuario')
            ->get();

        $resumen = [
            'total_dias' => $asistencias->count(),
            'presentes' => $asistencias->where('estado', 'presente')->count(),
            'ausentes' => $asistencias->where('estado', 'ausente')->count(),
            'tardanzas' => $asistencias->where('estado', 'tardanza')->count(),
        ];

        return [
            'tipo' => 'asistencia',
            'docente' => $asistencias->first()->docente->usuario->nombre ?? 'N/A',
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
    private function generarReporteRendimiento($idDocente, $fechaInicio, $fechaFin): array
    {
        $asistencia = $this->generarReporteAsistencia($idDocente, $fechaInicio, $fechaFin);
        $docente = Docente::with(['grupos.asignacionesHorario', 'grupos.materia', 'usuario'])
            ->find($idDocente);

        $horasProgramadas = 0;
        $horasImpartidas = 0;
        $materias = [];

        foreach ($docente->grupos as $grupo) {
            foreach ($grupo->asignacionesHorario as $horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin = Carbon::parse($horario->hora_fin);
                $horas = $fin->diffInMinutes($inicio) / 60;
                $horasProgramadas += $horas;

                $materias[$grupo->materia->sigla] = [
                    'nombre' => $grupo->materia->nombre,
                    'horas_programadas' => ($materias[$grupo->materia->sigla]['horas_programadas'] ?? 0) + $horas,
                    'grupos' => ($materias[$grupo->materia->sigla]['grupos'] ?? 0) + 1
                ];
            }
        }

        // Calcular horas realmente impartidas basado en asistencias
        $horasImpartidas = $horasProgramadas * ($asistencia['resumen']['presentes'] / max(1, $asistencia['resumen']['total_dias']));

        return [
            'tipo' => 'rendimiento',
            'docente' => $docente->usuario->nombre,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'asistencia' => $asistencia['resumen'],
            'horas_programadas' => $horasProgramadas,
            'horas_impartidas' => $horasImpartidas,
            'porcentaje_asistencia' => ($asistencia['resumen']['presentes'] / max(1, $asistencia['resumen']['total_dias'])) * 100,
            'materias' => $materias
        ];
    }
}