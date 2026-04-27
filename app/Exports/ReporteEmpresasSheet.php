<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteEmpresasSheet implements FromArray, WithTitle, WithStyles
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function title(): string
    {
        return 'Por empresa';
    }

    public function array(): array
    {
        $rows = [
            ['Empresa', 'Total evaluaciones', 'Riesgos altos o muy altos']
        ];

        $grupos = $this->evaluaciones->groupBy('empresa_nombre');

        foreach ($grupos as $empresa => $items) {
            $altos = $items->filter(function ($e) {
                $riesgo = strtolower($e['nivel_riesgo'] ?? '');
                return str_contains($riesgo, 'alto') || str_contains($riesgo, 'muy alto');
            })->count();

            $rows[] = [
                $empresa ?: 'N/A',
                $items->count(),
                $altos
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);

        return [];
    }
}