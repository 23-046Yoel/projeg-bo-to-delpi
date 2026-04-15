<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SavedReport;
use App\Models\MaterialLog;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function lpd2m(Request $request)
    {
        $startDate = $request->input('start_date', '2026-04-06');
        $endDate = $request->input('end_date', '2026-04-18');
        $user = auth()->user();
        $sppgId = $user->sppg_id;
        $sppg = $user->sppg;

        // Check if there is a saved version
        $saved = SavedReport::where('user_id', $user->id)->where('type', 'lpd2m')->first();
        if ($saved && !$request->has('refresh')) {
            $data = $saved->data;
            return view('reports.lpd2m', compact('data'));
        }

        // Real calculations
        $danaMasuk = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->where('date', '<=', $endDate)->sum('amount_in');
        $belanjaBahan = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Biaya Bahan Baku')->sum('amount_out');
        $operasional = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Biaya Operasional')->sum('amount_out');
        $insentif = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Insentif Fasilitas')->sum('amount_out');
        
        $totalBelanja = $belanjaBahan + $operasional + $insentif;
        $sisaDana = $danaMasuk - $totalBelanja; // Simplified calculation

        $data = [
            'period' => Carbon::parse($startDate)->format('d M Y') . ' s.d. ' . Carbon::parse($endDate)->format('d M Y'),
            'user_name' => $user->name,
            'jabatan' => 'Kepala SPPG',
            'yayasan' => 'PENDIDIKAN ALA DELPHI',
            'sppg_name' => $sppg->name ?? 'SPPG UNKNOWN',
            'sppg_id' => $sppg->code ?? 'N/A',
            'dana_masuk' => $danaMasuk,
            'belanja_bahan' => $belanjaBahan,
            'operasional' => $operasional,
            'insentif' => $insentif,
            'virtual_account' => '294351000011665', // Placeholder for now
            'sisa_dana' => $sisaDana,
            'ka_sppg' => $user->name,
            'bendahara' => 'AGITA SEBAYANG',
            'pimpinan' => 'SILVERIUS BANGUN'
        ];

        return view('reports.lpd2m', compact('data'));
    }

    public function sptj(Request $request)
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;

        $saved = SavedReport::where('user_id', $user->id)->where('type', 'sptj')->first();
        if ($saved && !$request->has('refresh')) {
            $data = $saved->data;
            return view('reports.sptj', compact('data'));
        }

        $penerimaan = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->sum('amount_in');
        $pengeluaran = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->sum('amount_out');
        $sisa = $penerimaan - $pengeluaran;

        $data = [
            'nama' => $user->name,
            'jabatan' => 'Kepala SPPG',
            'penerimaan' => $penerimaan,
            'pengeluaran' => $pengeluaran,
            'sisa' => $sisa,
            'tanggal' => Carbon::now()->translatedFormat('d F Y'),
            'lokasi' => $user->sppg->location ?? 'BALIMBINGAN'
        ];
        return view('reports.sptj', compact('data'));
    }

    public function bapsd(Request $request)
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;

        $saved = SavedReport::where('user_id', $user->id)->where('type', 'bapsd')->first();
        if ($saved && !$request->has('refresh')) {
            $data = $saved->data;
            return view('reports.bapsd', compact('data'));
        }

        $penerimaan = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->sum('amount_in');
        $pengeluaran = Payment::where('sppg_id', $sppgId)->where('status', 'paid')->sum('amount_out');
        $sisa = $penerimaan - $pengeluaran;

        $data = [
            'periode_berakhir' => Carbon::now()->format('d-m-Y'),
            'sisa_dana' => $sisa,
            'periode_mulai' => Carbon::now()->addDay()->translatedFormat('d F Y'),
            'pihak_pertama' => $user->name,
            'pihak_kedua' => 'AGITA SEBAYANG',
            'mengetahui' => $user->name,
            'tanggal' => Carbon::now()->translatedFormat('d F Y')
        ];
        return view('reports.bapsd', compact('data'));
    }

    public function saveReport(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:sptj,bapsd,lpd2m',
            'data' => 'required|array'
        ]);

        SavedReport::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'sppg_id' => auth()->user()->sppg_id,
                'type' => $validated['type']
            ],
            [
                'data' => $validated['data']
            ]
        );

        return response()->json(['success' => true, 'message' => 'Laporan berhasil disimpan!']);
    }

    public function uploadIndex()
    {
        $documents = \App\Models\UploadedDocument::with('user')->latest()->get();
        return view('reports.upload', compact('documents'));
    }

    public function uploadStore(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
            'name' => 'nullable|string|max:255'
        ]);

        $file = $request->file('document');
        $name = $request->input('name') ?: $file->getClientOriginalName();
        $path = $file->store('documents', 'public');

        \App\Models\UploadedDocument::create([
            'user_id' => auth()->id(),
            'name' => $name,
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'category' => $request->input('category', 'general')
        ]);

        return back()->with('success', 'Berkas berhasil diunggah!');
    }
}
