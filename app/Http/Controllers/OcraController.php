<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\OcraEvaluacion;
use App\Models\OcraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OcraController extends Controller
{
    public function create($evaluacionId)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo',
            'usuario',
        ])->findOrFail($evaluacionId);

        return view('ocra.create', compact('evaluacion'));
    }

    public function store(Request $request, $evaluacionId)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacionId);

        $request->validate([
            'lado_evaluado' => 'required|string|max:50',

            'duracion_turno' => 'required|numeric|min:1',
            'tiempo_no_repetitivo' => 'required|numeric|min:0',
            'pausas' => 'required|numeric|min:0',
            'almuerzo' => 'required|numeric|min:0',
            'numero_ciclos' => 'required|numeric|min:1',

            'fr' => 'required|numeric|min:0',
            'atd' => 'required|numeric|min:0',
            'ate' => 'required|numeric|min:0',
            'ffz' => 'required|numeric|min:0',

            'pho' => 'required|numeric|min:0',
            'pco' => 'required|numeric|min:0',
            'pmu' => 'required|numeric|min:0',
            'pma' => 'required|numeric|min:0',
            'pes' => 'required|numeric|min:0',

            'ffm' => 'required|numeric|min:0',
            'fso' => 'required|numeric|min:0',

            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $duracionTurno = (float) $request->duracion_turno;
            $tiempoNoRepetitivo = (float) $request->tiempo_no_repetitivo;
            $pausas = (float) $request->pausas;
            $almuerzo = (float) $request->almuerzo;
            $numeroCiclos = max((float) $request->numero_ciclos, 1);

            $tntr = max($duracionTurno - ($tiempoNoRepetitivo + $pausas + $almuerzo), 0);
            $tnc = $numeroCiclos > 0 ? round((60 * $tntr) / $numeroCiclos, 2) : 0;

            $fr = (float) $request->fr;
            $atd = (float) $request->atd;
            $ate = (float) $request->ate;
            $ff = max($atd, $ate);

            $ffz = (float) $request->ffz;

            $pho = (float) $request->pho;
            $pco = (float) $request->pco;
            $pmu = (float) $request->pmu;
            $pma = (float) $request->pma;
            $pes = (float) $request->pes;

            $fp = max($pho, $pco, $pmu, $pma) + $pes;

            $ffm = (float) $request->ffm;
            $fso = (float) $request->fso;
            $fc = $ffm + $fso;

            $md = $this->calcularMD($tntr);

            $ickl = round(($fr + $ff + $ffz + $fp + $fc) * $md, 2);

            [$nivelRiesgo, $accionRecomendada, $recomendaciones] = $this->clasificarRiesgo($ickl);

            $ocra = OcraEvaluacion::create([
                'evaluacion_id' => $evaluacion->id,
                'lado_evaluado' => $request->lado_evaluado,

                'duracion_turno' => $duracionTurno,
                'tiempo_no_repetitivo' => $tiempoNoRepetitivo,
                'pausas' => $pausas,
                'almuerzo' => $almuerzo,
                'numero_ciclos' => $numeroCiclos,

                'tntr' => $tntr,
                'tnc' => $tnc,

                'fr' => $fr,
                'atd' => $atd,
                'ate' => $ate,
                'ff' => $ff,
                'ffz' => $ffz,

                'pho' => $pho,
                'pco' => $pco,
                'pmu' => $pmu,
                'pma' => $pma,
                'pes' => $pes,
                'fp' => $fp,

                'ffm' => $ffm,
                'fso' => $fso,
                'fc' => $fc,

                'md' => $md,
                'ickl' => $ickl,
                'indice_ocra' => $ickl,
                'nivel_riesgo' => $nivelRiesgo,
                'accion_recomendada' => $accionRecomendada,
                'recomendaciones' => $recomendaciones,
                'observaciones' => $request->observaciones,
            ]);

            $this->guardarDetalles($ocra);

            $evaluacion->update([
                'resultado_final' => $ickl,
                'nivel_riesgo' => $nivelRiesgo,
                'recomendaciones' => $recomendaciones,
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            return redirect()
                ->route('ocra.show', $ocra->id)
                ->with('success', 'Evaluación Check List OCRA registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al guardar OCRA: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $ocra = OcraEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.metodo',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);

        return view('ocra.show', compact('ocra'));
    }

    public function pdf($id)
    {
        $ocra = OcraEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'evaluacion.metodo',
            'evaluacion.usuario',
            'detalles',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('ocra.pdf', compact('ocra'))
            ->setPaper('letter', 'portrait');

        return $pdf->download('reporte_ocra_' . $ocra->id . '.pdf');
    }

    private function calcularMD(float $tntr): float
    {
        if ($tntr <= 1.87) return 0.01;
        if ($tntr <= 3.75) return 0.02;
        if ($tntr <= 7.5) return 0.05;
        if ($tntr <= 15) return 0.1;
        if ($tntr <= 30) return 0.2;
        if ($tntr <= 59) return 0.35;
        if ($tntr <= 120) return 0.5;
        if ($tntr <= 180) return 0.65;
        if ($tntr <= 240) return 0.75;
        if ($tntr <= 300) return 0.85;
        if ($tntr <= 360) return 0.925;
        if ($tntr <= 420) return 0.95;
        if ($tntr <= 480) return 1;
        if ($tntr <= 539) return 1.2;
        if ($tntr <= 599) return 1.5;
        if ($tntr <= 659) return 2;
        if ($tntr <= 719) return 2.8;

        return 4;
    }

    private function clasificarRiesgo(float $ickl): array
    {
        if ($ickl <= 5) {
            return [
                'Óptimo',
                'No se requiere acción correctiva.',
                'Mantener las condiciones actuales del puesto y continuar con vigilancia preventiva.',
            ];
        }

        if ($ickl <= 7.5) {
            return [
                'Aceptable',
                'No se requiere acción correctiva.',
                'Mantener las condiciones actuales y revisar periódicamente la tarea.',
            ];
        }

        if ($ickl <= 11) {
            return [
                'Incierto',
                'Se recomienda un nuevo análisis o mejora del puesto.',
                'Revisar la tarea con mayor detalle, especialmente frecuencia, pausas, posturas y fuerza aplicada.',
            ];
        }

        if ($ickl <= 14) {
            return [
                'Inaceptable Leve',
                'Se recomienda mejora del puesto, supervisión médica y entrenamiento.',
                'Implementar mejoras ergonómicas, ajustar pausas y capacitar al trabajador.',
            ];
        }

        if ($ickl <= 22.5) {
            return [
                'Inaceptable Medio',
                'Se recomienda mejora del puesto, supervisión médica y entrenamiento.',
                'Rediseñar la tarea, reducir frecuencia de acciones, mejorar recuperación y controlar posturas forzadas.',
            ];
        }

        return [
            'Inaceptable Alto',
            'Se requiere intervención prioritaria, mejora del puesto, supervisión médica y entrenamiento.',
            'Intervenir de forma inmediata. Reducir exposición, fuerza, repetitividad y factores adicionales.',
        ];
    }

    private function guardarDetalles(OcraEvaluacion $ocra): void
    {
        $detalles = [
            ['Organización', 'Duración del turno DT', $ocra->duracion_turno . ' min', $ocra->duracion_turno],
            ['Organización', 'Tiempo no repetitivo TNR', $ocra->tiempo_no_repetitivo . ' min', $ocra->tiempo_no_repetitivo],
            ['Organización', 'Pausas P', $ocra->pausas . ' min', $ocra->pausas],
            ['Organización', 'Almuerzo A', $ocra->almuerzo . ' min', $ocra->almuerzo],
            ['Organización', 'Número de ciclos NC', $ocra->numero_ciclos, $ocra->numero_ciclos],
            ['Organización', 'Tiempo Neto de Trabajo Repetitivo TNTR', $ocra->tntr . ' min', $ocra->tntr],
            ['Organización', 'Tiempo Neto de Ciclo TNC', $ocra->tnc . ' seg', $ocra->tnc],

            ['Factor recuperación', 'FR', $ocra->fr, $ocra->fr],
            ['Factor frecuencia', 'ATD', $ocra->atd, $ocra->atd],
            ['Factor frecuencia', 'ATE', $ocra->ate, $ocra->ate],
            ['Factor frecuencia', 'FF = Max(ATD, ATE)', $ocra->ff, $ocra->ff],

            ['Factor fuerza', 'FFz', $ocra->ffz, $ocra->ffz],

            ['Posturas', 'PHo hombro', $ocra->pho, $ocra->pho],
            ['Posturas', 'PCo codo', $ocra->pco, $ocra->pco],
            ['Posturas', 'PMu muñeca', $ocra->pmu, $ocra->pmu],
            ['Posturas', 'PMa mano/agarre', $ocra->pma, $ocra->pma],
            ['Posturas', 'PEs movimientos estereotipados', $ocra->pes, $ocra->pes],
            ['Posturas', 'FP = Max(PHo, PCo, PMu, PMa) + PEs', $ocra->fp, $ocra->fp],

            ['Factores adicionales', 'Ffm físico-mecánicos', $ocra->ffm, $ocra->ffm],
            ['Factores adicionales', 'Fso socio-organizativos', $ocra->fso, $ocra->fso],
            ['Factores adicionales', 'FC = Ffm + Fso', $ocra->fc, $ocra->fc],

            ['Resultado', 'MD multiplicador de duración', $ocra->md, $ocra->md],
            ['Resultado', 'ICKL = (FR + FF + FFz + FP + FC) × MD', $ocra->ickl, $ocra->ickl],
        ];

        foreach ($detalles as $detalle) {
            OcraDetalle::create([
                'ocra_evaluacion_id' => $ocra->id,
                'seccion' => $detalle[0],
                'concepto' => $detalle[1],
                'valor' => $detalle[2],
                'puntaje' => $detalle[3],
            ]);
        }
    }
}