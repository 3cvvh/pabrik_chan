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
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    // gunakan nama param yang sesuai dengan view/js: 'search' dan 'roles_key'
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

    // paginate dan append query params yang benar
    $data = $query->latest()->paginate(3)->appends($request->only(['search', 'roles_key']));

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
        'judul' => 'required',
        'id_pembeli' => 'required',
        'id_produk' => 'required|array',
        'jumlah' => 'required|array',
        'keterangan' => 'nullable',
    ],[
        'id_produk.required' => 'produk tidak dipilih',
        'id_pembeli.required' => 'pembeli tidak dipilih',
        'judul.required' => 'tolong nama transaksi diisi',
        'jumlah.required' => 'jumlah produk harap di isi',
        'jumlah.*.required' => 'jumlah produk harap di isi',
        'jumlah.*.numeric' => 'jumlah produk harus berupa angka',
        'jumlah.*.min' => 'jumlah produk minimal 1'
    ]);

    // kumpulkan permintaan produk -> jumlah (pastikan key exists)
    $requested = [];
    foreach ($request->id_produk as $pid) {
        $qty = isset($request->jumlah[$pid]) ? (int) $request->jumlah[$pid] : 0;
        if ($qty <= 0) {
            return redirect(route('crud_transaksi.create'))->with('warning','harap jumlah diisi');
        }
        $requested[$pid] = $qty;
    }

    // cek stok keseluruhan untuk setiap produk sebelum memulai transaksi DB
    foreach ($requested as $produk_id => $qty) {
        $available = Stock_produk::where('id_produk', $produk_id)
            ->where('id_pabrik', Auth::user()->pabrik_id)
            ->sum('jumlah');

        if ($available < $qty) {
            return redirect()->route('crud_transaksi.create')->with('gagal','stok tidak mencukupi untuk produk id: '.$produk_id);
        }
    }


    try {
        FacadesDB::transaction(function () use ($request, $requested, &$transaksi) {
            // buat transaksi
            $transaksi = transaksi::create([
                'judul' => $request->judul,
                'id_pembeli' => $request->id_pembeli,
                'id_pabrik' => Auth::user()->pabrik_id,
                'status_pengiriman' => 'belum_dikirim',
                'status_pembayaran' => 'belum_bayar',
                'keterangan' => $request->keterangan,
            ]);

            $total_harga = 0;

            foreach ($requested as $produk_id => $jumlah) {
                $produk = produk::findOrfail($produk_id);
                if (! $produk) {
                    throw new \Exception('Produk tidak ditemukan: '.$produk_id);
                }

                $harga_total_produk = $produk->harga_jual * $jumlah;
                $total_harga += $harga_total_produk;

                // sisipkan detail transaksi
                FacadesDB::table('detail_transaksis')->insert([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $produk_id,
                    'jumlah' => $jumlah,
                    'total_harga' => $harga_total_produk,
                    'harga_satuan' => $produk->harga_jual,
                ]);

                // kurangi stok dari baris-stock (FIFO) dengan lockForUpdate untuk menghindari race condition
                $remaining = $jumlah;
                $stocks = Stock_produk::where('id_produk', $produk_id)
                    ->where('id_pabrik', Auth::user()->pabrik_id)
                    ->where('jumlah', '>', 0)
                    ->orderBy('created_at')
                    ->lockForUpdate()
                    ->get();

                foreach ($stocks as $stock) {
                    if ($remaining <= 0) break;
                    $take = min($stock->jumlah, $remaining);
                    $stock->jumlah -= $take;
                    $stock->save();
                    $remaining -= $take;
                }

                if ($remaining > 0) {
                    // seharusnya tidak terjadi karena cek sebelumnya, tapi aman untuk rollback
                    throw new \Exception('Stok tidak mencukupi saat pengurangan untuk produk id: '.$produk_id);
                    session()->flash('warning', 'Stok tidak mencukupi saat pengurangan untuk produk id: '.$produk_id);
                }
            }

            // update total transaksi
            $transaksi->update(['total_harga' => $total_harga]);
        });
    } catch (\Exception $e) {
        // jika gagal, kembalikan pesan ke user
        return redirect()->route('crud_transaksi.create')->with('warning','Gagal membuat transaksi: '.$e->getMessage());
    }

    return redirect()->route('crud_transaksi.index')->with('berhasil','berhasil menambahkan transaksi');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data =  transaksi::find($id);
        if(Auth::user()->pabrik_id !== $data->id_pabrik ){
            abort(404);
        }
        return view('admin.crud_transaksi.show',[
            'judul' => transaksi::find($id)->judul,
            'data_detail' => Detail_transaksi::with(['transaksi','produk'])
            ->where('id_transaksi', $id)
            ->whereHas('produk.stock', function ($q) {
                $q->where('jumlah', '>', 0);
            })
            ->get(),
            'data_transaksi' => $data,
            'dataproduk' => produk::where('id_pabrik',Auth::getUser()->pabrik_id)->get(),
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
        'judul' => 'required',
        'id_pembeli' => 'required',
        'keterangan' => 'nullable',
    ],[
        'id_produk.required' => 'produk tidak dipilih',
        'id_pembeli.required' => 'pembeli tidak dipilih',
        'judul.required' => 'tolong nama transaksi diisi',
        'jumlah.required' => 'jumlah produk harap di isi',
        'jumlah.*.required' => 'jumlah produk harap di isi',
        'jumlah.*.numeric' => 'jumlah produk harus berupa angka',
        'jumlah.*.min' => 'jumlah produk minimal 1'
    ]);
    $transaksi->judul = $request->judul;
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
