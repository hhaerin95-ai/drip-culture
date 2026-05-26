<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])
            ->where('status', 'Active')
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants']);

        return view('products.show', compact('product'));
    }
}