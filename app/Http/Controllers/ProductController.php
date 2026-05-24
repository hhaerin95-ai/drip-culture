<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with(['category', 'variants'])
        ->where('status', 'Active');

    if ($request->filled('cat')) {
        $query->where('category_id', $request->cat);
    }

    if ($request->filled('q')) {
    $query->where('product_name', 'like', '%' . $request->q . '%');
}

    if ($request->filled('sort')) {
        if ($request->sort === 'price_asc') {
            $query->orderBy('base_price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('base_price', 'desc');
        } else {
            $query->latest();
        }
    } else {
        $query->latest();
    }

    $products = $query->get();
    $categories = Category::all();
    return view('products.index', compact('products', 'categories'));
}

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}