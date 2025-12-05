@extends('layouts.customer')

@section('title', $product->name . ' - ScanMart')

@section('content')
<div class="container mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-primary-600 hover:underline">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('products.index') }}" class="text-primary-600 hover:underline">Products</a>
        <span class="mx-2">/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Product Image -->
        <div>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-xl shadow-lg">
            @else
                <div class="w-full h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                    <span class="text-gray-400 text-6xl">📦</span>
                </div>
            @endif

            <!-- QR Code -->
            @if($product->qr_code)
                <div class="mt-6 card text-center">
                    <h3 class="font-semibold mb-4">Product QR Code</h3>
                    <img src="{{ asset('storage/' . $product->qr_code) }}" alt="QR Code" class="w-48 h-48 mx-auto">
                    <p class="text-sm text-gray-600 mt-2">SKU: {{ $product->sku }}</p>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <div class="mb-4">
                <span class="bg-primary-100 text-primary-600 px-3 py-1 rounded-lg text-sm font-semibold">
                    {{ $product->category->name }}
                </span>
            </div>

            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
            
            @if($product->weight)
                <p class="text-lg text-gray-600 mb-4">Weight: {{ $product->weight }}</p>
            @endif

            <div class="text-4xl font-bold text-primary-600 mb-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->stock > 0)
                    <div class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        In Stock ({{ $product->stock }} available)
                    </div>
                @else
                    <div class="flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Out of Stock
                    </div>
                @endif
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $product->description }}</p>
                </div>
            @endif

            <!-- Pickup Location -->
            @if($product->pickup_location)
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900">Pickup Location</h4>
                            <p class="text-blue-800 text-sm">{{ $product->pickup_location }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Add to Cart -->
            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center space-x-4 mb-6">
                        <label class="font-semibold">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-24 px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <button type="submit" class="btn-primary w-full md:w-auto">
                        Add to Cart
                    </button>
                </form>
            @else
                <button disabled class="bg-gray-300 text-gray-600 px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                    Out of Stock
                </button>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="card hover:shadow-lg transition">
                        @if($relatedProduct->image)
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-gray-400 text-4xl">📦</span>
                            </div>
                        @endif
                        <h3 class="font-semibold mb-2">{{ $relatedProduct->name }}</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary-600">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="text-primary-600 hover:text-primary-800">
                                View →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection