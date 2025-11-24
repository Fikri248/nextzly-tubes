<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel (Optional, kalau nama default 'products' sudah sesuai)
    protected $table = 'products';

    // Kolom yang boleh diisi
    protected $fillable = [
        'category_id',
        'nama_produk',
        'tipe_akun',
        'harga',
        'durasi',
        'stok',
        'deskripsi',
        'status',
        'platform',
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
