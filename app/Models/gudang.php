<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class gudang extends Model
{
    /** @use HasFactory<\Database\Factories\GudangFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function stock():HasMany
    {
        return $this->hasMany(stock_produk::class,'id_gudang');
    }
}
