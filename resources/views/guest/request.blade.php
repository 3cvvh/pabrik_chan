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
						<form class="requestForm"  action="{{ route('guest.store_req') }}" method="POST">
							@csrf
							<input type="hidden" name="pabrik_id" value="{{ $pabrik->id }}">
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


@endsection
