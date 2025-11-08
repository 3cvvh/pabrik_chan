<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    /** @use HasFactory<\Database\Factories\RequestFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function pabrik():BelongsTo
    {
        return $this->belongsTo(pabrik::class, 'pabrik_id', 'id');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
