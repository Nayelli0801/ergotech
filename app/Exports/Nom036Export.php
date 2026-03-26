<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Nom036Export implements FromArray, ShouldAutoSize, WithStyles, WithEvents, WithTitle
{
    public function __construct(private array $data)
    {
    }

    public function title(): string
    {
        return 'NOM-036';
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = ['REPORTE DE EVALUACIÓN NOM-036'];
        $rows[] = ['ErgoTech - Sistema de evaluación ergonómica'];
        $rows[] = [''];

        $rows[] = ['DATOS GENERALES', '', '', ''];
        $rows[] = ['Campo', 'Valor', '', ''];

        foreach ($this->data['general'] as $label => $value) {
            $rows[] = [ucfirst(str_replace('_', ' ', $label)), (string) $value, '', ''];
        }

        $rows[] = [''];
        $rows[] = ['RESULTADO', '', '', ''];
        $rows[] = ['Campo', 'Valor', '', ''];
        $rows[] = ['Nivel de riesgo', (string) $this->data['nivel_riesgo'], '', ''];
        $rows[] = ['Acción requerida', (string) $this->data['accion_requerida'], '', ''];

        $rows[] = [''];
        $rows[] = ['RESUMEN', '', '', ''];
        $rows[] = ['Indicador', 'Valor', '', ''];

        foreach ($this->data['scores'] as $score) {
            $rows[] = [(string) $score['label'], (string) $score['value'], '', ''];
        }

        $rows[] = [''];
        $rows[] = ['DETALLE DE LA EVALUACIÓN', '', '', ''];
        $rows[] = ['Sección', 'Concepto', 'Valor', 'Resultado'];

        foreach ($this->data['detalles'] as $detalle) {
            $rows[] = [
                (string) $detalle['seccion'],
                (string) $detalle['concepto'],
                (string) $detalle['valor'],
                (string) $detalle['puntaje'],
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 18],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            2 => [
                'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            4 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']]],
            5 => ['font' => ['bold' => true]],
            15 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']]],
            16 => ['font' => ['bold' => true]],
            21 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']]],
            22 => ['font' => ['bold' => true]],
            27 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']]],
            28 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Títulos
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');

                // Secciones
                foreach (['A4:D4', 'A15:D15', 'A21:D21', 'A27:D27'] as $range) {
                    $sheet->getStyle($range)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('1F4E78');

                    $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                }

                // Encabezados
                foreach (['A5:B5', 'A16:B16', 'A22:B22', 'A28:D28'] as $range) {
                    $sheet->getStyle($range)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('D9EAF7');

                    $sheet->getStyle($range)->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                }

                // Bordes tablas
                $sheet->getStyle('A5:B13')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A16:B18')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A22:B24')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A28:D{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Alineación y ajuste de texto
                $sheet->getStyle("A1:D{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A1:D{$lastRow}")->getAlignment()->setWrapText(true);

                // Columnas
                $sheet->getColumnDimension('A')->setWidth(22);
                $sheet->getColumnDimension('B')->setWidth(34);
                $sheet->getColumnDimension('C')->setWidth(55);
                $sheet->getColumnDimension('D')->setWidth(24);

                // Alturas
                $sheet->getRowDimension(1)->setRowHeight(28);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Congelar solo encabezado superior
                $sheet->freezePane('A4');

                // Filtro solo para detalle
                $sheet->setAutoFilter("A28:D{$lastRow}");
            },
        ];
    }
}