<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportesErgonomicosExport implements WithMultipleSheets
{
    protected Collection $evaluaciones;

    public function __construct(Collection $evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;
    }

    public function sheets(): array
    {
        return [
            new ReporteResumenSheet($this->evaluaciones),
            new ReporteEvaluacionesSheet($this->evaluaciones),
            new ReporteMetodosSheet($this->evaluaciones),
            new ReporteEmpresasSheet($this->evaluaciones),
            new ReportePuestosCriticosSheet($this->evaluaciones),
        ];
    }
}