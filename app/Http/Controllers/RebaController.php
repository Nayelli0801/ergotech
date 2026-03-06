<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\Metodo;
use App\Models\Puesto;
use App\Models\RebaDetalle;
use App\Models\RebaEvaluacion;
use App\Models\Sucursal;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RebaController extends Controller
{
    public function index()
    {
        $rebas = RebaEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador'
        ])->latest()->paginate(10);

        return view('reba.index', compact('rebas'));
    }

    public function create(Request $request)
{
    $datosBase = [
        'empresa_id' => $request->empresa_id,
        'sucursal_id' => $request->sucursal_id,
        'puesto_id' => $request->puesto_id,
        'trabajador_id' => $request->trabajador_id,
        'fecha' => $request->fecha,
        'observaciones' => $request->observaciones,
    ];

    return view('reba.create', compact('datosBase'));
}

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'puesto_id' => 'required|exists:puestos,id',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',

            'cuello' => 'required|integer|min:1',
            'tronco' => 'required|integer|min:1',
            'piernas' => 'required|integer|min:1',
            'brazo' => 'required|integer|min:1',
            'antebrazo' => 'required|integer|min:1',
            'muneca' => 'required|integer|min:1',
            'carga' => 'required|integer|min:0',
            'tipo_agarre' => 'required|integer|min:0',
            'actividad' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $metodo = Metodo::whereRaw('LOWER(nombre) = ?', ['reba'])->first();

            if (!$metodo) {
                return back()->withInput()->with('error', 'No existe el método REBA en la tabla metodos.');
            }

            $evaluacion = Evaluacion::create([
                'empresa_id' => $request->empresa_id,
                'sucursal_id' => $request->sucursal_id,
                'puesto_id' => $request->puesto_id,
                'trabajador_id' => $request->trabajador_id,
                'metodo_id' => $metodo->id,
                'user_id' => Auth::id(),
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones,
            ]);

            $resultado = $this->calcularReba(
                $request->cuello,
                $request->tronco,
                $request->piernas,
                $request->brazo,
                $request->antebrazo,
                $request->muneca,
                $request->carga,
                $request->tipo_agarre,
                $request->actividad
            );

            $reba = RebaEvaluacion::create([
                'evaluacion_id' => $evaluacion->id,
                'cuello' => $request->cuello,
                'tronco' => $request->tronco,
                'piernas' => $request->piernas,
                'brazo' => $request->brazo,
                'antebrazo' => $request->antebrazo,
                'muneca' => $request->muneca,
                'carga' => $request->carga,
                'tipo_agarre' => $request->tipo_agarre,
                'actividad' => $request->actividad,
                'puntuacion_a' => $resultado['puntuacion_a'],
                'puntuacion_b' => $resultado['puntuacion_b'],
                'puntuacion_c' => $resultado['puntuacion_c'],
                'puntuacion_final' => $resultado['puntuacion_final'],
                'nivel_riesgo' => $resultado['nivel_riesgo'],
                'accion_requerida' => $resultado['accion_requerida'],
            ]);

            $detalles = [
                [
                    'seccion' => 'A',
                    'concepto' => 'cuello',
                    'valor' => $this->textoCuello($request->cuello),
                    'puntaje' => $request->cuello,
                ],
                [
                    'seccion' => 'A',
                    'concepto' => 'tronco',
                    'valor' => $this->textoTronco($request->tronco),
                    'puntaje' => $request->tronco,
                ],
                [
                    'seccion' => 'A',
                    'concepto' => 'piernas',
                    'valor' => $this->textoPiernas($request->piernas),
                    'puntaje' => $request->piernas,
                ],
                [
                    'seccion' => 'A',
                    'concepto' => 'carga',
                    'valor' => $this->textoCarga($request->carga),
                    'puntaje' => $request->carga,
                ],
                [
                    'seccion' => 'B',
                    'concepto' => 'brazo',
                    'valor' => $this->textoBrazo($request->brazo),
                    'puntaje' => $request->brazo,
                ],
                [
                    'seccion' => 'B',
                    'concepto' => 'antebrazo',
                    'valor' => $this->textoAntebrazo($request->antebrazo),
                    'puntaje' => $request->antebrazo,
                ],
                [
                    'seccion' => 'B',
                    'concepto' => 'muneca',
                    'valor' => $this->textoMuneca($request->muneca),
                    'puntaje' => $request->muneca,
                ],
                [
                    'seccion' => 'B',
                    'concepto' => 'tipo_agarre',
                    'valor' => $this->textoAgarre($request->tipo_agarre),
                    'puntaje' => $request->tipo_agarre,
                ],
                [
                    'seccion' => 'C',
                    'concepto' => 'actividad',
                    'valor' => $this->textoActividad($request->actividad),
                    'puntaje' => $request->actividad,
                ],
            ];

            foreach ($detalles as $detalle) {
                RebaDetalle::create([
                    'reba_evaluacion_id' => $reba->id,
                    'seccion' => $detalle['seccion'],
                    'concepto' => $detalle['concepto'],
                    'valor' => $detalle['valor'],
                    'puntaje' => $detalle['puntaje'],
                ]);
            }

            DB::commit();

            return redirect()->route('reba.show', $reba->id)
                ->with('success', 'Evaluación REBA guardada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $reba = RebaEvaluacion::with([
            'evaluacion.empresa',
            'evaluacion.sucursal',
            'evaluacion.puesto',
            'evaluacion.trabajador',
            'detalles'
        ])->findOrFail($id);

        return view('reba.show', compact('reba'));
    }

    private function calcularReba($cuello, $tronco, $piernas, $brazo, $antebrazo, $muneca, $carga, $tipoAgarre, $actividad)
    {
        // Base funcional.
        // Esto te deja el sistema andando.
        // Después puedes cambiar esta parte por la matriz oficial exacta de tu documento.

        $puntuacionA = $cuello + $tronco + $piernas + $carga;
        $puntuacionB = $brazo + $antebrazo + $muneca + $tipoAgarre;
        $puntuacionC = $puntuacionA + $puntuacionB;
        $puntuacionFinal = $puntuacionC + $actividad;

        if ($puntuacionFinal <= 3) {
            $nivel = 'Riesgo bajo';
            $accion = 'No es necesaria acción inmediata';
        } elseif ($puntuacionFinal <= 7) {
            $nivel = 'Riesgo medio';
            $accion = 'Puede requerirse acción';
        } elseif ($puntuacionFinal <= 10) {
            $nivel = 'Riesgo alto';
            $accion = 'Es necesaria la actuación pronto';
        } else {
            $nivel = 'Riesgo muy alto';
            $accion = 'Es necesaria la actuación inmediata';
        }

        return [
            'puntuacion_a' => $puntuacionA,
            'puntuacion_b' => $puntuacionB,
            'puntuacion_c' => $puntuacionC,
            'puntuacion_final' => $puntuacionFinal,
            'nivel_riesgo' => $nivel,
            'accion_requerida' => $accion,
        ];
    }

    private function textoCuello($valor)
    {
        return match((int)$valor) {
            1 => 'Cuello neutral',
            2 => 'Cuello flexionado o extendido',
            3 => 'Cuello flexionado/extendido con giro o inclinación',
            default => 'No definido',
        };
    }

    private function textoTronco($valor)
    {
        return match((int)$valor) {
            1 => 'Tronco recto',
            2 => 'Tronco con ligera flexión',
            3 => 'Tronco flexionado',
            4 => 'Tronco muy flexionado o torcido',
            5 => 'Tronco severamente comprometido',
            default => 'No definido',
        };
    }

    private function textoPiernas($valor)
    {
        return match((int)$valor) {
            1 => 'Apoyo bilateral estable',
            2 => 'Apoyo inestable o una pierna flexionada',
            3 => 'Piernas muy flexionadas',
            4 => 'Postura inestable severa',
            default => 'No definido',
        };
    }

    private function textoCarga($valor)
    {
        return match((int)$valor) {
            0 => 'Sin carga apreciable',
            1 => 'Carga ligera',
            2 => 'Carga moderada',
            3 => 'Carga alta',
            default => 'No definido',
        };
    }

    private function textoBrazo($valor)
    {
        return match((int)$valor) {
            1 => 'Brazo en posición baja',
            2 => 'Brazo ligeramente elevado',
            3 => 'Brazo elevado',
            4 => 'Brazo muy elevado',
            5 => 'Brazo en postura crítica',
            default => 'No definido',
        };
    }

    private function textoAntebrazo($valor)
    {
        return match((int)$valor) {
            1 => 'Antebrazo entre 60° y 100°',
            2 => 'Antebrazo fuera del rango ideal',
            3 => 'Antebrazo en postura comprometida',
            default => 'No definido',
        };
    }

    private function textoMuneca($valor)
    {
        return match((int)$valor) {
            1 => 'Muñeca neutral',
            2 => 'Muñeca flexionada o extendida',
            3 => 'Muñeca desviada o girada',
            4 => 'Muñeca severamente comprometida',
            default => 'No definido',
        };
    }

    private function textoAgarre($valor)
    {
        return match((int)$valor) {
            0 => 'Agarre bueno',
            1 => 'Agarre regular',
            2 => 'Agarre malo',
            3 => 'Agarre muy malo',
            default => 'No definido',
        };
    }

    private function textoActividad($valor)
    {
        return match((int)$valor) {
            0 => 'Actividad sin repetición importante',
            1 => 'Actividad repetitiva o estática leve',
            2 => 'Actividad repetitiva o estática moderada',
            3 => 'Actividad repetitiva o estática intensa',
            default => 'No definido',
        };
    }
}