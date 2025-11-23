@extends('layout.main')
@section('content')
<x-navbar></x-navbar>
@php
// jika controller tidak mengirim $pabrik, gunakan data dummy sementara
$pabriks = Auth::user()->pabrik;
if (!isset($pabrik)) {
	$pabrik = (object)[
        'id' => $pabriks->id,
		'name' => $pabriks->name,
		'alamat' => $pabriks->alamat,
		'no_telepon' => $pabriks->no_telepon,
		'email' => $pabriks->email,
        'logo' => $pabriks->gambar ? 'Storage/' . $pabriks->gambar : 'img/my-bini.png' ,
	];
	$isDummy = true;
} else {
	$isDummy = false;
}
@endphp
{{-- Ganti tampilan utama menjadi dua kolom: kiri = profil/avatar, kanan = form tampilan --}}
<div class="container mx-auto p-6">
	<h1 class="text-2xl font-semibold mb-6">Data Pabrik</h1>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endforeach

    @endif

	<div class="bg-white shadow rounded-lg overflow-hidden flex flex-col md:flex-row">
		<!-- LEFT: sidebar profil -->
		<div class="md:w-1/3 bg-gradient-to-b from-blue-700 to-blue-800 p-6 text-white flex flex-col items-center justify-center">
			<div class="w-full flex flex-col items-center">
				{{-- Logo memenuhi kotak kiri --}}
				<div class="w-full aspect-square flex items-center justify-center">
					<img
						id="pabrik-logo-img"
                        @if ($pabrik->logo)
	                    src="{{ asset($pabrik->logo) }}"
                        @endif
						alt="Logo Pabrik"
						class="w-full h-full object-contain rounded-full bg-white border-4 border-white shadow-md cursor-pointer"
						style="max-width: 320px; max-height: 320px;"
                        data-original="@if (isset($pabriks->logo)){{ asset($pabrik->gambar) }}@endif"
					/>
				</div>

				<!-- optional small caption -->
				<div class="mt-3 text-sm text-white/90">
					<span class="font-medium">{{ $pabrik->name }}</span>
				</div>


				<!-- About -->
				<div class="mt-6 w-full">

				</div>
			</div>
		</div>

		<!-- RIGHT: card with form-like display -->
		<div class="md:w-2/3 p-6">
			<div class="bg-white p-6 rounded-lg shadow-sm border">
				<div class="flex justify-between items-center mb-4">
					<h3 class="text-lg font-semibold">Detail Pabrik</h3>
					<button
						id="openEditBtn"
						class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
						data-id="{{ $pabrik->id }}"
						data-name="{{ htmlspecialchars($pabrik->name, ENT_QUOTES, 'UTF-8') }}"
						data-alamat="{{ htmlspecialchars($pabrik->alamat, ENT_QUOTES, 'UTF-8') }}"
						data-no_telepon="{{ htmlspecialchars($pabrik->no_telepon, ENT_QUOTES, 'UTF-8') }}"
						data-email="{{ htmlspecialchars($pabrik->email, ENT_QUOTES, 'UTF-8') }}"
						data-update-url="{{ route('update.pabrik',$pabrik->id) }}"
						data-dummy="{{ $isDummy ? '1' : '0' }}"
					>Edit</button>
				</div>

				<!-- Styled info rows (mirip input fields but readonly look) -->
				<div class="grid grid-cols-1 gap-4">

					<div>
						<label class="block text-sm text-gray-500">Nama</label>
						<div class="mt-1 bg-gray-100 rounded px-3 py-2" id="pabrik-name">{{ $pabrik->name }}</div>
					</div>

					<div>
						<label class="block text-sm text-gray-500">Alamat</label>
						<div class="mt-1 bg-gray-100 rounded px-3 py-2" id="pabrik-alamat">{{ $pabrik->alamat }}</div>
					</div>

					<div class="grid grid-cols-2 gap-4">
						<div>
							<label class="block text-sm text-gray-500">No. Telepon</label>
							<div class="mt-1 bg-gray-100 rounded px-3 py-2" id="pabrik-telepon">{{ $pabrik->no_telepon }}</div>
						</div>
						<div>
							<label class="block text-sm text-gray-500">Email</label>
							<div class="mt-1 bg-gray-100 rounded px-3 py-2" id="pabrik-email">{{ $pabrik->email }}</div>
						</div>
					</div>
				</div>

				<!-- optional footer -->
				<div class="mt-6 text-right">
					<a href="#" class="text-sm text-gray-500 hover:underline">Last updated: {{ Auth::user()->pabrik->updated_at->diffForHumans() }}</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40 px-4">
	<div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
		<div class="px-6 py-4 border-b">
			<h2 class="text-lg font-semibold">Edit Pabrik</h2>
		</div>
		<form method="post" action="{{ route('update.pabrik',$pabriks->id) }}" enctype="multipart/form-data" id="editForm" class="px-6 py-4" data-update-url="">
            @csrf
            @method('put')
			<div class="space-y-3">
				<div>
					<label class="block text-sm font-medium text-gray-700">Nama</label>
					<input id="form_pabrik_name" name="name" type="text" required class="mt-1 block w-full border rounded px-3 py-2" />
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700">Alamat</label>
					<input id="form_pabrik_alamat" name="alamat" type="text" class="mt-1 block w-full border rounded px-3 py-2" />
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700">No. Telepon</label>
					<input id="form_pabrik_telepon" name="no_telepon" type="number" class="mt-1 block w-full border rounded px-3 py-2" />
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700">Email</label>
					<input id="form_pabrik_email" name="email" type="email" class="mt-1 block w-full border rounded px-3 py-2" />
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700">Logo Pabrik</label>
					<input id="form_pabrik_image" name="gambar" type="file" accept="image/*" class="mt-1 block w-full border rounded px-3 py-2" />
				</div>
			</div>

			<div class="mt-4 flex justify-end space-x-2 border-t pt-3">
				<button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
				<button type="submit" id="saveBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
			</div>
		</form>
	</div>
</div>

<!-- Logo preview modal -->
<div id="logoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4">
	<div class="bg-transparent">
		<img id="logoModalImg" src="" alt="Logo besar" class="max-w-full max-h-[80vh] rounded" />
	</div>
</div>

<x-alert></x-alert>

<script>
    <x-alert></x-alert>
	(function(){
		// Element refs
		const editModal = document.getElementById('editModal');
		const openEditBtn = document.getElementById('openEditBtn');
		const cancelBtn = document.getElementById('cancelBtn');
		const editForm = document.getElementById('editForm');

		const inputName = document.getElementById('form_pabrik_name');
		const inputAlamat = document.getElementById('form_pabrik_alamat');
		const inputTelp = document.getElementById('form_pabrik_telepon');
		const inputEmail = document.getElementById('form_pabrik_email');
        const inputGambar = document.getElementById('form_pabrik_image');

		const logoImg = document.getElementById('pabrik-logo-img');
		let currentPreviewUrl = null;

		// preview when selecting a file
		if(inputGambar){
			inputGambar.addEventListener('change', function(){
				if(this.files && this.files[0]){
					// revoke previous preview if any
					if(currentPreviewUrl) URL.revokeObjectURL(currentPreviewUrl);
					currentPreviewUrl = URL.createObjectURL(this.files[0]);
					if(logoImg) logoImg.src = currentPreviewUrl;
				} else {
					// restore original image
					if(currentPreviewUrl){ URL.revokeObjectURL(currentPreviewUrl); currentPreviewUrl = null; }
					if(logoImg && logoImg.dataset && logoImg.dataset.original) logoImg.src = logoImg.dataset.original;
				}
			});
		}

		function openModal(){
			if(!editModal) return;
			editModal.classList.remove('hidden');
			editModal.classList.add('flex');
			document.body.classList.add('overflow-hidden');
		}
		function closeModal(){
			if(!editModal) return;
			editModal.classList.add('hidden');
			editModal.classList.remove('flex');
			document.body.classList.remove('overflow-hidden');
		}

		// Open edit modal and populate form from button data-*
		openEditBtn && openEditBtn.addEventListener('click', function(){
			const btn = this;
			inputName && (inputName.value = btn.dataset.name || '');
			inputAlamat && (inputAlamat.value = btn.dataset.alamat || '');
			inputTelp && (inputTelp.value = btn.dataset.no_telepon || '');
			inputEmail && (inputEmail.value = btn.dataset.email || '');
            if(inputGambar){
				// reset file input
				inputGambar.value = '';
				// revoke any preview and restore original image
				if(currentPreviewUrl){ URL.revokeObjectURL(currentPreviewUrl); currentPreviewUrl = null; }
				if(logoImg && logoImg.dataset && logoImg.dataset.original) logoImg.src = logoImg.dataset.original;
			}

			if(editForm && btn.dataset.updateUrl){
				editForm.setAttribute('action', btn.dataset.updateUrl);
			}
			openModal();
		});

		// Cancel button
		cancelBtn && cancelBtn.addEventListener('click', function(e){
			e.preventDefault();
			closeModal();
		});

		// Close by clicking overlay (outside modal content)
		editModal && editModal.addEventListener('click', function(e){
			if(e.target === editModal) closeModal();
		});

		// Close on ESC
		document.addEventListener('keydown', function(e){
			if(e.key === 'Escape'){
				if(editModal && !editModal.classList.contains('hidden')) closeModal();
				// also close logo modal if open
				const logoModal = document.getElementById('logoModal');
				if(logoModal && !logoModal.classList.contains('hidden')){
					logoModal.classList.add('hidden'); logoModal.classList.remove('flex');
					document.body.classList.remove('overflow-hidden');
					const logoModalImg = document.getElementById('logoModalImg'); if(logoModalImg) logoModalImg.src = '';
				}
			}
		});

		// Logo preview handler
		const logoModal = document.getElementById('logoModal');
		const logoModalImg = document.getElementById('logoModalImg');

		if(logoImg && logoModal && logoModalImg){
			logoImg.style.cursor = 'pointer';
			logoImg.addEventListener('click', function(){
				logoModalImg.src = this.src || '';
				logoModal.classList.remove('hidden');
				logoModal.classList.add('flex');
				document.body.classList.add('overflow-hidden');
			});
			logoModal.addEventListener('click', function(e){
				if(e.target === logoModal){
					logoModal.classList.add('hidden');
					logoModal.classList.remove('flex');
					document.body.classList.remove('overflow-hidden');
					logoModalImg.src = '';
				}
			});
		}
	})();
</script>

@endsection
