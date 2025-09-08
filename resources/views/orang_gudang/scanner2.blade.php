<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Scan Barcode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex justify-center items-center min-h-screen p-4">

    <div class="bg-white shadow-2xl rounded-2xl p-6 md:p-8 text-center w-full max-w-lg animate-fadeIn">
        <!-- Judul -->
        <h1 class="text-2xl md:text-3xl font-extrabold mb-4 text-gray-800">📷 Scan Barcode</h1>

        <!-- Scanner Wrapper -->
        <div class="mx-auto w-full max-w-[360px] aspect-square">
            <div id="reader" class="rounded-xl overflow-hidden border border-gray-200 shadow"></div>
        </div>

        <!-- Deskripsi -->
        <p class="mt-6 text-gray-600 text-sm md:text-base">
            Pindai kode QR produk untuk mendapatkan informasi secara langsung.
        </p>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex justify-center">
            <a href="{{ route('produk.index') }}" 
               class="px-6 py-2.5 bg-blue-500 text-white text-sm md:text-base rounded-lg shadow hover:bg-blue-600 hover:shadow-lg transition duration-200">
                ⬅️ Kembali
            </a>
        </div>
    </div>

    <!-- Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            fetch("{{ route('orang_gudang.produk.scanner') }}", {
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
                    alert("Produk: " + data.data.name);
                } else {
                    alert(data.message);
                }
            });
        }

        function onScanFailure(error) {
            // error scanning → diamkan agar tidak spam console
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { fps: 10, qrbox: { width: 250, height: 250 } }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</body>
</html>
