<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pembeli extends Model
{
    /** @use HasFactory<\Database\Factories\PembeliFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function transaksi():HasMany
    {
        return $this->hasMany(transaksi::class,'id_pembeli');
    }
}
