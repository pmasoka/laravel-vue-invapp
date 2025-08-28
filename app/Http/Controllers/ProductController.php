<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier; // Import the Supplier model
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        // Eager-load the 'category' and 'supplier' relationships
        $products = Product::with(['category', 'supplier'])->latest()->get();

        return Inertia::render('products/Index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')
            ->select('id', 'name')
            ->get();
        
        $suppliers = Supplier::orderBy('name') // Fetch suppliers
            ->select('id', 'name')
            ->get();

        return Inertia::render('products/Create', [
            'categories' => $categories,
            'suppliers' => $suppliers, // Pass suppliers to the view
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'quantity'    => 'required|integer|min:0',
            'unit_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id', // Add validation for supplier_id
        ]);

        // Always compute total_price on the server
        $data['total_price'] = (int)$data['quantity'] * (float)$data['unit_price'];

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('message', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        // Eager-load the category and supplier relationships for the specific product
        $product->load('category', 'supplier');

        $categories = Category::orderBy('name')
            ->select('id', 'name')
            ->get();
        
        $suppliers = Supplier::orderBy('name') // Fetch suppliers
            ->select('id', 'name')
            ->get();

        return Inertia::render('products/Edit', [
            'product'    => $product,
            'categories' => $categories,
            'suppliers'  => $suppliers,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'quantity'    => 'required|numeric|min:0',
            'unit_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id', // Add validation for supplier_id
        ]);

        // Auto-calculate total price
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