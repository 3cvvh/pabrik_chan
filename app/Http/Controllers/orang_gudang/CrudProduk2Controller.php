<?php

namespace App\Http\Controllers\orang_gudang;

use App\Models\pabrik;
use App\Models\produk;
use App\Models\Stock_produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pabrik as ModelsPabrik;
use App\Models\Produk as ModelsProduk;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;


class CrudProduk2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function index(Request $request)
    {
        $query = produk::with('pabrik')->where('id_pabrik', '=', Auth::user()->pabrik_id)
        ->where('id_gudang','=',Auth::user()->gudang_id)
        ;
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('nama', 'like', '%' . $search . '%');
        }
        return view('admin.crud_produk.index',[
            'judul' => 'crud|produk',
            'data' =>  $query->latest()->paginate(3),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crud_produk.form_tambah_produk',[
            'judul' => 'formtambah|produk',
            'pabrik' => pabrik::where('id',Auth::user()->pabrik_id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required',
            'harga' => ['required'],
            'deskripsi' => 'nullable',
            'gambar' => ['image','nullable'],
            'id_pabrik' => 'integer'
        ]);
        if($request->file('gambar')){
            $valid['gambar'] = $request->file('gambar')->store('produk-img');
        }
        produk::create($valid);
        return redirect()->route('produk.index')->with('berhasil','berhasil menambahkan produk');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $produk = produk::find($id);

    if ($produk->id_pabrik != Auth::user()->pabrik_id || $produk->id == null) {
        abort(404);
    }
    if($produk->id == null){
        abort(404);
    }

    return view('admin.crud_produk.show', [
        'judul' => $produk->nama,
        'produk' => $produk,
        'stock' => Stock_produk::where('id_produk', '=', $produk->id)->where("id_gudang",Auth::user()->gudang_id)->get()
    ]);
}
    public function edit($id)
    {
        $produk = produk::find($id);
            return view('admin.crud_produk.edit', [
            'judul' => $produk->judul,
            'data' => $produk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = produk::find($id);
        $valid = $request->validate([
            'nama' => ['required'],
            'harga' => ['required'],
            'deskripsi' => 'nullable',
            'gambar' => ['nullable','image'],
        ]);
        if($request->file('gambar')){
            if($produk->gambar){
                Storage::delete($produk->gambar);
            }
            $valid['gambar'] = $request->file('gambar')->store('produk-img');
        }
        produk::where('id','=',$produk->id)->update($valid);
        return redirect()->route('produk.index')->with('berhasil','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = produk::find($id);
        if($produk->gambar){
            Storage::delete($produk->gambar);
        }
        ModelsProduk::destroy($produk->id);
        return redirect()->route('produk.index')->with('berhasil','berhasil menghapus data');
    }

        public function scanner()
    {
        return view('admin.crud_produk.scanner', [
            'judul' => 'scanner|produk'
        ]);
    }
    public function scannerProcess(Request $request)
    {
        $barcode = $request->barcode;

    // Misal barcode = ID produk
    $produk = \App\Models\Produk::where('id', $barcode)->first();

    if ($produk) {
        return response()->json([
            'status' => 'berhasil',
            'data' => [
                'id' => $produk->id,

            ]
        ]);
    } else {
        return response()->json([
            'status' => 'gagal',
            'message' => 'Produk tidak ditemukan'
        ]);
    }

        $kodeProduk = $request->input('kode'); // nilai dari QR code
        $produk = produk::where('id', $kodeProduk)->first();

        if (!$produk) {
            return redirect()->back()->with('gagal', 'Produk tidak ditemukan!');
        }

        // Redirect ke halaman detail produk
        return redirect()->route('crud_produk.show', $produk->id);
    }

    public function qrDownload(produk $produk)
    {
        $svg = QrCode::format('svg')->size(300)->generate($produk->id);
        return Response::make($svg, 200, [
            'Content-Type' => 'image/svg',
            'Content-Disposition' => 'attachment; filename="QR_'.$produk->id.'.svg"'
        ]);
    }
}

