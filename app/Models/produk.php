<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    
    public function stock() {
    return $this->hasOne(Stock_produk::class, 'id_produk', 'id');
    }
    public function detail_tr():HasMany
    {
        return $this->hasMany(detail_transaksi::class,'id_produk');
    }
    public function pabrik():BelongsTo
    {
       return $this->belongsTo(pabrik::class,'id_pabrik');
    }
    protected $casts = [
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
    ];

    public function getLabaPerUnitAttribute()
    {
        if (! isset($this->harga_modal) || ! isset($this->harga_jual)) {
            return null;
        }
        return round($this->harga_jual - $this->harga_modal, 2);
    }

    // relasi (jika belum ada)
    public function detailTransaksis()
    {
        return $this->hasMany(Detail_transaksi::class, 'id_produk');
    }

}
