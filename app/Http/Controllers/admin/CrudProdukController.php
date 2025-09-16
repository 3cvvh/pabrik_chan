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
    public function index(Request $request)
    {
        $query = produk::with('pabrik')->where('id_pabrik', '=', Auth::user()->pabrik_id);
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('nama', 'like', '%' . $search . '%');
        }
        
    

    // if AJAX or JSON requested, return JSON array for frontend
        if ($request->wantsJson() || $request->ajax()) {
            $user = Auth::user();
            $items = $query->get()->map(function($p) use ($user) {
                return [
                    'id' => $p->id,
                    'nama' => $p->nama,
                    'pabrik' => [
                        'name' => $p->pabrik ? $p->pabrik->name : '',
                    ],
                    'gambar' => $p->gambar,
                    'harga_jual' => $p->harga_jual,
                    'harga' => $p->harga,
                    'harga_modal' => $p->harga_modal,
                    'qr_view_url' => $user->role_id == 1 ? route('produk.qrView', $p) : route('produk.qrViews', $p),
                    'detail_url' => $user->role_id == 1 ? route('produk.show', $p->id) : route('crud_produk.show', $p->id),
                    'edit_url' => $user->role_id == 1 ? route('produk.edit', $p->id) : route('crud_produk.edit', $p->id),
                    'delete_url' => route('produk.destroy', $p->id),
                    'can_edit' => $user->role_id == 1,
                    'can_delete' => $user->role_id == 1,
                    'csrf_token' => csrf_token(),
                ];
            });

            return response()->json($items);
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
            'judul' => 'form tambah|produk',
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
            'deskripsi' => 'nullable',
            'gambar' => ['image','nullable'],
            'id_pabrik' => 'integer',
            'harga_jual' => ['required'],
            'harga_modal' => ['required']
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
            'harga_jual' => ['required'],
            'harga_modal' => ['required']
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

        return redirect()->route('produk.index')->with('berhasil','berhasil mengedit data');
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
        return redirect()->route('produk.index')->with('berhasil','berhasil menghapus data');
    }

    /**
     * Halaman scanner produk
     */
    public function scanner()
    {
        return view('admin.crud_produk.scanner', [
            'judul' => 'scanner|produk'
        ]);
    }

     /**
     * Proses hasil scan QR produk
     */
    public function scannerProcess(Request $request)
    {
        $barcode = $request->barcode;

    // Misal barcode = ID produk
    $produk = \App\Models\Produk::where('id', $barcode)->first();

    if ($produk) {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $produk->id,

            ]
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan'
        ]);
    }

        $kodeProduk = $request->input('kode'); // nilai dari QR code
        $produk = produk::where('id', $kodeProduk)->first();

        if (!$produk) {
            return redirect()->back()->with('gagal', 'Produk tidak ditemukan!');
        }

        // Redirect ke halaman detail produk
        return redirect()->route('produk.show', $produk->id);
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
             return redirect()->route('produk.index')->with('gagal', 'Produk tidak ditemukan');
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
