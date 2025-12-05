@extends('layouts.admin')

@section('page-title', 'Orders Management')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold mb-4">Orders</h1>
    
    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <select name="status" class="input-field">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div>
                <input type="date" name="date" value="{{ request('date') }}" class="input-field">
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="btn-primary">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-sm">
                            <p>{{ $order->created_at->format('d M Y') }}</p>
                            <p class="text-gray-600 text-xs">{{ $order->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 font-bold text-primary-600">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    Pending
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    Paid
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary-600 hover:text-primary-800 font-semibold text-sm">
                                View Details →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t">
        {{ $orders->links() }}
    </div>
</div>
@endsection