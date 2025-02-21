<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('quantity', 'asc')->get();
        return view('products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'numeric|min:0',
        ]);

        $validated['price'] = $validated['price'] * 100;
        $validated['status'] = 1;

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required|integer',
            'quantity' => 'numeric|min:0',
        ]);
        $validated['price'] = $validated['price'] * 100;

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
