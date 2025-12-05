@extends('layouts.customer')

@section('title', 'Order Success - ScanMart')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="card text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-green-600 mb-2">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">Your order has been placed successfully</p>

        <!-- Order Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600">Order Number</p>
                    <p class="font-bold text-lg">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Order Date</p>
                    <p class="font-bold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                        Paid
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Amount</p>
                    <p class="font-bold text-lg text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-3">Order Items:</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                            <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pickup Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 text-left">
            <h3 class="font-semibold text-blue-900 mb-2">📦 Next Steps:</h3>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• Your order is ready for pickup</li>
                <li>• Please show this order number at the pickup counter</li>
                <li>• Items will be reserved for 24 hours</li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('home') }}" class="btn-primary flex-1 text-center">
                Back to Home
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary flex-1 text-center">
                Continue Shopping
            </a>
        </div>

        <p class="text-sm text-gray-600 mt-6">
            Thank you for shopping with ScanMart! 🎉
        </p>
    </div>
</div>
@endsection