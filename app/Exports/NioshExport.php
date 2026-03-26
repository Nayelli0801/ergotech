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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NioshExport implements FromArray, ShouldAutoSize, WithStyles, WithEvents, WithTitle, WithCharts
{
    public function __construct(private array $data)
    {
    }

    public function title(): string
    {
        return 'NIOSH';
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = ['REPORTE DE EVALUACIÓN NIOSH'];
        $rows[] = [''];

        foreach ($this->data['general'] as $label => $value) {
            $rows[] = [ucfirst(str_replace('_', ' ', $label)), $value];
        }

        $rows[] = ['Nivel de riesgo', $this->data['nivel_riesgo']];
        $rows[] = ['Resumen', $this->data['accion_requerida']];

        $rows[] = [''];
        $rows[] = ['FACTORES Y RESULTADOS'];
        $rows[] = ['Indicador', 'Valor'];

        foreach ($this->data['scores'] as $score) {
            $rows[] = [$score['label'], $score['value']];
        }

        $rows[] = [''];
        $rows[] = ['DETALLE'];
        $rows[] = ['Sección', 'Concepto', 'Valor', 'Resultado'];

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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:D1');
                $sheet->getColumnDimension('A')->setWidth(24);
                $sheet->getColumnDimension('B')->setWidth(28);
                $sheet->getColumnDimension('C')->setWidth(40);
                $sheet->getColumnDimension('D')->setWidth(18);
            },
        ];
    }

    public function charts(): array
    {
        $label = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'NIOSH!$B$14', null, 1),
        ];

        $categories = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'NIOSH!$A$15:$A$22', null, 8),
        ];

        $values = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'NIOSH!$B$15:$B$22', null, 8),
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
        $title = new Title('Factores NIOSH');

        $chart = new Chart('niosh_chart', $title, $legend, $plotArea);
        $chart->setTopLeftPosition('F3');
        $chart->setBottomRightPosition('N20');

        return [$chart];
    }
}