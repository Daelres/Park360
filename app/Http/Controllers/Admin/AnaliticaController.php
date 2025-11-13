<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atraccion;
use App\Models\Incidente;
use App\Models\Sede;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AnaliticaController extends Controller
{
    public function index(): View
    {
        // Fechas de referencia
        $hoy = Carbon::now();
        $hace30 = (clone $hoy)->subDays(30);
        $hace90 = (clone $hoy)->subDays(90);

        // KPIs generales
        $kpis = [
            'usuariosTotales' => User::count(),
            'usuariosActivos30d' => User::whereNotNull('ultimo_login')->where('ultimo_login', '>=', $hace30)->count(),
            'sedesTotales' => Sede::count(),
            'atraccionesTotales' => Atraccion::count(),
            'incidentesTotales90d' => Incidente::where('inicio_at', '>=', $hace90)->count(),
        ];

        // Incidentes por tipo (últimos 90 días)
        $incidentesPorTipo = Incidente::selectRaw('tipo, count(*) as total')
            ->where('inicio_at', '>=', $hace90)
            ->groupBy('tipo')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'tipo');

        // Incidentes por severidad (últimos 90 días)
        $incidentesPorSeveridad = Incidente::selectRaw('coalesce(severidad, "N/D") as severidad, count(*) as total')
            ->where('inicio_at', '>=', $hace90)
            ->groupBy('severidad')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'severidad');

        // Incidentes por mes (últimos 6 meses)
        $hace6Meses = (clone $hoy)->startOfMonth()->subMonths(5);
        $incidentesPorMes = Incidente::selectRaw('DATE_FORMAT(inicio_at, "%Y-%m") as ym, count(*) as total')
            ->where('inicio_at', '>=', $hace6Meses)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->pluck('total', 'ym');

        // Atracciones por sede
        $atraccionesPorSede = Sede::withCount('atracciones')
            ->orderByDesc('atracciones_count')
            ->take(10)
            ->get()
            ->pluck('atracciones_count', 'nombre');

        return view('admin.analitica.index', [
            'kpis' => $kpis,
            'incidentesPorTipo' => $incidentesPorTipo,
            'incidentesPorSeveridad' => $incidentesPorSeveridad,
            'incidentesPorMes' => $incidentesPorMes,
            'atraccionesPorSede' => $atraccionesPorSede,
            'hace90' => $hace90,
        ]);
    }
}
