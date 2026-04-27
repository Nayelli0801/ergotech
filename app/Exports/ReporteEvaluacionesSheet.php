<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteEvaluacionesSheet implements FromArray, WithTitle, WithStyles
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function title(): string
    {
        return 'Evaluaciones';
    }

    public function array(): array
    {
        $rows = [
            [
                'ID',
                'Empresa',
                'Puesto',
                'Trabajador',
                'Método',
                'Fecha',
                'Área',
                'Actividad',
                'Resultado',
                'Nivel de riesgo',
                'Observaciones',
            ]
        ];

        foreach ($this->evaluaciones as $e) {
            $rows[] = [
                $e['id'] ?? '',
                $e['empresa_nombre'] ?? '',
                $e['puesto_nombre'] ?? '',
                $e['trabajador_nombre'] ?? '',
                $e['metodo'] ?? '',
                $e['fecha'] ?? '',
                $e['area'] ?? '',
                $e['actividad'] ?? '',
                $e['resultado'] ?? '',
                $e['nivel_riesgo'] ?? '',
                $e['observaciones'] ?? '',
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}