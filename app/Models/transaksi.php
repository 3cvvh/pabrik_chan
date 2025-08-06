<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function detail_tr():HasMany
    {
        return $this->hasMany(detail_transaksi::class,'id_transaksi');
    }
    public function pembeli():BelongsTo
    {
        return $this->belongsTo(pembeli::class,'id_pembeli');
    }
}
