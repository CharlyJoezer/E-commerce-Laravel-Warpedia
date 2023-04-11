<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $guarded = ['id'];
    protected $with = ['product', 'alamat', 'payment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_transaction_id', 'transaction_id');
    }
}
