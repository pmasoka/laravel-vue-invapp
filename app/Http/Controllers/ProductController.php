<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return Inertia::render('products/Index', compact('products'));
    }

    public function create()
    {
        return Inertia::render('products/Create', []);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0|',
            'description' => 'nullable|string',
        ]);

        // Auto calculate total price
        $data['total_price'] = $data['quantity'] * $data['unit_price'];

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('message', 'Product added successfully');
    }

    public function edit(Product $product)
    {
        return Inertia::render('products/Edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Auto calculate total price
        $data['total_price'] = $data['quantity'] * $data['unit_price'];

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('message', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Product deleted successfully');
    }
}
