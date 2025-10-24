<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
	// Tampilkan daftar permintaan verifikasi (pending)
	public function index()
	{
		$requests = DB::table('requests')
			->leftJoin('users', 'requests.user_id', '=', 'users.id')
			->leftJoin('pabriks', 'requests.pabrik_id', '=', 'pabriks.id')
			->select('requests.*', 'users.name as user_name', 'users.email as user_email', 'pabriks.name as pabrik_name')
			->orderBy('requests.created_at', 'desc')
			->get();
        $role = DB::table('roles')
            ->select('id', 'name')
            ->where('id', '!=', '4')
            ->get();
        $gudangs = DB::table('gudangs')
            ->select('id', 'nama')
            ->where('id_pabrik', Auth::getUser()->pabrik_id)
            ->get();
            $judul = 'halaman|penerimaan';
		return view('admin.verifikasi.index', compact('judul','requests', 'role', 'gudangs'));
	}

	// Approve: tandai request dan set role user jadi admin
	public function approve($id)
	{
		$req = DB::table('requests')->where('id', $id)->first();
		if (!$req) {
			return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
		}

		DB::table('requests')->where('id', $id)->update([
			'status' => 'approved',
			'updated_at' => now()
		]);

		// update role user (sesuaikan kolom role di tabel users)
		DB::table('users')->where('id', $req->user_id)->update([
			'role' => 'admin',
			'updated_at' => now()
		]);

		return redirect()->route('admin.verifikasi.index')->with('success', 'User berhasil disetujui sebagai admin.');
	}

	// Reject: tandai request rejected
	public function reject($id)
	{
		$req = DB::table('requests')->where('id', $id)->first();
		if (!$req) {
			return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
		}

		DB::table('requests')->where('id', $id)->update([
			'status' => 'rejected',
			'updated_at' => now()
		]);

		return redirect()->route('admin.verifikasi.index')->with('success', 'Permintaan ditolak.');
	}
}
