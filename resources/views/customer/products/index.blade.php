@extends('layouts.customer')

@section('title', 'Products - ScanMart')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">All Products</h1>

    <!-- Search & Filter -->
    <div class="card mb-8">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="input-field">
            </div>

            <!-- Category Filter -->
            <div>
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3 flex space-x-2">
                <button type="submit" class="btn-primary">
                    Search
                </button>
                <a href="{{ route('products.index') }}" class="btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <div class="card hover:shadow-lg transition">
                    <!-- Product Image -->
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-6xl">{{ $product->category->icon ?? '📦' }}</span>
                        </div>
                    @endif

                    <!-- Product Info -->
                    <div class="mb-2">
                        <span class="text-xs bg-primary-100 text-primary-600 px-2 py-1 rounded font-semibold">{{ $product->category->name }}</span>
                    </div>
                    <h3 class="font-semibold mb-2 h-12 overflow-hidden text-lg">{{ $product->name }}</h3>
                    
                    @if($product->weight)
                        <p class="text-sm text-gray-600 mb-2">{{ $product->weight }}</p>
                    @endif

                    <!-- Price & Stock -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-bold text-primary-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @if($product->stock > 0)
                            <span class="text-xs text-green-600 font-semibold">✓ In Stock</span>
                        @else
                            <span class="text-xs text-red-600 font-semibold">✗ Out of Stock</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <a href="{{ route('product.show', $product->slug) }}" class="btn-primary w-full text-center block">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-600">No products found</p>
        </div>
    @endif
</div>
@endsection