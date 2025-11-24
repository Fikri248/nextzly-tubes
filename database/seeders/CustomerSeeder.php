<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@yahoo.com',
                'phone' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@outlook.com',
                'phone' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rina Kusuma',
                'email' => null,
                'phone' => '084567890123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dimas Pratama',
                'email' => 'dimas.pratama@gmail.com',
                'phone' => '085678901234',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
