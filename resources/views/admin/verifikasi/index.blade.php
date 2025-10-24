@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="w-full px-4 py-8">
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-2 rounded-lg bg-green-100 text-green-800 font-semibold shadow">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-2 rounded-lg bg-red-100 text-red-800 font-semibold shadow">{{ session('error') }}</div>
    @endif

    <h2 class="text-3xl font-extrabold text-black mb-4">Verifikasi User - Permintaan Admin</h2>

    @if(isset($requests) && count($requests) > 0)
    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 mt-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-blue-700 bg-blue-50">
                        <th class="py-3 px-4 rounded-tl-xl">#</th>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Pabrik</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Requested At</th>
                        <th class="py-3 px-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @foreach($requests as $r)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="py-3 px-4">{{ $r->id }}</td>
                        <td class="py-3 px-4 font-semibold text-blue-900">{{ $r->user_name ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $r->user_email ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $r->pabrik_name ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="
                                px-3 py-1 rounded-full text-xs font-semibold
                                {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($r->created_at)->format('Y-m-d H:i') }}</td>
                        <td class="py-3 px-4 text-center">
    						@if($r->status == 'pending')
    						<div class="flex gap-2 justify-center">
        						<form method="POST" action="{{ route('admin.verifikasi.approve', $r->id) }}">
            						@csrf
            						<button type="submit"
                						class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg shadow hover:bg-blue-200 transition-all duration-200"
                						onclick="return confirm('Setujui user ini sebagai admin?')">
                						<svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    						<path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m0 0l3-3m-3 3l3 3"/>
                						</svg>
                						Approve
            						</button>
        						</form>
        						<form method="POST" action="{{ route('admin.verifikasi.reject', $r->id) }}">
            						@csrf
            						<button type="submit"
                						class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg shadow hover:bg-red-200 transition-all duration-200"
                						onclick="return confirm('Tolak permintaan ini?')">
                						<svg class="w-5 h-5 mr-1 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    						<path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v2H7V5a2 2 0 012-2zm0 0V3m0 0V3"/>
                    						<path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6"/>
                						</svg>
                						Reject
            						</button>
        						</form>
    						</div>
    						@else
        						<span class="text-gray-400">No actions</span>
    						@endif
						</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="mt-6 px-4 py-3 rounded-lg bg-blue-50 text-blue-700 font-semibold shadow">Tidak ada permintaan verifikasi saat ini.</div>
    @endif
</div>
@endsection