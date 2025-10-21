@extends('layout.main')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-semibold">Daftar Pabrik</h1>

		<!-- Tombol kembali: gunakan history.back() jika tersedia, fallback ke route -->
		<button id="backBtn" type="button" data-fallback="{{ route('guest.index') }}"
			class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 text-sm rounded-md hover:bg-gray-300">
			Kembali
		</button>
	</div>

	<div class="grid gap-6 sm:grid-cols-2">
		@foreach ($allpabrik as $index => $pabrik )
		<div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition p-5 border">
			<div class="flex items-start gap-4">
				<div class="flex-shrink-0">
					<div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold">
						{{ strtoupper(substr($pabrik->name ?? '', 0, 1)) }}
					</div>
				</div>

				<div class="flex-1 min-w-0">
					<h2 class="text-lg font-semibold text-gray-800 truncate">{{ $pabrik->name }}</h2>
					<p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $pabrik->alamat }}</p>

					<div class="mt-4">
						<form class="requestForm" data-id="{{ $pabrik->id ?? $index }}" action="" method="POST">
							@csrf
							<button type="submit"
								class="requestBtn inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
								Ajukan Permohonan Bergabung
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>

<!-- Toast -->
<div id="toast" class="fixed right-4 bottom-4 transform translate-y-8 opacity-0 transition-all duration-300 pointer-events-none z-50">
	<div id="toastInner" class="max-w-xs px-4 py-2 rounded-md text-white text-sm"></div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
	const toast = document.getElementById('toast');
	const toastInner = document.getElementById('toastInner');

	function showToast(msg, type='info', time=3000){
		toastInner.textContent = msg;
		toast.classList.remove('translate-y-8','opacity-0','pointer-events-none');
		toastInner.className = 'max-w-xs px-4 py-2 rounded-md text-white text-sm ' + (type==='success'?'bg-green-600':type==='error'?'bg-red-600':'bg-gray-800');
		clearTimeout(toast._t);
		toast._t = setTimeout(()=> toast.classList.add('translate-y-8','opacity-0','pointer-events-none'), time);
	}

	document.querySelectorAll('.requestForm').forEach(form => {
		form.addEventListener('submit', function(e){
			e.preventDefault();
			const btn = form.querySelector('.requestBtn');
			const nameEl = form.closest('div').querySelector('h2');
			const targetName = nameEl ? nameEl.textContent.trim() : 'pabrik';

			// gunakan SweetAlert2 untuk konfirmasi
			Swal.fire({
				title: 'Konfirmasi',
				text: 'peringatan anda hanya bisa mengajukan permohonan 1 kali seumur hidup',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, ajukan',
				cancelButtonText: 'Batal'
			}).then(result => {
				if (!result.isConfirmed) {
					// dibatalkan oleh user
					return;
				}

				// user mengonfirmasi -> lanjutkan submit via fetch
				btn.disabled = true;
				const url = form.getAttribute('action') || window.location.href;
				const fd = new FormData(form);

				fetch(url, {
					method: 'POST',
					body: fd,
					headers: { 'X-Requested-With': 'XMLHttpRequest' }
				}).then(res => {
					btn.disabled = false;
					if (res.ok) return res.json().catch(()=>({ success:true }));
					throw new Error('Server error');
				}).then(data => {
					showToast('Permohonan berhasil dikirim.', 'success', 4000);
				}).catch(err => {
					btn.disabled = false;
					showToast('Gagal mengirim: ' + err.message, 'error', 5000);
				});
			});
		});
	});

	// Tambah handler untuk tombol kembali tanpa merusak script lama
	const backBtn = document.getElementById('backBtn');
	if (backBtn) {
		backBtn.addEventListener('click', function(){
			// Jika ada riwayat navigasi, gunakan history.back()
			if (window.history && window.history.length > 1) {
				window.history.back();
				return;
			}
			// Fallback ke route jika tidak ada riwayat yang dapat kembali
			const fallback = this.dataset.fallback || '/';
			window.location.href = fallback;
		});
	}
});
</script>
@endsection
