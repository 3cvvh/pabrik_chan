<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pabrik extends Model
{
    /** @use HasFactory<\Database\Factories\PabrikFactory> */
    use HasFactory;
    protected $guarded = ['id'];
<<<<<<< HEAD
    public function users()
    {
        return $this->hasMany(User::class, 'pabrik_id');
=======

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
>>>>>>> 7796c11bdc1a6b76fd4b1075e2231cfe440b90ee
    }
}
