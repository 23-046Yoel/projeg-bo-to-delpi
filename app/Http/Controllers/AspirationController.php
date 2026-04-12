<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    /** Public: Submit aspiration */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content'      => 'required|string|max:500',
            'sender_name'  => 'nullable|string|max:100',
            'sender_phone' => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:100',
        ]);

        Aspiration::create([
            'content'      => $validated['content'],
            'sender_name'  => $validated['sender_name'] ?? 'Anonim',
            'sender_phone' => $validated['sender_phone'] ?? null,
            'location'     => $validated['location'] ?? null,
            'is_active'    => false, // needs admin approval
        ]);

        return back()->with('success', 'Aspirasi Anda berhasil dikirim! Akan ditampilkan setelah diverifikasi admin.');
    }

    /** Admin: List all */
    public function index()
    {
        $aspirations = Aspiration::latest()->paginate(20);
        return view('admin.aspirations.index', compact('aspirations'));
    }

    /** Admin: Toggle active/inactive */
    public function toggle(Aspiration $aspiration)
    {
        $aspiration->update(['is_active' => !$aspiration->is_active]);
        return back()->with('success', 'Status aspirasi diperbarui.');
    }

    /** Admin: Toggle pinned */
    public function pin(Aspiration $aspiration)
    {
        $aspiration->update(['is_pinned' => !$aspiration->is_pinned]);
        return back()->with('success', 'Status pin aspirasi diperbarui.');
    }

    /** Admin: Delete */
    public function destroy(Aspiration $aspiration)
    {
        $aspiration->delete();
        return back()->with('success', 'Aspirasi berhasil dihapus.');
    }
}
