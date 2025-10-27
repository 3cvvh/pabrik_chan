<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    protected $guarded = ['id'];
    use HasFactory;
    public function Pabrik():BelongsTo
    {
        return $this->belongsTo(Pabrik::class,'pabrik_id');
    }
}
