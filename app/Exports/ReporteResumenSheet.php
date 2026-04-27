<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteResumenSheet implements FromArray, WithTitle, WithStyles
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function title(): string
    {
        return 'Resumen';
    }

    public function array(): array
    {
        $total = $this->evaluaciones->count();

        $altos = $this->evaluaciones->filter(function ($e) {
            $riesgo = strtolower($e['nivel_riesgo'] ?? '');
            return str_contains($riesgo, 'alto') || str_contains($riesgo, 'muy alto');
        })->count();

        $empresas = $this->evaluaciones->pluck('empresa_nombre')->unique()->count();
        $puestos = $this->evaluaciones->pluck('puesto_nombre')->unique()->count();
        $metodos = $this->evaluaciones->pluck('metodo')->unique()->count();

        return [
            ['REPORTE ERGONÓMICO GENERAL - ERGOTECH'],
            [''],
            ['Indicador', 'Valor'],
            ['Total de evaluaciones', $total],
            ['Empresas evaluadas', $empresas],
            ['Puestos evaluados', $puestos],
            ['Métodos aplicados', $metodos],
            ['Evaluaciones con riesgo alto o muy alto', $altos],
            [''],
            ['Objetivo del reporte'],
            ['Concentrar y analizar los resultados ergonómicos registrados en el sistema para identificar áreas, puestos y métodos con mayor nivel de riesgo.'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A3:B3')->getFont()->setBold(true);
        $sheet->getStyle('A10')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(45);
        $sheet->getColumnDimension('B')->setWidth(25);

        return [];
    }
}