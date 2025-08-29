<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

use App\Events\ProductActionEvent;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category', 'supplier'])->latest()->get();

        return Inertia::render('products/Index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->select('id', 'name')->get();
        $suppliers = Supplier::orderBy('name')->select('id', 'name')->get();

        return Inertia::render('products/Create', [
            'categories' => $categories,
            'suppliers'  => $suppliers,
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
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        // Always compute total_price on the server
        $data['total_price'] = (int)$data['quantity'] * (float)$data['unit_price'];

        $product = Product::create($data);

        event(new ProductActionEvent($product, 'created'));

        return redirect()
            ->route('products.index')
            ->with('message', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('category', 'supplier');

        $categories = Category::orderBy('name')->select('id', 'name')->get();
        $suppliers = Supplier::orderBy('name')->select('id', 'name')->get();

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
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $data['total_price'] = $data['quantity'] * $data['unit_price'];

        $product->update($data);

        // Log product update into MongoDB
        event(new ProductActionEvent($product, 'deleted'));

        return redirect()
            ->route('products.index')
            ->with('message', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        // Log product deletion into MongoDB
        event(new ProductActionEvent($product, 'updated'));

        return redirect()
            ->route('products.index')
            ->with('message', 'Product deleted successfully');
    }
}
