<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scan Barcode</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 -100 flex justify-center items-center min-h-screen">

    <div class="bg-white shadow-lg rounded-xl p-6 text-center w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Scan Barcode</h1>

        <!-- Bungkus scanner -->
        <div class="mx-auto max-w-[350px]">
            <div id="reader" class="rounded-lg overflow-hidden"></div>
        </div>

        <p class="mt-4 text-gray-600 text-base">
            Pindai kode QR produk untuk mendapatkan informasi.
        </p>
         <div class="flex gap-4">
        <a href="{{ route('produk.index') }}" 
        class="mt-6 inline-block bg-blue-400 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 hover:shadow transition-all duration-200">Kembali
    </a>
    </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            // Kirim ke Laravel
            fetch("{{ route('admin.produk.scanner.process') }}", {
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
        window.location.href = "{{ url('/dashboard/admin/produk') }}/" + data.data.id;
    } else {
        alert(data.message);
    }
});

        }

        function onScanFailure(error) {
            // console.warn(Code scan error = ${error});
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { fps: 10, qrbox: { width: 250, height: 250 } }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</body>
</html>