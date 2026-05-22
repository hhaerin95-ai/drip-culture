<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /** List all products */
    public function index(Request $request)
    {
        $query = Product::with(['category']);

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /** Show single product */
    public function show(Product $product)
    {
        $product->load(['category']);

        return view('admin.products.show', compact('product'));
    }

    /** Create form */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /** Store product */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:150'],
            'category_id'  => ['required', 'exists:categories,category_id'],
            'description'  => ['nullable', 'string'],
            'base_price'   => ['required', 'numeric', 'min:0'],
            'status'       => ['required', 'in:Active,Inactive'],
        ]);

        Product::create([
            'category_id'  => $validated['category_id'],
            'product_name' => $validated['product_name'],
            'description'  => $validated['description'] ?? null,
            'base_price'   => $validated['base_price'],
            'status'       => $validated['status'],
            'created_at'   => now(),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /** Edit form */
    public function edit(Product $product)
    {
        $product->load(['category']);

        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /** Update product */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:150'],
            'category_id'  => ['required', 'exists:categories,category_id'],
            'description'  => ['nullable', 'string'],
            'base_price'   => ['required', 'numeric', 'min:0'],
            'status'       => ['required', 'in:Active,Inactive'],
        ]);

        $product->update([
            'category_id'  => $validated['category_id'],
            'product_name' => $validated['product_name'],
            'description'  => $validated['description'] ?? null,
            'base_price'   => $validated['base_price'],
            'status'       => $validated['status'],
        ]);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    /** Toggle status */
    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'Active'
                ? 'Inactive'
                : 'Active',
        ]);

        return back()->with('success', 'Product status updated.');
    }

    /** Delete product */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}