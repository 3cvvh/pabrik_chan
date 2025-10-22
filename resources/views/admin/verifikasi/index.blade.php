@extends('layout.main')
@section('content')
<x-navbar></x-navbar>

<div class="container py-4">
	<!-- notifikasi singkat -->
	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif
	@if(session('error'))
		<div class="alert alert-danger">{{ session('error') }}</div>
	@endif

	<h2 class="mb-3">Verifikasi User - Permintaan Admin</h2>

	<!-- Jika tidak ada data -->
	@if(isset($requests) && count($requests) > 0)
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead class="thead-light">
					<tr>
						<th>#</th>
						<th>User</th>
						<th>Email</th>
						<th>Pabrik</th>
						<th>Status</th>
						<th>Requested At</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($requests as $r)
					<tr>
						<td>{{ $r->id }}</td>
						<td>{{ $r->user_name ?? '-' }}</td>
						<td>{{ $r->user_email ?? '-' }}</td>
						<td>{{ $r->pabrik_name ?? '-' }}</td>
						<td>
							<span class="badge badge-{{ $r->status == 'pending' ? 'warning' : ($r->status == 'approved' ? 'success' : 'danger') }}">
								{{ ucfirst($r->status) }}
							</span>
						</td>
						<td>{{ \Carbon\Carbon::parse($r->created_at)->format('Y-m-d H:i') }}</td>
						<td class="text-center">
							@if($r->status == 'pending')
							<form method="POST" action="{{ route('admin.verifikasi.approve', $r->id) }}" style="display:inline">
								@csrf
								<button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui user ini sebagai admin?')">Approve</button>
							</form>
							<form method="POST" action="{{ route('admin.verifikasi.reject', $r->id) }}" style="display:inline">
								@csrf
								<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak permintaan ini?')">Reject</button>
							</form>
							@else
								<span class="text-muted">No actions</span>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@else
		<div class="alert alert-info">Tidak ada permintaan verifikasi saat ini.</div>
	@endif
</div>

@endsection