<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'nama_kategori' => 'Streaming Video',
                'deskripsi' => 'Platform streaming film dan series',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Streaming Music',
                'deskripsi' => 'Platform streaming musik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Cloud Storage',
                'deskripsi' => 'Layanan penyimpanan cloud',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Productivity',
                'deskripsi' => 'Tools produktivitas dan kolaborasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
