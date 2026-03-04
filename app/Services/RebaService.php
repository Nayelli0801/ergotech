<?php

namespace App\Services;

class RebaService
{
    // =========================
    // TABLA GRUPO A (BASE)
    // =========================
    private function tablaGrupoA()
    {
        return [
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                2 => [1 => 1, 2 => 2, 3 => 3, 4 => 4],
                3 => [1 => 3, 2 => 3, 3 => 5, 4 => 6],
            ],
            2 => [
                1 => [1 => 2, 2 => 3, 3 => 4, 4 => 5],
                2 => [1 => 3, 2 => 4, 3 => 5, 4 => 6],
                3 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
            ],
            3 => [
                1 => [1 => 2, 2 => 4, 3 => 5, 4 => 6],
                2 => [1 => 4, 2 => 5, 3 => 6, 4 => 7],
                3 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
            ],
            4 => [
                1 => [1 => 3, 2 => 5, 3 => 6, 4 => 7],
                2 => [1 => 5, 2 => 6, 3 => 7, 4 => 8],
                3 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
            ],
            5 => [
                1 => [1 => 4, 2 => 6, 3 => 7, 4 => 8],
                2 => [1 => 6, 2 => 7, 3 => 8, 4 => 9],
                3 => [1 => 7, 2 => 8, 3 => 9, 4 => 9],
            ],
        ];
    }

    // =========================
    // TABLA GRUPO B (BASE)
    // =========================
    private function tablaGrupoB()
    {
        return [
            1 => [
                1 => [1 => 1, 2 => 2, 3 => 2],
                2 => [1 => 1, 2 => 2, 3 => 3],
            ],
            2 => [
                1 => [1 => 1, 2 => 2, 3 => 3],
                2 => [1 => 2, 2 => 3, 3 => 4],
            ],
            3 => [
                1 => [1 => 3, 2 => 4, 3 => 5],
                2 => [1 => 4, 2 => 5, 3 => 5],
            ],
            4 => [
                1 => [1 => 4, 2 => 5, 3 => 5],
                2 => [1 => 5, 2 => 6, 3 => 7],
            ],
            5 => [
                1 => [1 => 6, 2 => 7, 3 => 8],
                2 => [1 => 7, 2 => 8, 3 => 8],
            ],
            6 => [
                1 => [1 => 7, 2 => 8, 3 => 8],
                2 => [1 => 8, 2 => 9, 3 => 9],
            ],
        ];
    }

    // =========================
    // TABLA GRUPO C
    // =========================
    private function tablaGrupoC()
    {
        return [
            1 => [1,1,1,2,3,3,4,5,6,7,7,7],
            2 => [1,2,2,3,4,4,5,6,6,7,7,8],
            3 => [2,3,3,3,4,5,6,7,7,8,8,8],
            4 => [3,4,4,4,5,6,7,8,8,9,9,9],
            5 => [4,4,4,5,6,7,8,8,9,9,9,9],
            6 => [6,6,6,7,8,8,9,9,10,10,10,10],
            7 => [7,7,7,8,9,9,9,10,10,11,11,11],
            8 => [8,8,8,9,10,10,10,10,11,11,11,11],
            9 => [9,9,9,10,10,10,11,11,11,12,12,12],
            10 => [10,10,10,11,11,11,11,12,12,12,12,12],
            11 => [11,11,11,11,12,12,12,12,12,12,12,12],
            12 => [12,12,12,12,12,12,12,12,12,12,12,12],
        ];
    }

    // =========================
    // UTIL: LIMITAR
    // =========================
    private function clamp($value, $min, $max)
    {
        return max($min, min($max, (int)$value));
    }

    // =========================
    // GRUPO A PROFESIONAL
    // (postura + ajustes + carga)
    // =========================
    public function calcularGrupoAPro($tronco, $cuello, $piernas, $troncoAjuste = false, $cuelloAjuste = false, $carga = 0)
    {
        $tronco = $this->clamp($tronco + ($troncoAjuste ? 1 : 0), 1, 5);
        $cuello = $this->clamp($cuello + ($cuelloAjuste ? 1 : 0), 1, 3);
        $piernas = $this->clamp($piernas, 1, 4);

        $tabla = $this->tablaGrupoA();
        $base = $tabla[$tronco][$cuello][$piernas] ?? 0;

        // carga (0-2 usualmente). Suma directa.
        $carga = $this->clamp($carga, 0, 3);

        return $this->clamp($base + $carga, 1, 12);
    }

    // =========================
    // GRUPO B PROFESIONAL
    // (postura + ajuste muñeca + agarre)
    // =========================
    public function calcularGrupoBPro($brazo, $antebrazo, $muneca, $munecaAjuste = false, $agarre = 0)
    {
        $brazo = $this->clamp($brazo, 1, 6);
        $antebrazo = $this->clamp($antebrazo, 1, 2);
        $muneca = $this->clamp($muneca + ($munecaAjuste ? 1 : 0), 1, 3);

        $tabla = $this->tablaGrupoB();
        $base = $tabla[$brazo][$antebrazo][$muneca] ?? 0;

        // agarre/acoplamiento (0-2 típico)
        $agarre = $this->clamp($agarre, 0, 3);

        return $this->clamp($base + $agarre, 1, 12);
    }

    public function calcularGrupoC($grupoA, $grupoB)
    {
        $grupoA = $this->clamp($grupoA, 1, 12);
        $grupoB = $this->clamp($grupoB, 1, 12);

        $tabla = $this->tablaGrupoC();
        return $tabla[$grupoA][$grupoB - 1] ?? 0;
    }

    public function calcularFinal($grupoC, $actividad = 0)
    {
        $actividad = $this->clamp($actividad, 0, 3);
        return $grupoC + $actividad;
    }

    public function nivelRiesgo($puntaje)
    {
        if ($puntaje <= 1) return 'Riesgo inapreciable';
        if ($puntaje <= 3) return 'Riesgo bajo';
        if ($puntaje <= 7) return 'Riesgo medio';
        if ($puntaje <= 10) return 'Riesgo alto';
        return 'Riesgo muy alto';
    }

    public function recomendacion($nivel)
    {
        switch ($nivel) {
            case 'Riesgo inapreciable': return 'No se requieren acciones.';
            case 'Riesgo bajo': return 'No se requiere acción inmediata.';
            case 'Riesgo medio': return 'Se recomienda analizar mejoras.';
            case 'Riesgo alto': return 'Se requiere intervención pronta.';
            case 'Riesgo muy alto': return 'Intervención inmediata necesaria.';
            default: return '';
        }
    }
}