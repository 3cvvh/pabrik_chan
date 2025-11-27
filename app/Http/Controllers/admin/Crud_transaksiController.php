<?php

namespace App\Http\Controllers\admin;

use DB;
use statustransaksi;
use App\Models\produk;
use App\Models\pembeli;
use App\Models\transaksi;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Models\Detail_transaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembeli as ModelsPembeli;
use App\Models\Transaksi as ModelsTransaksi;
use Illuminate\Support\Facades\DB as FacadesDB;

class Crud_transaksiController extends Controller
{
public function __construct()
{
    // terapkan middleware 'not_paid' hanya pada method-method yang butuh

    // atau: terapkan ke semua kecuali index & show
    $this->middleware('not_paid')->except(['index','show']);
}


    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $query = transaksi::with('pembeli')
        ->where('id', '!=', Auth::id())
        ->where('id_pabrik', Auth::user()->pabrik_id);

    // search di judul atau status
    $query->when($request->get('search'), function ($q, $search) {
        $q->where(function ($q2) use ($search) {
            $q2->where('judul', 'like', '%'.$search.'%')
               ->orWhere('status', 'like', '%'.$search.'%');
        });
    });

    // filter by pembeli menggunakan 'roles_key' dari view
    $query->when($request->get('roles_key'), function ($q, $pembeliId) {
        $q->where('id_pembeli', $pembeliId);
    });

    // filter by status menggunakan 'Status' (sesuai view parameter)
    $query->when($request->get('Status'), function($q, $stat){
        $q->where('status', $stat);
    });

    // filter by date range
    $query->when($request->get('date_from'), function ($q, $dateFrom) {
        $q->whereDate('tanggal_pengiriman', '>=', $dateFrom);
    });

    $query->when($request->get('date_to'), function ($q, $dateTo) {
        $q->whereDate('tanggal_pengiriman', '<=', $dateTo);
    });

    // paginate dan append semua query params yang benar
    $data = $query->latest()->paginate(3)->appends($request->only(['search', 'roles_key', 'Status', 'date_from', 'date_to']));

    return view('admin.crud_transaksi.index', [
        'judul' => 'transaksi|page',
        'data' => $data,
        'pembeli' => ModelsPembeli::where('id_pabrik', Auth::user()->pabrik_id)->get(),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_transaksi.create', [
            'judul' => 'transaksi|create',
            'pembeli' => pembeli::where('id_pabrik',Auth::user()->pabrik_id)->get(),
            'produk' => produk::where('id_pabrik', Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{

    // Validasi request
    $request->validate([
        'id_pembeli' => 'required',
        'keterangan' => 'nullable',
    ],[
        'id_pembeli.required' => 'Pembeli tidak dipilih',
        'judul.required' => 'Tolong nama transaksi diisi!',
    ]);

    // kumpulkan permintaan produk -> jumlah (pastikan key exists)

            // buat transaksi
            $transaksi = transaksi::create([
                'id_pembeli' => $request->id_pembeli,
                'id_pabrik' => Auth::user()->pabrik_id,
                'status_pengiriman' => 'belum_dikirim',
                'status_pembayaran' => 'belum_bayar',
                'keterangan' => $request->keterangan,
            ]);


    return redirect()->route('crud_transaksi.show', $transaksi->id)
        ->with('berhasil', 'Transaksi berhasil ditambahkan!');
}

    /**
     * Display the specified resource.
     */
public function show($id)
    {
   $data = transaksi::find($id);
    if(Auth::user()->pabrik_id !== $data->id_pabrik ){
        abort(404);
    }

    // ambil total stock per produk untuk pabrik saat ini (sum across semua gudang)
    $dataproduk = produk::withSum(['stock as total_stock' => function($q){
            $q->where('id_pabrik', Auth::user()->pabrik_id);
        }], 'jumlah')
        ->where('id_pabrik', Auth::user()->pabrik_id)
        ->get();

    return view('admin.crud_transaksi.show',[
        'judul' => $data->judul,
        // eager-load stock.gudang supaya dapat menampilkan nama gudang asal
        'data_detail' => Detail_transaksi::with(['transaksi','produk','stock.gudang'])
            ->where('id_transaksi', $id)
            ->get(),
        'data_transaksi' => $data,
        'dataproduk' => $dataproduk,
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $transaksi = transaksi::findOrFail($id);
        if(Auth::user()->pabrik_id !== $transaksi->id_pabrik ){
            abort(404);
        }
        return view('admin.crud_transaksi.create',[
            'judul' => 'edit transaksi',
            'transaksi' => $transaksi,
            'pembeli' => pembeli::where('id_pabrik',Auth::getUser()->pabrik_id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $transaksi = transaksi::find($id);
          $request->validate([
        'id_pembeli' => 'required',
        'keterangan' => 'nullable',
    ],[
        'id_produk.required' => 'produk tidak dipilih',
        'id_pembeli.required' => 'pembeli tidak dipilih',
        'jumlah.required' => 'jumlah produk harap di isi',
        'jumlah.*.required' => 'jumlah produk harap di isi',
        'jumlah.*.numeric' => 'jumlah produk harus berupa angka',
        'jumlah.*.min' => 'jumlah produk minimal 1'
    ]);
    $transaksi->id_pembeli = $request->id_pembeli;
    $transaksi->keterangan = $request->keterangan;
    $transaksi->save();
    return redirect()->route('crud_transaksi.index')->with('berhasil','berhasil mengedit transaksi');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        transaksi::destroy($id);
        return redirect(route('crud_transaksi.index'))->with('berhasil','berhasil menghapus data');
    }
}
