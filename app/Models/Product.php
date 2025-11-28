<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'logo',
        'category_id',
        'tipe_akun',
        'deskripsi',
        'harga',
        'durasi',
        'stok',
        'status',
        'platform',
        'paket_harga',
    ];

    protected $casts = [
        'paket_harga' => 'array',
        'harga' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
