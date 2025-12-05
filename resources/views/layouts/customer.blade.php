<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScanMart - Self Checkout Shopping')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50 border-b-2 border-gray-100">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-2xl">🛒</span>
                    </div>
                    <span class="text-xl font-bold text-primary-600">ScanMart</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 transition">Home</a>
                    <a href="{{ route('scan') }}" class="text-gray-700 hover:text-primary-600 transition">Scan QR</a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-600 transition">Products</a>
                </div>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
                    <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php
                        $cartCount = 0;
                        if (session()->has('cart_session_id')) {
                            $cartCount = \App\Models\Cart::getItemCountForSession(session('cart_session_id'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen py-8 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t-2 border-gray-200 mt-16">
        <div class="container mx-auto px-4 lg:px-8 max-w-7xl py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-2xl">🛒</span>
                        </div>
                        <h3 class="font-bold text-xl text-primary-600">ScanMart</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Self-checkout shopping made easy with QR Code technology. Shop smarter, faster, better.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition">🏠 Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-primary-600 transition">🛍️ Products</a></li>
                        <li><a href="{{ route('scan') }}" class="text-gray-600 hover:text-primary-600 transition">📱 Scan QR</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-primary-600 transition">🛒 Cart</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Contact Us</h3>
                    <p class="text-gray-600 text-sm mb-2">📧 Email: info@scanmart.com</p>
                    <p class="text-gray-600 text-sm mb-2">📞 Phone: (021) 1234-5678</p>
                    <p class="text-gray-600 text-sm">📍 Surabaya, Indonesia</p>
                </div>
            </div>
            <div class="border-t mt-8 pt-6 text-center">
                <p class="text-gray-600 text-sm">&copy; 2025 ScanMart. Made with ❤️ for Universitas Airlangga</p>
            </div>
        </div>
    </footer>
</body>
</html>