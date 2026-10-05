<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getProducts()
    {
        $products = Product::where('is_active', true)->get();
        return response()->json($products);
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'Không đủ hàng'], 400);
        }

        return response()->json(['success' => true, 'product' => $product]);
    }
}
