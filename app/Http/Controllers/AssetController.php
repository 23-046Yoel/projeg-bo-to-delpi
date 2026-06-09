<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Sppg;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-assets');
    }

    public function index()
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;

        $assets = Asset::with('sppg')
            ->when($sppgId, function ($query, $sppgId) {
                return $query->where('sppg_id', $sppgId);
            })
            ->latest()
            ->paginate(10);

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $user = auth()->user();
        $sppgs = Sppg::all();
        return view('assets.create', compact('sppgs', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:assets,code',
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        $user = auth()->user();
        if ($user->sppg_id) {
            $validated['sppg_id'] = $user->sppg_id;
        }

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $user = auth()->user();
        if ($user->sppg_id && $asset->sppg_id !== $user->sppg_id) {
            abort(403);
        }

        $sppgs = Sppg::all();
        return view('assets.edit', compact('asset', 'sppgs', 'user'));
    }

    public function update(Request $request, Asset $asset)
    {
        $user = auth()->user();
        if ($user->sppg_id && $asset->sppg_id !== $user->sppg_id) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:assets,code,' . $asset->id,
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        if ($user->sppg_id) {
            $validated['sppg_id'] = $user->sppg_id;
        }

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $user = auth()->user();
        if ($user->sppg_id && $asset->sppg_id !== $user->sppg_id) {
            abort(403);
        }

        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
