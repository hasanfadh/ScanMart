@extends('layouts.customer')

@section('title', 'Scan QR Code - ScanMart')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="card">
        <h1 class="text-3xl font-bold mb-6 text-center">Scan Product QR Code</h1>
        
        <!-- QR Scanner -->
        <div class="mb-6">
            <div id="reader" class="rounded-lg overflow-hidden shadow-lg" style="display: none;"></div>
            <div id="scanner-placeholder" class="bg-gray-100 rounded-lg p-12 text-center">
                <svg class="w-32 h-32 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <p class="text-gray-600 mb-4">Point your camera at the product QR code</p>
                <button id="startScan" class="btn-primary">
                    📷 Start Camera
                </button>
            </div>
            
            <!-- Loading State -->
            <div id="loading-message" class="mt-4 hidden">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded text-center">
                    <p class="font-semibold">📷 Initializing camera...</p>
                    <p class="text-sm">Please allow camera access when prompted</p>
                </div>
            </div>
            
            <!-- Result Message -->
            <div id="result-message" class="mt-4 hidden">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <p class="font-semibold">✓ QR Code Detected!</p>
                    <p class="text-sm">Redirecting to product...</p>
                </div>
            </div>
            
            <!-- Error Message -->
            <div id="error-message" class="mt-4 hidden">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">✗ Camera Error</p>
                    <p class="text-sm" id="error-text"></p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">OR</span>
            </div>
        </div>

        <!-- Manual Input -->
        <div>
            <h3 class="text-lg font-semibold mb-4">Enter Product Code Manually</h3>
            <form action="{{ route('search.code') }}" method="POST">
                @csrf
                <div class="flex space-x-4">
                    <input type="text" name="code" placeholder="Enter SKU or product code" class="input-field flex-1" required>
                    <button type="submit" class="btn-primary">
                        🔍 Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Instructions -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-900 mb-2">💡 Tips:</h4>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• Make sure the QR code is well-lit and in focus</li>
                <li>• Hold your device steady when scanning</li>
                <li>• Allow camera permission when prompted</li>
                <li>• If camera doesn't work, use manual input below</li>
            </ul>
        </div>
    </div>
</div>

<!-- Load library from CDN -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrcodeScanner = null;
    
    document.getElementById('startScan').addEventListener('click', function() {
        console.log('Start button clicked');
        
        // Hide placeholder, show loading
        document.getElementById('scanner-placeholder').style.display = 'none';
        document.getElementById('loading-message').classList.remove('hidden');
        document.getElementById('reader').style.display = 'block';
        
        try {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { 
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true,
                    aspectRatio: 1.0
                },
                false
            );
            
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            
            // Hide loading after scanner renders
            setTimeout(() => {
                document.getElementById('loading-message').classList.add('hidden');
            }, 2000);
            
        } catch (error) {
            console.error('Scanner initialization error:', error);
            showError('Failed to initialize scanner: ' + error.message);
        }
    });
    
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`QR Code detected: ${decodedText}`);
        
        // Show success message
        document.getElementById('result-message').classList.remove('hidden');
        
        // Stop scanning
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(err => console.error('Clear error:', err));
        }
        
        // Check if it's a URL or product code
        if (decodedText.includes('http') || decodedText.includes('product/')) {
            // It's a URL, navigate directly
            setTimeout(() => {
                window.location.href = decodedText;
            }, 1000);
        } else {
            // It's a product code/SKU, search it
            setTimeout(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("search.code") }}';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const codeInput = document.createElement('input');
                codeInput.type = 'hidden';
                codeInput.name = 'code';
                codeInput.value = decodedText;
                
                form.appendChild(csrfInput);
                form.appendChild(codeInput);
                document.body.appendChild(form);
                form.submit();
            }, 1000);
        }
    }
    
    function onScanFailure(error) {
        // Ignore scan failures (too noisy)
        // console.warn(`Scan error: ${error}`);
    }
    
    function showError(message) {
        document.getElementById('loading-message').classList.add('hidden');
        document.getElementById('error-message').classList.remove('hidden');
        document.getElementById('error-text').textContent = message;
    }
</script>
@endsection