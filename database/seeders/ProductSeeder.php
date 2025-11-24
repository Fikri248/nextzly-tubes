<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'nama_produk' => 'Netflix Premium 1 Bulan',
                'tipe_akun' => 'sharing_user',
                'harga' => 25000,
                'durasi' => 30,
                'stok' => 50,
                'deskripsi' => 'Akses Netflix Premium dengan kualitas 4K UHD',
                'status' => 'tersedia',
                'platform' => 'Netflix',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'nama_produk' => 'Spotify Premium 1 Bulan',
                'tipe_akun' => 'personal',
                'harga' => 15000,
                'durasi' => 30,
                'stok' => 100,
                'deskripsi' => 'Dengarkan musik tanpa iklan dengan kualitas tinggi',
                'status' => 'tersedia',
                'platform' => 'Spotify',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'nama_produk' => 'Disney+ Hotstar 3 Bulan',
                'tipe_akun' => 'family_plan',
                'harga' => 50000,
                'durasi' => 90,
                'stok' => 30,
                'deskripsi' => 'Tonton konten Disney, Marvel, dan Star Wars',
                'status' => 'tersedia',
                'platform' => 'Disney+ Hotstar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'nama_produk' => 'Google Drive 100GB 1 Tahun',
                'tipe_akun' => 'personal',
                'harga' => 120000,
                'durasi' => 365,
                'stok' => 20,
                'deskripsi' => 'Ruang penyimpanan cloud 100GB untuk file dan foto',
                'status' => 'tersedia',
                'platform' => 'Google Drive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'nama_produk' => 'Canva Pro 1 Bulan',
                'tipe_akun' => 'invite_email',
                'harga' => 30000,
                'durasi' => 30,
                'stok' => 0,
                'deskripsi' => 'Akses fitur premium Canva untuk desain profesional',
                'status' => 'habis',
                'platform' => 'Canva',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
