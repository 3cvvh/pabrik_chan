<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scan Barcode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @keyframes pulse-border {
            0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        }
        .pulse-border { animation: pulse-border 2s infinite; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white shadow-2xl rounded-2xl p-6 sm:p-8 w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-block bg-blue-100 p-3 rounded-full mb-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Scan Produk</h1>
            <p class="text-gray-500 text-sm mt-1">Arahkan kamera ke QR Code</p>
        </div>

        <!-- Scanner Area -->
        <div class="mb-6">
            <div class="bg-gray-100 rounded-xl p-4 border-2 border-dashed border-blue-300 pulse-border">
                <div id="reader" class="rounded-lg overflow-hidden bg-black"></div>
            </div>
            <p class="text-center text-gray-600 text-sm mt-3">
                📱 Pastikan pencahayaan cukup untuk hasil terbaik
            </p>
        </div>

        <!-- Status Info -->
        <div id="status-box" class="hidden mb-4 p-3 rounded-lg text-center text-sm font-semibold">
            <div id="status-text"></div>
        </div>

        <!-- Result Display -->
        <div id="result-box" class="hidden mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
            <p class="text-green-700 text-sm"><strong>✓ Produk Ditemukan!</strong></p>
            <p id="result-name" class="text-gray-700 text-xs mt-1"></p>
        </div>

        <!-- Button -->
        <div class="flex flex-col gap-3">
            <a href="{{ Auth::user()->role_id == 1 ?  route('produk.index') : route('crud_produk.index') }}"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg text-center">
                ← Kembali
            </a>
            <button id="retry-btn" class="hidden w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                Scan Lagi
            </button>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner;
        let isScanning = true;

        function showStatus(message, type = 'info') {
            const statusBox = document.getElementById('status-box');
            const statusText = document.getElementById('status-text');
            statusBox.classList.remove('hidden', 'bg-blue-50', 'text-blue-700', 'bg-red-50', 'text-red-700');

            if (type === 'success') {
                statusBox.classList.add('bg-green-50', 'text-green-700');
            } else if (type === 'error') {
                statusBox.classList.add('bg-red-50', 'text-red-700');
            } else {
                statusBox.classList.add('bg-blue-50', 'text-blue-700');
            }

            statusText.textContent = message;
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanning) return;
            isScanning = false;

            console.log(`Code matched = ${decodedText}`, decodedResult);
            html5QrcodeScanner.pause(true);
            showStatus('⏳ Memproses...', 'info');

            fetch("{{ Auth::user()->role_id == 1 ?  route('admin.produk.scanner.process') : route('orang_gudang.produk.scanner.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ barcode: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showStatus('✓ Berhasil! Mengalihkan...', 'success');
                    document.getElementById('result-box').classList.remove('hidden');
                    document.getElementById('result-name').textContent = `ID: ${data.data.id}`;
                    document.getElementById('retry-btn').classList.add('hidden');
                    setTimeout(() => {
                        window.location.href = "{{ route('produk.show', ':id') }}".replace(':id', data.data.id);
                    }, 1000);
                } else {
                    showStatus('✗ ' + (data.message || 'Produk tidak ditemukan'), 'error');
                    document.getElementById('retry-btn').classList.remove('hidden');
                    isScanning = true;
                    html5QrcodeScanner.resume();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('✗ Terjadi kesalahan', 'error');
                document.getElementById('retry-btn').classList.remove('hidden');
                isScanning = true;
                html5QrcodeScanner.resume();
            });
        }

        function onScanFailure(error) {
            // Ignore scan failures
        }

        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: { width: 250, height: 250 } }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        // Retry button
        document.getElementById('retry-btn').addEventListener('click', function() {
            document.getElementById('status-box').classList.add('hidden');
            document.getElementById('result-box').classList.add('hidden');
            this.classList.add('hidden');
            isScanning = true;
            html5QrcodeScanner.resume();
        });
    </script>
</body>
</html>
