<?php

namespace App\Http\Controllers;

use App\Models\Atraccion;
use App\Models\Sede;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(Request $request): View
    {
        $sedeId = $request->integer('sede_id');

        $sedes = Sede::orderBy('nombre')->get();

        if (!$sedeId && $sedes->isNotEmpty()) {
            $sedeId = $sedes->first()->id;
        }

        $atracciones = Atraccion::query()
            ->with('sede')
            ->when($sedeId, fn ($query) => $query->where('sede_id', $sedeId))
            ->orderBy('nombre')
            ->get();

        return view('public.home', [
            'sedes' => $sedes,
            'selectedSedeId' => $sedeId,
            'atracciones' => $atracciones,
        ]);
    }

    public function showAtraccion(Atraccion $atraccion): View
    {
        $atraccion->load('sede');

        return view('public.atracciones.show', [
            'atraccion' => $atraccion,
        ]);
    }

    public function plans(): View
    {
        $planes = Tarifa::query()
            ->with('tipoTicket')
            ->orderBy('precio')
            ->get();

        return view('public.plans', [
            'planes' => $planes,
        ]);
    }
}
