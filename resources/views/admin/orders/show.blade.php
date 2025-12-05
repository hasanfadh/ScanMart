@extends('layouts.admin')

@section('page-title', 'Order Details')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-primary-600 hover:text-primary-800 font-semibold">
            ← Back to Orders
        </a>
    </div>

    <!-- Order Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">{{ $order->order_number }}</h2>
                <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                @if($order->status == 'pending')
                    <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-semibold">
                        Pending Payment
                    </span>
                @else
                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                        Paid
                    </span>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                <p class="text-xl font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600 mb-1">Tax (11%)</p>
                <p class="text-xl font-bold">Rp {{ number_format($order->tax, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-600 mb-1">Service Fee</p>
                <p class="text-xl font-bold">Rp {{ number_format($order->service_fee, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold">Total Amount</span>
                <span class="text-2xl font-bold text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">Order Items</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center border-b pb-4 last:border-b-0 last:pb-0">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-20 h-20 object-cover rounded mr-4">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded mr-4 flex items-center justify-center">
                            <span class="text-gray-400 text-2xl">📦</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-semibold text-lg">{{ $item->product_name }}</h4>
                        <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                        <p class="text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Actions -->
    @if($order->status == 'pending')
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold mb-4">Order Actions</h3>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="btn-primary" onclick="return confirm('Mark this order as paid?')">
                    Mark as Paid
                </button>
            </form>
        </div>
    @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-green-900">Order Completed</h4>
                    <p class="text-sm text-green-800">Payment received on {{ $order->paid_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection