<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
     {
    $user = auth()->user();

    if ($user->rol->nombre == 'admin') {
        return view('dashboard.admin');
    }

    if ($user->rol->nombre == 'evaluador') {
        return view('dashboard.evaluador');
    }

    return view('dashboard.visitante');
     }
}

