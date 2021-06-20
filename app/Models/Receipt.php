<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pesanan',
        'diagnosa',
        'harga'
    ];

    public function pesanan(){
        return $this->belongsTo(Order::class, 'id_pesanan', 'id');
    }
}
