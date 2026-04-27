<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportePuestosCriticosSheet implements FromArray, WithTitle, WithStyles
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function title(): string
    {
        return 'Puestos críticos';
    }

    public function array(): array
    {
        $rows = [
            ['Puesto', 'Total evaluaciones', 'Riesgos altos o muy altos', 'Recomendación general']
        ];

        $grupos = $this->evaluaciones->groupBy('puesto_nombre');

        foreach ($grupos as $puesto => $items) {
            $altos = $items->filter(function ($e) {
                $riesgo = strtolower($e['nivel_riesgo'] ?? '');
                return str_contains($riesgo, 'alto') || str_contains($riesgo, 'muy alto');
            })->count();

            $recomendacion = $altos > 0
                ? 'Revisar condiciones ergonómicas del puesto y priorizar acciones correctivas.'
                : 'Mantener seguimiento preventivo.';

            $rows[] = [
                $puesto ?: 'N/A',
                $items->count(),
                $altos,
                $recomendacion
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(60);

        return [];
    }
}