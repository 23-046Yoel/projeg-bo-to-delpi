<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SavedReport;
use App\Models\MaterialLog;
use App\Models\User;
use App\Models\VolunteerAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function lpd2m(Request $request)
    {
        $startDate = $request->input('start_date', '2026-04-06');
        $endDate = $request->input('end_date', '2026-04-18');
        $user = auth()->user();
        $sppgId = $user->sppg_id;
        $sppg = $user->sppg;

        // Check if there is a saved version (Safety check if table doesn't exist yet)
        $saved = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('saved_reports')) {
            $saved = SavedReport::where('user_id', $user->id)->where('type', 'lpd2m')->first();
        }

        if ($saved && !$request->has('refresh')) {
            $data = $saved->data;
            return view('reports.lpd2m', compact('data'));
        }

        // Portion-based Budget Calculations
        $portions = \App\Models\BeneficiaryGroup::where('sppg_id', $sppgId)
            ->selectRaw('SUM(porsi_besar) as total_besar, SUM(porsi_kecil) as total_kecil')
            ->first();

        $porsiBesar = $portions->total_besar ?? 0;
        $porsiKecil = $portions->total_kecil ?? 0;

        $budgetBahanHarian = ($porsiBesar * 10000) + ($porsiKecil * 8000);
        $budgetBahanPeriode = $budgetBahanHarian * 12;

        $budgetOpsHarian = ($porsiBesar + $porsiKecil) * 3000;
        $budgetOpsPeriode = $budgetOpsHarian * 12;

        // Real realization calculations
        $belanjaBahan = \App\Models\Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Biaya Bahan Baku')->sum('amount_out');
        $operasional = \App\Models\Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Biaya Operasional')->sum('amount_out');
        $insentif = \App\Models\Payment::where('sppg_id', $sppgId)->where('status', 'paid')->whereBetween('date', [$startDate, $endDate])->where('transaction_type', 'Insentif Fasilitas')->sum('amount_out');

        $totalBudget = $budgetBahanPeriode + $budgetOpsPeriode;
        $totalBelanja = $belanjaBahan + $operasional + $insentif;
        $sisaDana = $totalBudget - $totalBelanja; 

        // Fetch detailed material usage
        $materialUsages = MaterialLog::with('material')
            ->where('sppg_id', $sppgId)
            ->where('type', 'out')
            ->whereBetween('date', [$startDate, $endDate])
            ->select('material_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('material_id')
            ->get();

        $data = [
            'period' => Carbon::parse($startDate)->format('d M Y') . ' s.d. ' . Carbon::parse($endDate)->format('d M Y'),
            'user_name' => $user->name,
            'jabatan' => 'Kepala SPPG',
            'yayasan' => 'PENDIDIKAN ALA DELPHI',
            'sppg_name' => $sppg->name ?? 'SPPG UNKNOWN',
            'sppg_id' => $sppg->code ?? 'N/A',
            'dana_masuk' => $totalBudget, // Use calculated budget as total income
            'budget_bahan_harian' => $budgetBahanHarian,
            'budget_bahan_periode' => $budgetBahanPeriode,
            'budget_ops_harian' => $budgetOpsHarian,
            'budget_ops_periode' => $budgetOpsPeriode,
            'porsi_besar' => $porsiBesar,
            'porsi_kecil' => $porsiKecil,
            'belanja_bahan' => $belanjaBahan,
            'operasional' => $operasional,
            'insentif' => $insentif,
            'virtual_account' => '294351000011665', // Placeholder for now
            'sisa_dana' => $sisaDana,
            'ka_sppg' => $user->name,
            'bendahara' => 'AGITA SEBAYANG',
            'pimpinan' => 'SILVERIUS BANGUN',
            'usages' => $materialUsages // Added detail
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

        }


    public function attendanceRecap(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $sppgId = auth()->user()->sppg_id;

        // Get all volunteers for this SPPG
        $volunteers = User::where('sppg_id', $sppgId)
            ->where('role', User::ROLE_VOLUNTEER)
            ->get();

        // Get attendance records for this month
        $attendances = VolunteerAttendance::where('sppg_id', $sppgId)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get()
            ->groupBy(['user_id', function ($item) {
                return $item->created_at->format('j'); // Group by day (1-31)
            }]);

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        $data = [
            'month_name' => Carbon::create($year, $month)->translatedFormat('F Y'),
            'month' => $month,
            'year' => $year,
            'volunteers' => $volunteers,
            'attendances' => $attendances,
            'daysInMonth' => $daysInMonth
        ];

        return view('reports.attendance_recap', compact('data'));
    }

    public function lpjSppgIndex()
    {
        $lpjs = \App\Models\LpjSppg::latest()->get();
        return view('reports.lpj_sppg.index', compact('lpjs'));
    }

    public function lpjSppgCreate()
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;
        
        // Ambil data kelompok sasaran untuk pre-fill target
        $groups = \App\Models\BeneficiaryGroup::where('sppg_id', $sppgId)->get();
        
        $data = [
            'period_start' => now()->subDays(14)->toDateString(),
            'period_end' => now()->toDateString(),
            'ketua_yayasan' => 'SILVERIUS BANGUN',
            'ppk_nama' => 'J. HASIHOLAN GULTOM',
            'head_sppg_nama' => $user->name,
            'report_date' => now()->toDateString(),
            'target_peserta' => $groups->whereIn('category', ['peserta_didik', 'sd', 'smp', 'paud', 'sma'])->sum('total_beneficiaries'),
            'target_pendidik' => $groups->where('category', 'pendidik')->sum('total_beneficiaries'),
            'target_3b' => $groups->where('category', '3b')->sum('total_beneficiaries'),
        ];
        
        return view('reports.lpj_sppg.create', compact('data'));
    }

    public function lpjSppgStore(Request $request)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'target_peserta' => 'integer',
            'realisasi_peserta' => 'integer',
            'target_pendidik' => 'integer',
            'realisasi_pendidik' => 'integer',
            'target_3b' => 'integer',
            'realisasi_3b' => 'integer',
            'anggaran_bahan' => 'numeric',
            'realisasi_bahan' => 'numeric',
            'anggaran_ops' => 'numeric',
            'realisasi_ops' => 'numeric',
            'anggaran_insentif' => 'numeric',
            'realisasi_insentif' => 'numeric',
            'ketua_yayasan' => 'string|nullable',
            'ppk_nama' => 'string|nullable',
            'head_sppg_nama' => 'string|nullable',
            'report_date' => 'required|date',
            'organoleptik_data' => 'array|nullable',
            'buku_bantu_bahan' => 'array|nullable',
            'buku_bantu_ops' => 'array|nullable',
        ]);

        \App\Models\LpjSppg::create($validated);

        return redirect()->route('reports.lpj-sppg.index')->with('success', 'LPJ SPPG berhasil dibuat!');
    }

    public function lpjSppgEdit(\App\Models\LpjSppg $lpj)
    {
        return view('reports.lpj_sppg.edit', compact('lpj'));
    }

    public function lpjSppgUpdate(Request $request, \App\Models\LpjSppg $lpj)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date',
            'target_peserta' => 'integer',
            'realisasi_peserta' => 'integer',
            'target_pendidik' => 'integer',
            'realisasi_pendidik' => 'integer',
            'target_3b' => 'integer',
            'realisasi_3b' => 'integer',
            'anggaran_bahan' => 'numeric',
            'realisasi_bahan' => 'numeric',
            'anggaran_ops' => 'numeric',
            'realisasi_ops' => 'numeric',
            'anggaran_insentif' => 'numeric',
            'realisasi_insentif' => 'numeric',
            'ketua_yayasan' => 'string|nullable',
            'ppk_nama' => 'string|nullable',
            'head_sppg_nama' => 'string|nullable',
            'report_date' => 'required|date',
            'organoleptik_data' => 'nullable',
            'buku_bantu_bahan' => 'nullable',
            'buku_bantu_ops' => 'nullable',
        ]);

        $lpj->update($validated);

        return redirect()->route('reports.lpj-sppg.index')->with('success', 'LPJ SPPG berhasil diperbarui!');
    }

    public function lpjSppgShow(\App\Models\LpjSppg $lpj)
    {
        return view('reports.lpj_sppg.print', compact('lpj'));
    }

    public function lpjSppgDestroy(\App\Models\LpjSppg $lpj)
    {
        $lpj->delete();
        return redirect()->route('reports.lpj-sppg.index')->with('success', 'LPJ SPPG berhasil dihapus!');
    }
}
