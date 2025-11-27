<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenisproduk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function produk():HasMany
    {
        return $this->hasMany(produk::class,'id_jenis');
    }
}
