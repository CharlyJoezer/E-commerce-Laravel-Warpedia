<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $guarded = ['id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function toko(){
        return $this->belongsTo(Toko::class);
    }
}
