<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();
        
        $categories = Category::active()
            ->withCount('products')
            ->get();

        return view('customer.home', compact('featuredProducts', 'categories'));
    }

    // Scan QR Code page
    public function scan()
    {
        return view('customer.scan');
    }

    // Manual input product code
    public function searchByCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $product = Product::where('sku', $request->code)
            ->orWhere('slug', $request->code)
            ->first();

        if ($product) {
            return redirect()->route('product.show', $product->slug);
        }

        return back()->with('error', 'Product not found!');
    }
}