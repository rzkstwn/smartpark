<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total kendaraan parkir
        $totalKendaraan = Parkir::where('status', 'masuk')->count();

        // Total pendapatan
        $totalPendapatan = Parkir::where('status', 'keluar')->sum('biaya');

        // Statistik kendaraan
        $motor = Parkir::whereHas('kendaraan', function ($q) {
    $q->where('jenis_kendaraan', 'motor');
})->count();

$mobil = Parkir::whereHas('kendaraan', function ($q) {
    $q->where('jenis_kendaraan', 'mobil');
})->count();

        // Pendapatan per bulan
        $pendapatan = Parkir::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(biaya) as total')
        )
        ->groupBy('bulan')
        ->get();

        return view('dashboard', compact(
            'totalKendaraan',
            'totalPendapatan',
            'motor',
            'mobil',
            'pendapatan'
        ));
    }

    public function filter(Request $request)
    {
        // Validasi input tanggal
        $start = Carbon::parse($request->start)->startOfDay();
        $end = Carbon::parse($request->end)->endOfDay();

        // Data filtered
        $data = Parkir::whereBetween('created_at', [$start, $end])->get();

        // Tetap hitung statistik agar view tidak error
        $totalKendaraan = $data->where('status', 'masuk')->count();
        $totalPendapatan = $data->where('status', 'keluar')->sum('biaya');
        $motor = $data->where('jenis_kendaraan', 'motor')->count();
        $mobil = $data->where('jenis_kendaraan', 'mobil')->count();

        // Pendapatan per bulan untuk periode filter
        $pendapatan = $data
            ->groupBy(function($d) { return Carbon::parse($d->created_at)->format('m'); })
            ->map(function($row) { return $row->sum('biaya'); });

        return view('dashboard', compact(
            'totalKendaraan',
            'totalPendapatan',
            'motor',
            'mobil',
            'pendapatan',
            'data'
        ));
    }
}