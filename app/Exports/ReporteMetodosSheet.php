<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteMetodosSheet implements FromArray, WithTitle, WithStyles
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function title(): string
    {
        return 'Por método';
    }

    public function array(): array
    {
        $rows = [
            ['Método', 'Total de evaluaciones']
        ];

        $conteo = $this->evaluaciones
            ->groupBy('metodo')
            ->map(fn ($items) => $items->count());

        foreach ($conteo as $metodo => $total) {
            $rows[] = [$metodo ?: 'N/A', $total];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(25);

        return [];
    }
}