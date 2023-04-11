<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldotoko extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['toko'];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
