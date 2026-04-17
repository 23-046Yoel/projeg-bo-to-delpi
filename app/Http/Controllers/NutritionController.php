<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NutritionController extends Controller
{
    /**
     * Show the nutrition consultation registration form (public).
     */
    public function consultation()
    {
        return view('nutrition.consultation');
    }

    /**
     * Store a new nutrition consultation request.
     */
    public function storeConsultation(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'nullable|string|max:20',
            'age'             => 'required|integer|min:0',
            'gender'          => 'required|string',
            'weight'          => 'required|numeric',
            'height'          => 'required|numeric',
            'goal'            => 'required|string',
            'medical_history' => 'nullable|string',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        \App\Models\NutritionConsultation::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran konsultasi gizi berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    /**
     * Admin: list all consultation registrations.
     */
    public function consultationList(Request $request)
    {
        $consultations = \App\Models\NutritionConsultation::latest()->paginate(20);
        return view('nutrition.consultation-list', compact('consultations'));
    }

    /**
     * Show the daily report upload form.
     */
    public function dailyReport()
    {
        return view('reports.daily');
    }

    /**
     * Store a new daily report.
     */
    public function storeDailyReport(Request $request)
    {
        $validated = $request->validate([
            'report_date' => 'required|date',
            'report_type' => 'required|string',
            'attachment'  => 'required|file|max:10240',
            'notes'       => 'nullable|string',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('reports', 'public');
        }

        \App\Models\DailyReport::create([
            'user_id'         => auth()->id(),
            'sppg_id'         => auth()->user()->sppg_id ?? null,
            'report_date'     => $validated['report_date'],
            'session'         => '-', // Defaulting to "-" since shift is no longer used
            'report_type'     => $validated['report_type'],
            'attachment_path' => $attachmentPath,
            'notes'           => $validated['notes'],
        ]);

        return redirect()->back()->with('success', 'Laporan harian berhasil diunggah dan tersimpan dengan aman.');
    }
}
