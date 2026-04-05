<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Complaint;

class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource (Admin).
     */
    public function index()
    {
        $this->middleware('auth');
        $complaints = Complaint::latest()->paginate(15);
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource (Public).
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created resource in storage (Public).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('complaints', 'public');
        }

        Complaint::create($validated);

        return redirect()->route('complaints.create')->with('success', 'Aduan Anda berhasil terkirim. Kami akan segera memprosesnya.');
    }

    /**
     * Update the specified resource in storage (Admin).
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->middleware('auth');
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $complaint->update($validated);

        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui.');
    }
}
