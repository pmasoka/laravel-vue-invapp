<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return Inertia::render('suppliers/Index', compact('suppliers'));
    }

    public function create()
    {
        return Inertia::render('suppliers/Create', []);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'address' => 'required|string|max:500',
        ]);

        Supplier::create($data);

        return redirect()
            ->route('suppliers.index')
            ->with('message', 'Supplier added successfully.');
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(Supplier $supplier)
    {
        return Inertia::render('suppliers/Edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:suppliers,email,' . $supplier->id,
            'address' => 'required|string|max:500',
        ]);

        $supplier->update($data);

        return redirect()
            ->route('suppliers.index')
            ->with('message', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('message', 'Supplier deleted successfully.');
    }
}
