<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function lpd2m(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        // Logic for Laporan Pengguna Anggaran
        return view('reports.lpd2m', compact('date'));
    }

    public function sptj(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        // Logic for Surat Pernyataan Tanggung Jawab
        return view('reports.sptj', compact('date'));
    }

    public function bapsd(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        return view('reports.bapsd', compact('date'));
    }
}
