@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Products</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
            </div>
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Categories</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_categories'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stats['pending_orders'] }} pending</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Today: Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Low Stock -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold">Recent Orders</h2>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                            <div>
                                <p class="font-semibold">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->items->count() }} items</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                @if($order->status == 'pending')
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Pending</span>
                                @else
                                    <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Paid</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.orders.index') }}" class="block text-center text-primary-600 hover:text-primary-800 font-semibold mt-4">
                    View All Orders →
                </a>
            @else
                <p class="text-gray-500 text-center py-8">No orders yet</p>
            @endif
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold">Low Stock Products</h2>
        </div>
        <div class="p-6">
            @if($lowStockProducts->count() > 0)
                <div class="space-y-4">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between border-b pb-3 last:border-b-0 last:pb-0">
                            <div class="flex items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded mr-3">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                        <span class="text-gray-400">📦</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">
                                    {{ $product->stock }} left
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.products.index') }}" class="block text-center text-primary-600 hover:text-primary-800 font-semibold mt-4">
                    View All Products →
                </a>
            @else
                <p class="text-gray-500 text-center py-8">All products have sufficient stock</p>
            @endif
        </div>
    </div>
</div>
@endsection