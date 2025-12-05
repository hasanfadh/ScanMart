@extends('layouts.customer')

@section('title', 'Payment - ScanMart')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="card">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold mb-2">Complete Payment</h1>
            <p class="text-gray-600">Order: {{ $order->order_number }}</p>
        </div>

        <!-- Order Summary -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="font-semibold mb-4">Order Summary</h3>
            <div class="space-y-2 text-sm">
                @foreach($order->items as $item)
                    <div class="flex justify-between">
                        <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="border-t pt-2 mt-2 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- QRIS Dummy -->
        <div class="text-center mb-6">
            <h3 class="font-semibold mb-4">Scan QRIS to Pay</h3>
            <div class="bg-white border-4 border-primary-600 rounded-lg p-6 inline-block">
                <!-- Dummy QRIS Image -->
                <div class="w-64 h-64 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-32 h-32 text-primary-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <p class="text-sm text-primary-600 font-semibold">QRIS Code</p>
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-4">Scan this QR code using any e-wallet app</p>
        </div>

        <!-- Supported Payment Methods -->
        <div class="mb-6">
            <p class="text-sm text-gray-600 text-center mb-3">Supported payment methods:</p>
            <div class="flex justify-center space-x-4">
                <div class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-semibold">GoPay</div>
                <div class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-semibold">OVO</div>
                <div class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-semibold">DANA</div>
                <div class="px-4 py-2 bg-gray-100 rounded-lg text-sm font-semibold">ShopeePay</div>
            </div>
        </div>

        <!-- Testing Mode Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-yellow-900 mb-1">Testing Mode</h4>
                    <p class="text-sm text-yellow-800">This is a simulated payment. Click "I Have Paid" to complete your order instantly.</p>
                </div>
            </div>
        </div>

        <!-- Payment Confirmation -->
        <form action="{{ route('checkout.confirm', $order->order_number) }}" method="POST">
            @csrf
            <button type="submit" class="btn-primary w-full">
                I Have Paid
            </button>
        </form>

        <a href="{{ route('home') }}" class="btn-secondary w-full text-center block mt-3">
            Cancel
        </a>
    </div>
</div>
@endsection