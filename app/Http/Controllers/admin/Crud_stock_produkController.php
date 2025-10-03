<?php

namespace App\Http\Controllers\admin;

use App\Models\Gudang;
use App\Models\Pabrik;
use App\Models\Produk;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Crud_stock_produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stock = Stock_produk::with(['produk','gudang'])
            ->where('id_pabrik', Auth::user()->pabrik_id);

        // Filter teks pencarian: cari di nama produk, nama gudang, jumlah atau status
        if ($request->filled('search')) {
            $q = trim($request->search);
            $stock->where(function($query) use ($q) {
                $query->whereHas('produk', function($q2) use ($q) {
                    $q2->where('nama', 'like', '%' . $q . '%');
                })->orWhereHas('gudang', function($q3) use ($q) {
                    $q3->where('nama', 'like', '%' . $q . '%');
                })->orWhere('jumlah', 'like', '%' . $q . '%')
                  ->orWhere('status', 'like', '%' . $q . '%');
            });
        }

        // Filter by produk
        if ($request->filled('produk')) {
            $stock->where('id_produk', $request->produk);
        }

        // Filter by gudang
        if ($request->filled('gudang')) {
            $stock->where('id_gudang', $request->gudang);
        }

        // Data untuk select filter di view
        $produks = Produk::where('id_pabrik', Auth::user()->pabrik_id)->get();
        $gudangs = Gudang::where('id_pabrik', Auth::user()->pabrik_id)->get();

        return view('admin.crud_stock_produk.index', [
            'judul' => 'crud|stock_produk',
            'data' => $stock->latest()->paginate(3),
            'produks' => $produks,
            'gudangs' => $gudangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_stock_produk.create', [
            'judul' => 'formtambah|stok',
            'produk' => Produk::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
            'gudang' => Gudang::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Block adding stock if the selected gudang is closed/inactive.
     */
    public function store(Request $request)
    {
        $stock_ada = Stock_produk::where('id_produk', $request->id_produk)->get();

        $valid = $request->validate([
            'jumlah' => ['required','integer','min:0'],
            'keterangan' => ['nullable','string'],
            'id_produk' => ['required','integer'],
            'id_gudang' => ['required','integer'],
            'tanggal_masuk' => 'required|date'
        ],[
            'jumlah.required' => 'Jumlah belum diisi!',
            'id_produk.required' => 'Produk belum dipilih!',
            'id_gudang.required' => 'Gudang belum dipilih!'
        ]);

        // pastikan gudang ada dan milik pabrik user
        $gudang = Gudang::where('id', $valid['id_gudang'])
            ->where('id_pabrik', Auth::user()->pabrik_id)
            ->first();

        if (!$gudang) {
            return redirect()->route('Stock_produk.index')->with('gagal','Gudang tidak ditemukan untuk pabrik ini!');
        }

        // tentukan apakah gudang aktif (tangani beberapa kemungkinan kolom)
        $isActive = $this->isGudangActive($gudang);
        if (!$isActive) {
            return redirect()->route('Stock_produk.index')->with('gagal','Gudang terpilih sedang tutup. Tidak dapat menambah stok pada gudang ini.');
        }

        // cek duplikasi produk+gudang
        foreach($stock_ada as $item){
            if($item->id_gudang == $valid['id_gudang']){
                return redirect()->route('Stock_produk.index')->with('warning','Stok dengan produk dan gudang yang sama sudah ada!');
            }
        }

        $valid['id_pabrik'] = Auth::user()->pabrik_id;
        $valid['status'] = ($valid['jumlah'] > 0) ? 'tersedia' : 'habis';

        Stock_produk::create($valid);
        return redirect()->route('Stock_produk.index')->with('berhasil','berhasil menambahkan stok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock_produk $stock_produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stock = Stock_produk::findOrFail($id);
        return view('admin.crud_stock_produk.edit',[
            'judul' => 'edit|stok',
            'data' => Stock_produk::all(),
            'gudang' => Gudang::where('id_pabrik', Auth::getUser()->pabrik_id)->get(),
            'stock' => $stock
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * Block moving/assigning stock to a closed gudang.
     */
    public function update(Request $request, $id)
    {
        $stock_produk = Stock_produk::findOrFail($id);

        $request->validate([
            'jumlah' => ['required','integer','min:0'],
            'tanggal_masuk' => ['required','date'],
            'keterangan' => 'nullable|string',
            'id_gudang' => 'required|integer',
        ]);

        // pastikan gudang tujuan ada dan milik pabrik user
        $gudang = Gudang::where('id', $request->id_gudang)
            ->where('id_pabrik', Auth::user()->pabrik_id)
            ->first();

        if (!$gudang) {
            return redirect()->route('Stock_produk.index')->with('gagal','Gudang tidak ditemukan untuk pabrik ini!');
        }

        // jika gudang tujuan tutup, jangan izinkan update id_gudang
        if (!$this->isGudangActive($gudang)) {
            return redirect()->route('Stock_produk.index')->with('gagal','Gudang tujuan tutup. Tidak dapat memindahkan/menetapkan stok ke gudang ini.');
        }

        $stock_produk->status = ($request->jumlah <= 0) ? 'habis' : 'tersedia';
        $stock_produk->jumlah = $request->jumlah;
        $stock_produk->id_gudang = $request->id_gudang;
        $stock_produk->tanggal_masuk = $request->tanggal_masuk;
        $stock_produk->keterangan = $request->keterangan;
        $stock_produk->save();

        return redirect()->route('Stock_produk.index')->with('berhasil','berhasil mengedit stok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Stock_produk::findOrFail($id);
        $data->delete();
        return redirect()->route('Stock_produk.index')->with('berhasil','berhasil menghapus data');
    }

    /**
     * Helper: tentukan apakah sebuah gudang dianggap aktif.
     */
    protected function isGudangActive(Gudang $gudang): bool
    {
        // cek boolean is_active jika tersedia
        if (isset($gudang->is_active)) {
            return (bool) $gudang->is_active;
        }

        // cek field status jika tersedia (toleransi nilai)
        if (isset($gudang->status)) {
            $status = strtolower((string) $gudang->status);
            return in_array($status, ['aktif','active','1','true','on']);
        }

        // default dianggap aktif jika tidak ada field status/is_active
        return true;
    }
}
