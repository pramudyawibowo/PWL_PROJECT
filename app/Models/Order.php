<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pesanan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'no_hp_pelanggan',
        'nama_barang',
        'id_kategori',
        'keluhan',
    ];

    public function kategori(){
        return $this->belongsTo(Category::class, 'id_kategori', 'id');
    }

    public function nota(){
        return $this->hasOne(Receipt::class);
    }
}
