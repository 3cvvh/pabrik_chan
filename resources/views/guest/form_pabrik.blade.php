@extends('layout.main')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
	<h1 class="text-2xl font-semibold mb-6">Form Pembuatan Pabrik</h1>

	<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
		<form id="pabrikForm" action="{{ route('guest.storePabrik',Auth::user()->id) }}" method="POST" novalidate class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border">
			@csrf
			<div class="space-y-4">
				<div>
					<label for="nama_pabrik" class="block text-sm font-medium text-gray-700">Nama Pabrik</label>
					<input type="text" name="nama_pabrik" id="nama_pabrik" maxlength="100" required placeholder="Masukkan nama pabrik"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
					<div class="flex justify-between text-xs text-gray-500 mt-1">
						<span id="nama_count">0</span>
						<span> / 100</span>
					</div>
				</div>

				<div>
					<label for="alamat_pabrik" class="block text-sm font-medium text-gray-700">Alamat Pabrik</label>
					<textarea name="alamat_pabrik" id="alamat_pabrik" rows="3" maxlength="200" required placeholder="Masukkan alamat lengkap"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
					<div class="flex justify-between text-xs text-gray-500 mt-1">
						<span id="alamat_count">0</span>
						<span> / 200</span>
					</div>
				</div>

				<div>
					<label for="nomor_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
					<input type="tel" name="nomor_telepon" id="nomor_telepon" placeholder="+628xxxxxxxx" pattern="^\+?\d{7,15}$"
						class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
					<p class="text-xs text-gray-400 mt-1">Hanya angka, boleh diawali + · 7–15 digit</p>
				</div>

				<div class="flex items-center gap-3 mt-2">
					<button type="submit"
						class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 disabled:opacity-60">
						Buat Pabrik
					</button>
		</form>
<a href="{{ route('guest.index') }}" class="text-indigo-600 text-sm hover:underline">Kembali</a>
				</div>
			</div>
		<aside class="preview bg-gray-50 p-6 rounded-lg border">
			<h2 class="text-lg font-medium mb-3">Preview</h2>
			<div class="space-y-3 text-sm text-gray-700">
				<p><span class="font-semibold">Nama:</span> <span id="previewNama">-</span></p>
				<p><span class="font-semibold">Alamat:</span> <span id="previewAlamat">-</span></p>
				<p><span class="font-semibold">Telepon:</span> <span id="previewTel">-</span></p>
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
	const submitBtn = document.getElementById('submitBtn');

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
