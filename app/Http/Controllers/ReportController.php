<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function lpd2m(Request $request)
    {
        $startDate = $request->input('start_date', '2026-04-06');
        $endDate = $request->input('end_date', '2026-04-18');
        $user = auth()->user();
        $sppg = $user->sppg;

        // Simplified calculation for demo
        $data = [
            'period' => $startDate . ' s.d. ' . $endDate,
            'user_name' => 'ABDI SEPTIAN',
            'jabatan' => 'Kepala SPPG',
            'yayasan' => 'PENDIDIKAN ALA DELPHI',
            'sppg_name' => $sppg->name ?? 'SPPG BALIMBINGAN 2',
            'sppg_id' => 'MEUZONOK',
            'dana_masuk' => 661245127,
            'belanja_bahan' => 189472000,
            'operasional' => 84603000,
            'insentif' => 72000000,
            'virtual_account' => '294351000011665',
            'sisa_dana' => 315170127,
            'ka_sppg' => 'ABDI SEPTIAN',
            'bendahara' => 'AGITA SEBAYANG',
            'pimpinan' => 'SILVERIUS BANGUN'
        ];

        return view('reports.lpd2m', compact('data'));
    }

    public function sptj(Request $request)
    {
        $user = auth()->user();
        $data = [
            'nama' => 'SILVERIUS BANGUN',
            'jabatan' => 'Perwakilan PENDIDIKAN ALA DELPHI',
            'penerimaan' => 661245127,
            'pengeluaran' => 346075000,
            'sisa' => 315170127,
            'tanggal' => '18 April 2026',
            'lokasi' => 'BALIMBINGAN'
        ];
        return view('reports.sptj', compact('data'));
    }

    public function bapsd(Request $request)
    {
        $data = [
            'periode_berakhir' => '04-06-2026',
            'sisa_dana' => 315170127,
            'periode_mulai' => '20 April 2026',
            'pihak_pertama' => 'SILVERIUS BANGUN',
            'pihak_kedua' => 'AGITA SEBAYANG',
            'mengetahui' => 'ABDI SEPTIAN',
            'tanggal' => '18 April 2026'
        ];
        return view('reports.bapsd', compact('data'));
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
