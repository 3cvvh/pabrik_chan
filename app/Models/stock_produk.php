<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock_produk extends Model
{
    /** @use HasFactory<\Database\Factories\StockProdukFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function produk():BelongsTo
    {
        return $this->belongsTo(produk::class,'id_produk');
    }
    public function gudang():BelongsTo
    {
        return $this->belongsTo(gudang::class,'id_gudang');
    }
}
