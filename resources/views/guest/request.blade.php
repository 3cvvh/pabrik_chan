@extends('layout.main')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-blue-700">Daftar Pabrik</h1>
        <a href="{{ route('guest.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg shadow hover:bg-blue-200 transition-all duration-200">
            ← Kembali
        </a>
    </div>

    <div class="flex-shrink-0">
        @foreach ($allpabrik as $index => $pabrik )
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 group">
            <div class="flex items-start gap-5">
    			<div class="flex-shrink-0">
       				<div class="h-12 w-12 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 text-2xl font-bold shadow group-hover:scale-110 transition-transform duration-300 leading-none" style="aspect-ratio: 1 / 1;">
    					{{ strtoupper(substr($pabrik->name ?? '', 0, 1)) }}
					</div>
    			</div>
    			<div class="flex-1 min-w-0 ml-3"> {{-- Tambahkan ml-3 untuk jarak --}}
        			<h2 class="text-xl font-bold text-blue-800 truncate">{{ $pabrik->name }}</h2>
        			<p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $pabrik->alamat }}</p>
        			<div class="mt-5">
            			<form class="requestForm"  action="{{ route('guest.store_req') }}" method="POST">
                			@csrf
                			<input type="hidden" name="pabrik_id" value="{{ $pabrik->id }}">
                			<button type="submit"
                    			class="requestBtn inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 hover:scale-105 transition-all duration-200">
                    			<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        			<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    			</svg>
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