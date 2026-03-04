<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RebaService;

class RebaController extends Controller
{
    public function calcular(Request $request)
    {
        $request->validate([
            'tronco' => 'required|integer|min:1|max:5',
            'cuello' => 'required|integer|min:1|max:3',
            'piernas' => 'required|integer|min:1|max:4',
            'carga' => 'nullable|integer|min:0|max:3',

            'brazo' => 'required|integer|min:1|max:6',
            'antebrazo' => 'required|integer|min:1|max:2',
            'muneca' => 'required|integer|min:1|max:3',

            'tronco_ajuste' => 'nullable|boolean',
            'cuello_ajuste' => 'nullable|boolean',
            'muneca_ajuste' => 'nullable|boolean',

            'agarre' => 'nullable|integer|min:0|max:3',
            'actividad' => 'nullable|integer|min:0|max:3',
        ]);

        $reba = new RebaService();

        // ✅ MÉTODOS CORRECTOS (PRO)
        $grupoA = $reba->calcularGrupoAPro(
            $request->tronco,
            $request->cuello,
            $request->piernas,
            (bool)($request->tronco_ajuste ?? false),
            (bool)($request->cuello_ajuste ?? false),
            (int)($request->carga ?? 0)
        );

        $grupoB = $reba->calcularGrupoBPro(
            $request->brazo,
            $request->antebrazo,
            $request->muneca,
            (bool)($request->muneca_ajuste ?? false),
            (int)($request->agarre ?? 0)
        );

        $grupoC = $reba->calcularGrupoC($grupoA, $grupoB);

        $puntajeFinal = $reba->calcularFinal($grupoC, (int)($request->actividad ?? 0));
        $nivel = $reba->nivelRiesgo($puntajeFinal);

        return response()->json([
            'grupoA' => $grupoA,
            'grupoB' => $grupoB,
            'grupoC' => $grupoC,
            'puntaje' => $puntajeFinal,
            'nivel' => $nivel,
        ]);
    }
}