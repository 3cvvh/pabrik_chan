<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pabrik extends Model
{
    /** @use HasFactory<\Database\Factories\PabrikFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}
