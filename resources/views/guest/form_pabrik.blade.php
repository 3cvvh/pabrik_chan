@extends('layout.main')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-extrabold text-blue-700 mb-8 text-center tracking-tight">Form Pembuatan Pabrik</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @if ($errors->any())
            @foreach ($error->all() as $errorMsg )
                <div class="md:col-span-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errorMsg }}</span>
                </div>
            @endforeach
        @endif
        <form id="pabrikForm" action="{{ route('guest.storePabrik',Auth::user()->id) }}" method="POST" novalidate class="md:col-span-2 bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="nama_pabrik" class="block text-sm font-semibold text-blue-700 mb-1">Nama Pabrik</label>
                    <input type="text" name="nama_pabrik" id="nama_pabrik" maxlength="100" required placeholder="Masukkan nama pabrik"
                        class="mt-1 block w-full rounded-lg border-blue-200 shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-2 transition-all duration-200">
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span id="nama_count">0</span>
                        <span>/ 100</span>
                    </div>
                </div>
                <div>
                    <label for="alamat_pabrik" class="block text-sm font-semibold text-blue-700 mb-1">Alamat Pabrik</label>
                    <textarea name="alamat_pabrik" id="alamat_pabrik" rows="3" maxlength="200" required placeholder="Masukkan alamat lengkap"
                        class="mt-1 block w-full rounded-lg border-blue-200 shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-2 transition-all duration-200"></textarea>
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span id="alamat_count">0</span>
                        <span>/ 200</span>
                    </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-blue-700 mb-1">Email</label>
                    <input name="email" id="email" type="email" rows="3" maxlength="200" required placeholder="Masukkan alamat lengkap"
                        class="mt-1 block w-full rounded-lg border-blue-200 shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-2 transition-all duration-200"></input>
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span id="alamat_count">0</span>
                        <span>/ 200</span>
                    </div>
                </div>
                <div>
                    <label for="nomor_telepon" class="block text-sm font-semibold text-blue-700 mb-1">No. Telepon</label>
                    <input type="tel" name="nomor_telepon" id="nomor_telepon" placeholder="+628xxxxxxxx" pattern="^\+?\d{7,15}$"
                        class="mt-1 block w-full rounded-lg border-blue-200 shadow focus:border-blue-500 focus:ring-blue-500 text-base px-4 py-2 transition-all duration-200">
                    <p class="text-xs text-gray-400 mt-1">Hanya angka, boleh diawali + · 7–15 digit</p>
                </div>
                <div class="flex items-center gap-4 mt-4">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-base font-semibold rounded-lg shadow hover:bg-blue-700 hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        id="submitBtn">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Pabrik
                    </button>
                    <a href="{{ route('guest.index') }}" class="text-blue-600 text-base font-semibold hover:underline transition">Kembali</a>
                </div>
            </div>
        </form>
        <aside class="preview bg-blue-50 p-8 rounded-2xl border border-blue-100 shadow flex flex-col items-center">
            <h2 class="text-lg font-bold text-blue-700 mb-4">Preview</h2>
            <div class="flex flex-col items-start w-full space-y-2 text-base text-gray-700">
                <p><span class="font-semibold text-blue-700">Nama:</span> <span id="previewNama">-</span></p>
                <p><span class="font-semibold text-blue-700">Alamat:</span> <span id="previewAlamat">-</span></p>
                <p><span class="font-semibold text-blue-700">Telepon:</span> <span id="previewTel">-</span></p>
            </div>
        </aside>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed right-4 bottom-4 transform translate-y-8 opacity-0 transition-all duration-300 pointer-events-none z-50">
        <div id="toastInner" class="max-w-xs px-4 py-2 rounded-md text-white text-sm"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('pabrikForm');
    const nama = document.getElementById('nama_pabrik');
    const alamat = document.getElementById('alamat_pabrik');
    const tel = document.getElementById('nomor_telepon');
    const namaCount = document.getElementById('nama_count');
    const alamatCount = document.getElementById('alamat_count');
    const previewNama = document.getElementById('previewNama');
    const previewAlamat = document.getElementById('previewAlamat');
    const previewTel = document.getElementById('previewTel');
    const toast = document.getElementById('toast');
    const toastInner = document.getElementById('toastInner');

    function updateAll(){
        namaCount.textContent = nama.value.length;
        alamatCount.textContent = alamat.value.length;
        previewNama.textContent = nama.value || '-';
        previewAlamat.textContent = alamat.value || '-';
        previewTel.textContent = tel.value || '-';
    }

    [nama, alamat, tel].forEach(el => el.addEventListener('input', function(){
        if (this === tel) {
            let v = this.value;
            v = v.replace(/[^\d+]/g,'');
            if (v.indexOf('+') > 0) v = v.replace(/\+/g,'');
            this.value = v;
        }
        updateAll();
    }));

    updateAll();

    function showToast(message, type='info', time=3500){
        toastInner.textContent = message;
        toast.classList.remove('translate-y-8','opacity-0','pointer-events-none');
        if (type === 'success') {
            toastInner.className = 'max-w-xs px-4 py-2 rounded-md text-white text-sm bg-green-600';
        } else if (type === 'error') {
            toastInner.className = 'max-w-xs px-4 py-2 rounded-md text-white text-sm bg-red-600';
        } else {
            toastInner.className = 'max-w-xs px-4 py-2 rounded-md text-white text-sm bg-gray-800';
        }
        clearTimeout(toast._t);
        toast._t = setTimeout(()=> {
            toast.classList.add('translate-y-8','opacity-0','pointer-events-none');
        }, time);
    };
});
</script>
@endsection
