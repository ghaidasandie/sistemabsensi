<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Ranking terbaik (Top 5)
    $topRanking = DB::table('absensis')
        ->join('siswas', 'absensis.nisn', '=', 'siswas.nisn') // Bergabung dengan tabel 'siswas'
        ->select('absensis.nisn', 'siswas.nama', DB::raw('SUM(
            CASE
                WHEN absensis.status = "h" THEN 10
                WHEN absensis.status = "i" THEN 7
                WHEN absensis.status = "s" THEN 5
                ELSE 0
            END
        ) as total_points'))
        ->groupBy('absensis.nisn', 'siswas.nama')
        ->orderByDesc('total_points')
        ->take(5)
        ->get();

    // Ranking terburuk (Bottom 5)
    $bottomRanking = DB::table('absensis')
        ->join('siswas', 'absensis.nisn', '=', 'siswas.nisn') // Bergabung dengan tabel 'siswas'
        ->select('absensis.nisn', 'siswas.nama', DB::raw('SUM(
            CASE
                WHEN absensis.status = "h" THEN 10
                WHEN absensis.status = "i" THEN 7
                WHEN absensis.status = "s" THEN 5
                ELSE 0
            END
        ) as total_points'))
        ->groupBy('absensis.nisn', 'siswas.nama')
        ->orderBy('total_points') // Urutan terendah
        ->take(5)
        ->get();

    return view('dashboard', compact('topRanking', 'bottomRanking'));
}

}
