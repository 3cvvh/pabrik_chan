<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pabrik extends Model
{
    /** @use HasFactory<\Database\Factories\PabrikFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    public function produk():HasMany
    {
        return $this->hasMany(produk::class,'id_pabrik');
    }
    public function transaksi():HasMany
    {
        return $this->hasMany(transaksi::class,'id_pabrik');
    }
    public function gudang():HasMany
    {
        return $this->hasMany(gudang::class,'id_pabrik');
    }
    public function user():HasMany
    {
        return $this->hasMany(User::class,'pabrik_id');
    }
}
