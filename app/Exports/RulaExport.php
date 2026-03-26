<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RulaExport implements FromArray, ShouldAutoSize, WithStyles, WithEvents, WithTitle, WithCharts
{
    public function __construct(private array $data)
    {
    }

    public function title(): string
    {
        return 'RULA';
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = ['REPORTE DE EVALUACIÓN RULA'];
        $rows[] = [''];

        $rows[] = ['Empresa', $this->data['general']['empresa']];
        $rows[] = ['Sucursal', $this->data['general']['sucursal']];
        $rows[] = ['Puesto', $this->data['general']['puesto']];
        $rows[] = ['Trabajador', $this->data['general']['trabajador']];
        $rows[] = ['Fecha', $this->data['general']['fecha']];
        $rows[] = ['Evaluador', $this->data['general']['evaluador']];
        $rows[] = ['Área evaluada', $this->data['general']['area_evaluada']];
        $rows[] = ['Actividad', $this->data['general']['actividad']];
        $rows[] = ['Nivel de riesgo', $this->data['nivel_riesgo']];
        $rows[] = ['Acción requerida', $this->data['accion_requerida']];

        $rows[] = [''];
        $rows[] = ['PUNTUACIONES'];
        $rows[] = ['Indicador', 'Valor'];

        foreach ($this->data['scores'] as $score) {
            $rows[] = [$score['label'], $score['value']];
        }

        $rows[] = [''];
        $rows[] = ['DETALLE DE LA EVALUACIÓN'];
        $rows[] = ['Sección', 'Concepto', 'Valor', 'Puntaje'];

        foreach ($this->data['detalles'] as $detalle) {
            $rows[] = [
                $detalle['seccion'],
                $detalle['concepto'],
                $detalle['valor'],
                $detalle['puntaje'],
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            14 => ['font' => ['bold' => true]],
            15 => ['font' => ['bold' => true]],
            22 => ['font' => ['bold' => true]],
            23 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:D1');

                $sheet->getStyle('A14:B15')->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('DBEAFE');

                $sheet->getStyle('A22:D23')->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E2E8F0');

                $sheet->getColumnDimension('A')->setWidth(22);
                $sheet->getColumnDimension('B')->setWidth(28);
                $sheet->getColumnDimension('C')->setWidth(45);
                $sheet->getColumnDimension('D')->setWidth(14);
            },
        ];
    }

    public function charts(): array
    {
        $label = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'RULA!$B$15', null, 1),
        ];

        $categories = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'RULA!$A$16:$A$20', null, 5),
        ];

        $values = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'RULA!$B$16:$B$20', null, 5),
        ];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($values) - 1),
            $label,
            $categories,
            $values
        );

        $plotArea = new PlotArea(null, [$series]);
        $legend = new Legend(Legend::POSITION_RIGHT, null, false);
        $title = new Title('Puntuaciones RULA');

        $chart = new Chart('rula_chart', $title, $legend, $plotArea);
        $chart->setTopLeftPosition('F3');
        $chart->setBottomRightPosition('M18');

        return [$chart];
    }
}