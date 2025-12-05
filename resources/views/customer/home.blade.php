@extends('layouts.customer')

@section('title', 'Home - ScanMart')

@section('content')
<div class="container mx-auto px-4">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl p-8 md:p-12 text-white mb-12">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Welcome to ScanMart</h1>
            <p class="text-lg md:text-xl mb-8 text-primary-100">Self-checkout shopping made easy. Scan QR codes, add to cart, and pay instantly!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('scan') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition inline-block">
                    📱 Scan QR Code
                </a>
                <a href="{{ route('products.index') }}" class="bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-900 transition inline-block border-2 border-white">
                    🛍️ Browse Products
                </a>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6 text-center">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="card hover:shadow-xl hover:scale-105 transition-all duration-200 text-center">
                    <div class="text-5xl mb-3">{{ $category->icon ?? '📦' }}</div>
                    <h3 class="font-bold text-lg mb-1">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->products_count }} items</p>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div>
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">✨ Featured Products</h2>
            <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 font-semibold flex items-center gap-1">
                View All <span>→</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="card hover:shadow-xl hover:scale-105 transition-all duration-200">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg mb-4 flex items-center justify-center hover:from-primary-50 hover:to-primary-100 transition-all">
                            <span class="text-6xl">{{ $product->category->icon ?? '📦' }}</span>
                        </div>
                    @endif
                    <div class="mb-2">
                        <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-full font-semibold">{{ $product->category->name }}</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2 h-14 overflow-hidden leading-tight">{{ $product->name }}</h3>
                    <div class="flex justify-between items-center mt-auto">
                        <div>
                            <span class="text-2xl font-bold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->weight)
                                <p class="text-xs text-gray-500">{{ $product->weight }}</p>
                            @endif
                        </div>
                        <a href="{{ route('product.show', $product->slug) }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition font-semibold text-sm">
                            View
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- How It Works -->
    <div class="mt-16 bg-white rounded-2xl p-8 md:p-12">
        <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">📱</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">1. Scan QR Code</h3>
                <p class="text-gray-600">Scan the QR code on products to view details</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">🛒</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">2. Add to Cart</h3>
                <p class="text-gray-600">Add items to your digital shopping cart</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">💳</span>
                </div>
                <h3 class="text-xl font-semibold mb-2">3. Pay & Go</h3>
                <p class="text-gray-600">Complete payment and enjoy your purchase</p>
            </div>
        </div>
    </div>
</div>
@endsection