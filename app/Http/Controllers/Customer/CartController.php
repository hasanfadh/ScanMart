<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()]);
        }
        return session('cart_session_id');
    }

    public function index()
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::forSession($sessionId)
            ->with('product')
            ->get();

        $subtotal = Cart::getTotalForSession($sessionId);
        $tax = $subtotal * 0.11; // PPN 11%
        $serviceFee = 2000; // Fee tetap
        $total = $subtotal + $tax + $serviceFee;

        return view('customer.cart.index', compact('cartItems', 'subtotal', 'tax', 'serviceFee', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->isInStock()) {
            return back()->with('error', 'Product out of stock!');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        $sessionId = $this->getSessionId();

        // Cek apakah produk sudah ada di cart
        $cartItem = Cart::forSession($sessionId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $sessionId = $this->getSessionId();
        Cart::forSession($sessionId)->delete();
        
        return back()->with('success', 'Cart cleared!');
    }
}