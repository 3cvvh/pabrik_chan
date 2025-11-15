<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pabrik extends Model
{
    /** @use HasFactory<\Database\Factories\PabrikFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'expire' => 'datetime',
    ];

    public function stock():HasMany
    {
        return $this->hasMany(Pabrik::class,'id_pabrik');
    }
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
    public function pembeli():HasMany
    {
        return $this->hasMany(pembeli::class,'id_pabrik');
    }
    public function payment():HasMany
    {
        return $this->hasMany(Payment::class,'pabrik_id');
    }
    public function request():HasMany
    {
        return $this->hasMany(Request::class,'pabrik_id');
    }
    public function checkPrem(){
        if(!$this->Ispaid){
            return false;
        }
        if($this->expire && $this->sisa_waktu <= 0)
            {
                $this->Ispaid = false;
                $this->save();
                return false;
            }
        return true;
    }
    public function getremainDays(){
        if(!$this->expire){
            return 0;
        }
        $remain = $this->expire->diffInDays(now());
        return max(0,$remain);
    }
}
