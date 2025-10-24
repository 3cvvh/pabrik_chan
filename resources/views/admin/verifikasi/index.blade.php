@extends('layout.main')

@section('content')
<x-navbar></x-navbar>

<div class="w-full px-4 py-8">

    <h2 class="text-3xl font-extrabold text-black mb-4">Verifikasi User - Permintaan Admin</h2>

    @if(isset($requests) && count($requests) > 0)
    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-6 mt-4">
         @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center space-x-2 text-sm text-red-600 mb-1">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
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
                                {{ $r->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($r->created_at)->format('Y-m-d H:i') }}</td>
                        <td class="py-3 px-4 text-center">
    						@if($r->status == 'pending')
    						<div class="flex gap-2 justify-center">
                            <button
                                onclick="showApproveDialog({{ $r->id }})"
                                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg shadow hover:bg-blue-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                Approve
                            </button>
                            <button
                                onclick="showRejectDialog({{ $r->id }})"
                                class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg shadow hover:bg-red-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-1 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v2H7V5a2 2 0 012-2zm0 0V3m0 0V3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6m4-6v6"/>
                                </svg>
                                Reject
                            </button>
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

{{-- Add Modal --}}
<div id="approveModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <h3 class="text-lg font-semibold mb-4">Pilih Role</h3>
        <form id="approveForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role:</label>
                <select name="role" id="roleSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="checkRole(this.value)">
                    <option value="">Pilih Role</option>
                    @foreach($role as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="gudangSelect" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700">Gudang:</label>
                <select name="gudang_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Gudang</option>
                    @foreach($gudangs as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Approve
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-xl">
        <h3 class="text-lg font-semibold mb-4">Alasan Penolakan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alasan:</label>
                <textarea name="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Masukkan alasan penolakan" required></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">
                    Reject
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function showApproveDialog(requestId) {
        document.getElementById('approveForm').action = `dashboard/admin/Request/${requestId}`;
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('approveModal').classList.remove('flex');
    }

    function checkRole(roleId) {
        const gudangSelect = document.getElementById('gudangSelect');
        gudangSelect.classList.toggle('hidden', roleId !== "2");
    }

    function showRejectDialog(requestId) {
        document.getElementById('rejectForm').action = `dashboard/admin/Request/${requestId}`;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
</script>
@endpush
