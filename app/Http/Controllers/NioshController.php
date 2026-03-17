<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\NioshDetalle;
use App\Models\NioshEvaluacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NioshController extends Controller
{
    public function index()
    {
        $nioshEvaluaciones = NioshEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
        ])->latest()->paginate(10);

        return view('niosh.index', compact('nioshEvaluaciones'));
    }

    public function create($evaluacion)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo'
        ])->findOrFail($evaluacion);

        return view('niosh.create', compact('evaluacion'));
    }

    public function store(Request $request, $evaluacion)
    {
        $evaluacion = Evaluacion::with([
            'empresa',
            'sucursal',
            'puesto',
            'trabajador',
            'metodo'
        ])->findOrFail($evaluacion);

        $request->validate([
            'distancia_horizontal' => 'required|numeric|min:1',
            'altura_inicial' => 'required|numeric|min:0',
            'desplazamiento_vertical' => 'required|numeric|min:1',
            'angulo_asimetria' => 'required|numeric|min:0',
            'frecuencia_levantamiento' => 'required|numeric|min:0.01',
            'duracion' => 'required|string|in:corta,moderada,larga',
            'calidad_agarre' => 'required|string|in:bueno,regular,malo',
            'peso_objeto' => 'required|numeric|min:0.01',
        ]);

        $H = (float) $request->distancia_horizontal;
        $V = (float) $request->altura_inicial;
        $D = (float) $request->desplazamiento_vertical;
        $A = (float) $request->angulo_asimetria;
        $F = (float) $request->frecuencia_levantamiento;
        $duracion = $request->duracion;
        $agarre = $request->calidad_agarre;
        $peso = (float) $request->peso_objeto;

        $LC = 23.00;

        $HM = $this->calcularHM($H);
        $VM = $this->calcularVM($V);
        $DM = $this->calcularDM($D);
        $AM = $this->calcularAM($A);
        $FM = $this->calcularFM($F, $duracion, $V);
        $CM = $this->calcularCM($agarre, $V);

        $RWL = round($LC * $HM * $VM * $DM * $AM * $FM * $CM, 2);
        $IL = $RWL > 0 ? round($peso / $RWL, 2) : 0;
        $nivelRiesgo = $this->clasificarRiesgo($IL);

        $niosh = NioshEvaluacion::create([
            'evaluacion_id' => $evaluacion->id,
            'distancia_horizontal' => $H,
            'altura_inicial' => $V,
            'desplazamiento_vertical' => $D,
            'angulo_asimetria' => $A,
            'frecuencia_levantamiento' => $F,
            'duracion' => $duracion,
            'calidad_agarre' => $agarre,
            'peso_objeto' => $peso,
            'constante_carga' => $LC,
            'hm' => $HM,
            'vm' => $VM,
            'dm' => $DM,
            'am' => $AM,
            'fm' => $FM,
            'cm' => $CM,
            'rwl' => $RWL,
            'indice_levantamiento' => $IL,
            'nivel_riesgo' => $nivelRiesgo,
        ]);

        $detalles = [
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Distancia horizontal (H)',
                'valor' => $H . ' cm',
                'resultado' => $HM,
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Altura inicial (V)',
                'valor' => $V . ' cm',
                'resultado' => $VM,
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Desplazamiento vertical (D)',
                'valor' => $D . ' cm',
                'resultado' => $DM,
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Ángulo de asimetría (A)',
                'valor' => $A . '°',
                'resultado' => $AM,
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Frecuencia de levantamiento',
                'valor' => $F . ' lev/min',
                'resultado' => $FM,
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Duración',
                'valor' => ucfirst($duracion),
                'resultado' => ucfirst($duracion),
            ],
            [
                'seccion' => 'Datos de entrada',
                'concepto' => 'Calidad de agarre',
                'valor' => ucfirst($agarre),
                'resultado' => $CM,
            ],
            [
                'seccion' => 'Resultado',
                'concepto' => 'Constante de carga (LC)',
                'valor' => '23 kg',
                'resultado' => $LC,
            ],
            [
                'seccion' => 'Resultado',
                'concepto' => 'Peso del objeto',
                'valor' => $peso . ' kg',
                'resultado' => $peso,
            ],
            [
                'seccion' => 'Resultado',
                'concepto' => 'Límite de peso recomendado (RWL)',
                'valor' => 'LC × HM × VM × DM × AM × FM × CM',
                'resultado' => $RWL . ' kg',
            ],
            [
                'seccion' => 'Resultado',
                'concepto' => 'Índice de levantamiento (IL)',
                'valor' => $peso . ' / ' . $RWL,
                'resultado' => $IL,
            ],
            [
                'seccion' => 'Resultado',
                'concepto' => 'Nivel de riesgo',
                'valor' => 'Clasificación final',
                'resultado' => $nivelRiesgo,
            ],
        ];

        foreach ($detalles as $detalle) {
            NioshDetalle::create([
                'niosh_evaluacion_id' => $niosh->id,
                'seccion' => $detalle['seccion'],
                'concepto' => $detalle['concepto'],
                'valor' => $detalle['valor'],
                'resultado' => (string) $detalle['resultado'],
            ]);
        }

        return redirect()->route('niosh.show', $niosh->id)
            ->with('success', 'Evaluación NIOSH creada correctamente.');
    }

    public function show($id)
    {
        $niosh = NioshEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'detalles'
        ])->findOrFail($id);

        return view('niosh.show', compact('niosh'));
    }

    public function pdf($id)
    {
        $niosh = NioshEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'detalles'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('niosh.pdf', compact('niosh'))->setPaper('a4', 'portrait');

        return $pdf->download('niosh_' . $niosh->id . '.pdf');
    }

    private function calcularHM($H)
    {
        if ($H < 25) {
            $H = 25;
        }

        $hm = 25 / $H;
        return round(min($hm, 1), 3);
    }

    private function calcularVM($V)
    {
        $vm = 1 - (0.003 * abs($V - 75));
        $vm = max($vm, 0);
        return round(min($vm, 1), 3);
    }

    private function calcularDM($D)
    {
        if ($D < 25) {
            $D = 25;
        }

        $dm = 0.82 + (4.5 / $D);
        $dm = max($dm, 0);
        return round(min($dm, 1), 3);
    }

    private function calcularAM($A)
    {
        $am = 1 - (0.0032 * $A);
        $am = max($am, 0);
        return round(min($am, 1), 3);
    }

    private function calcularFM($frecuencia, $duracion, $altura)
    {
        if ($duracion === 'corta') {
            if ($frecuencia <= 0.2) return 1.00;
            if ($frecuencia <= 0.5) return 0.97;
            if ($frecuencia <= 1) return 0.94;
            if ($frecuencia <= 2) return 0.91;
            if ($frecuencia <= 3) return 0.88;
            if ($frecuencia <= 4) return 0.84;
            if ($frecuencia <= 5) return 0.80;
            if ($frecuencia <= 6) return 0.75;
            if ($frecuencia <= 7) return 0.70;
            if ($frecuencia <= 8) return 0.60;
            if ($frecuencia <= 9) return 0.52;
            if ($frecuencia <= 10) return 0.45;
            if ($frecuencia <= 11) return 0.41;
            if ($frecuencia <= 12) return 0.37;
            if ($frecuencia <= 13) return 0.34;
            if ($frecuencia <= 14) return 0.31;
            if ($frecuencia <= 15) return 0.28;
            return 0.25;
        }

        if ($duracion === 'moderada') {
            if ($frecuencia <= 0.2) return 0.95;
            if ($frecuencia <= 0.5) return 0.92;
            if ($frecuencia <= 1) return 0.88;
            if ($frecuencia <= 2) return 0.84;
            if ($frecuencia <= 3) return 0.79;
            if ($frecuencia <= 4) return 0.72;
            if ($frecuencia <= 5) return 0.60;
            if ($frecuencia <= 6) return 0.50;
            if ($frecuencia <= 7) return 0.42;
            if ($frecuencia <= 8) return 0.35;
            if ($frecuencia <= 9) return 0.30;
            if ($frecuencia <= 10) return 0.26;
            if ($frecuencia <= 11) return 0.23;
            if ($frecuencia <= 12) return 0.21;
            if ($frecuencia <= 13) return 0.00;
            return 0.00;
        }

        if ($duracion === 'larga') {
            if ($frecuencia <= 0.2) return 0.85;
            if ($frecuencia <= 0.5) return 0.81;
            if ($frecuencia <= 1) return 0.75;
            if ($frecuencia <= 2) return 0.65;
            if ($frecuencia <= 3) return 0.55;
            if ($frecuencia <= 4) return 0.45;
            if ($frecuencia <= 5) return 0.35;
            if ($frecuencia <= 6) return 0.27;
            if ($frecuencia <= 7) return 0.22;
            if ($frecuencia <= 8) return 0.18;
            if ($frecuencia <= 9) return 0.00;
            return 0.00;
        }

        return 1.00;
    }

    private function calcularCM($agarre, $altura)
    {
        $agarre = strtolower(trim($agarre));

        if ($altura < 75) {
            return match ($agarre) {
                'bueno' => 1.00,
                'regular' => 0.95,
                'malo' => 0.90,
                default => 0.90,
            };
        }

        return match ($agarre) {
            'bueno' => 1.00,
            'regular' => 0.95,
            'malo' => 0.90,
            default => 0.90,
        };
    }

    private function clasificarRiesgo($indice)
    {
        if ($indice <= 1) {
            return 'Bajo';
        }

        if ($indice <= 3) {
            return 'Medio';
        }

        return 'Alto';
    }
}