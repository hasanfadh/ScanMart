@extends('layouts.customer')

@section('title', 'Shopping Cart - ScanMart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="card">
                    <h2 class="text-xl font-bold mb-4 pb-4 border-b">Cart Items</h2>
                    
                    @foreach($cartItems as $item)
                        <div class="flex items-center border-b border-gray-200 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                            <!-- Product Image -->
                            <div class="w-24 h-24 flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-2xl">📦</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 ml-4">
                                <h3 class="font-semibold text-lg mb-1">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $item->product->category->name }}</p>
                                <p class="text-primary-600 font-semibold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                
                                @if($item->product->pickup_location)
                                    <p class="text-xs text-gray-500 mt-1">📍 {{ $item->product->pickup_location }}</p>
                                @endif
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-3">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <button type="submit" class="text-primary-600 hover:text-primary-800 text-sm font-semibold px-2 py-1 rounded hover:bg-primary-50 transition">
                                        Update
                                    </button>
                                </form>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50 transition" onclick="return confirm('Remove this item from cart?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Subtotal -->
                            <div class="ml-6 text-right min-w-[120px]">
                                <p class="text-lg font-bold text-gray-800">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Clear Cart Button -->
                    <div class="mt-6 pt-4 border-t">
                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold flex items-center space-x-2 hover:bg-red-50 px-3 py-2 rounded transition" onclick="return confirm('Clear all items from cart?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Clear Cart</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Guest Checkout Info -->
                <div class="card bg-blue-50 border border-blue-200 mt-6">
                    <div class="flex items-start space-x-3">
                        <span class="text-2xl">📋</span>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Guest Checkout</h3>
                            <p class="text-sm text-blue-800">You're checking out as a guest. Your order will be processed immediately after payment confirmation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Checkout -->
            <div class="lg:col-span-1">
                <div class="card sticky top-24">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6 pb-6 border-b">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (11%)</span>
                            <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Service Fee</span>
                            <span class="font-medium">Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Total -->
                    <div class="flex justify-between items-center mb-6 pb-6 border-b">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-2xl font-bold text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Items Summary -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Items</span>
                            <span class="font-semibold">{{ $cartItems->sum('quantity') }} item(s)</span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary w-full mb-3 py-3 text-lg font-semibold flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Proceed to Payment</span>
                        </button>
                    </form>

                    <!-- Continue Shopping Button -->
                    <a href="{{ route('products.index') }}" class="btn-secondary w-full text-center flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Continue Shopping</span>
                    </a>

                    <!-- Security Badge -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Secure Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Start adding products to your cart!</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Browse Products</span>
            </a>
        </div>
    @endif
</div>
@endsection