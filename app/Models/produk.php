<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function stock():HasMany
    {
        return $this->hasMany(stock_produk::class,'id_produk');
    }
    public function detail_tr():HasMany
    {
        return $this->hasMany(detail_transaksi::class,'id_produk');
    }

}
