<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario.
     */
    public function show(): View
    {
        return view('dashboard');
    }
}
