<?php

namespace App\Http\Controllers\admin;

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

class CrudProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.crud_produk.index',[
            'judul' => 'crud|produk',
            'data' =>  produk::where('id_pabrik','=',Auth::getUser()->pabrik_id)->get(),
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
        $produk=produk::create($valid);

        $qrCode = QrCode::format('svg')->size(200)->generate($produk->id . '-' . $produk->nama);
        $fileName = 'qrcodes/' . $produk->id . '.svg';
        Storage::disk('public')->put($fileName, $qrCode);
        $produk->update(['qr_code' => $fileName]);

        return redirect()->route('produk.index')->with('berhasil','berhasil menambahkan produk');
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        if($produk->id_pabrik != Auth::user()->pabrik_id){
            abort(404);
        }
        return view('admin.crud_produk.show', [
            'judul' => $produk->judul,
            'produk' => $produk,
            'stock' => Stock_produk::where('id_produk', '=',$produk->id)->get()

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produk $produk)
    {
            return view('admin.crud_produk.edit', [
            'judul' => $produk->judul,
            'data' => $produk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produk $produk)
    {
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


        $qrCode = QrCode::format('svg')->size(200)->generate($produk->id . '-' . $produk->nama);
        $fileName = 'qrcodes/' . $produk->id . '.svg';
        Storage::disk('public')->put($fileName, $qrCode);
        $produk->update(['qr_code' => $fileName]);

        return redirect()->route('produk.index')->with('edit','berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk)
    {
        if($produk->gambar){
            Storage::delete($produk->gambar);
        }
        if($produk->qr_code){
            Storage::delete($produk->qr_code);
        }
        ModelsProduk::destroy($produk->id);
        return redirect()->route('produk.index')->with('hapus','berhasil menghapus data');
    }

    public function qrDownload(produk $produk)
    {
        $svg = QrCode::format('svg')->size(300)->generate($produk->id);
        return Response::make($svg, 200, [
            'Content-Type' => 'image/svg',
            'Content-Disposition' => 'attachment; filename="QR_'.$produk->id.'.svg"'
        ]);
    }
    
    public function qrView(produk $produk)
    {
         $produk = Produk::find($produk->id);
         if (!$produk) {
             return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan');
         }
     if($produk->id_pabrik != Auth::user()->pabrik_id){
            abort(404);

     }
         return view('admin.crud_produk.qrview', [
             'produk' => $produk,
             'judul' => 'QR Code Produk'
         ]);
         }
          
}
