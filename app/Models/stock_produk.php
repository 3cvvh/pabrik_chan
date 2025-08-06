<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_produk extends Model
{
    /** @use HasFactory<\Database\Factories\StockProdukFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}
