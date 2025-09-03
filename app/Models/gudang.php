<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gudang extends Model
{
    /** @use HasFactory<\Database\Factories\GudangFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function stock():HasMany
    {
        return $this->hasMany(stock_produk::class,'id_gudang');
    }
    public function pabrik():BelongsTo
    {
        return $this->belongsTo(pabrik::class,'id_pabrik');
    }
    public function user():HasMany
    {
        return $this->hasMany(User::class,'gudang_id');
    }
}
