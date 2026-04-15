<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $logs = Log::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('configuracion.index', [
            'logs' => $logs
        ]);
    }
}