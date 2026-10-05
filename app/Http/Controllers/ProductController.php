<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('is_active', true)->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = $category->products()->where('is_active', true)->paginate(12);
        $categories = Category::all();
        return view('products.index', compact('products', 'category', 'categories'));
    }
}
