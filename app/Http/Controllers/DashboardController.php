<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $rankingQuery = DB::table('absensis')
            ->join('siswas', 'absensis.nisn', '=', 'siswas.nisn')
            ->select(
                'absensis.nisn',
                'siswas.nama',
                DB::raw('SUM(
            CASE
                WHEN absensis.status = "h" THEN 10
                WHEN absensis.status = "i" THEN 2
                WHEN absensis.status = "s" THEN 3
                ELSE 0
            END
        ) as total_points'),
                DB::raw('SUM(
            CASE
                WHEN absensis.status = "h" THEN 1
                ELSE 0
            END
        ) as total_hadir'),
                DB::raw('SUM(
            CASE
                WHEN absensis.status = "i" THEN 1
                ELSE 0
            END
        ) as total_izin'),
                DB::raw('SUM(
            CASE
                WHEN absensis.status = "s" THEN 1
                ELSE 0
            END
        ) as total_sakit')
            )
            ->groupBy('absensis.nisn', 'siswas.nama');

        // Ranking terbaik (Top 5)
        $topRanking = (clone $rankingQuery)->orderByDesc('total_points')->take(5)->get();

        // Ranking terburuk (Bottom 5)
        $bottomRanking = (clone $rankingQuery)->orderBy('total_points')->take(5)->get();


        return view('dashboard', compact('topRanking', 'bottomRanking'));
    }
}
