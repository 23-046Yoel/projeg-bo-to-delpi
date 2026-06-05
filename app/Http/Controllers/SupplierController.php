<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::with('sppg')->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->filled('phone')) {
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            if (str_starts_with($phone, '620')) {
                $phone = '62' . substr($phone, 3);
            } elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }
            $request->merge(['phone' => $phone]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'phone' => 'nullable|string|max:20|unique:suppliers,phone',
            'price' => 'numeric|min:0',
            'village' => 'nullable|string|max:255',
            'items' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if ($request->filled('phone')) {
            $phone = preg_replace('/[^0-9]/', '', $request->phone);
            if (str_starts_with($phone, '620')) {
                $phone = '62' . substr($phone, 3);
            } elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }
            $request->merge(['phone' => $phone]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'phone' => 'nullable|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'price' => 'numeric|min:0',
            'village' => 'nullable|string|max:255',
            'items' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if (auth()->user()->role !== \App\Models\User::ROLE_ADMIN) {
            abort(403, 'Hanya admin yang dapat menghapus supplier.');
        }

        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
