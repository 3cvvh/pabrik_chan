<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detail_transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\DetailTransaksiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function produk():BelongsTo
    {
        return $this->belongsTo(produk::class,'id_produk');
    }
    public function transaksi():BelongsTo
    {
        return $this->belongsTo(transaksi::class,'id_transaksi');
    }
}
