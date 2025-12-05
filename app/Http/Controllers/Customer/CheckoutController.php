<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function getSessionId()
    {
        return session('cart_session_id');
    }

    public function index()
    {
        $sessionId = $this->getSessionId();
        
        if (!$sessionId) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = Cart::forSession($sessionId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = Cart::getTotalForSession($sessionId);
        $tax = $subtotal * 0.11;
        $serviceFee = 2000;
        $total = $subtotal + $tax + $serviceFee;

        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'tax', 'serviceFee', 'total'));
    }

    public function process(Request $request)
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::forSession($sessionId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            // Hitung total
            $subtotal = Cart::getTotalForSession($sessionId);
            $tax = $subtotal * 0.11;
            $serviceFee = 2000;
            $total = $subtotal + $tax + $serviceFee;

            // Buat order
            $order = Order::create([
                'session_id' => $sessionId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'service_fee' => $serviceFee,
                'total' => $total,
                'status' => 'pending'
            ]);

            // Buat order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal
                ]);
            }

            // Hapus cart
            Cart::forSession($sessionId)->delete();

            DB::commit();

            return redirect()->route('checkout.payment', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function payment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->isPaid()) {
            return redirect()->route('checkout.success', $order->order_number);
        }

        return view('customer.checkout.payment', compact('order'));
    }

    public function confirmPayment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->isPaid()) {
            return redirect()->route('checkout.success', $order->order_number);
        }

        $order->markAsPaid();

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        return view('customer.checkout.success', compact('order'));
    }
}