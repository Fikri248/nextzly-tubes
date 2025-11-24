<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 1,
                'product_id' => 1, // Netflix Premium
                'quantity' => 1,
                'total_harga' => 25000,
                'metode_pembayaran' => 'qris_whatsapp',
                'status' => 'success',
                'catatan' => 'Pembayaran via QRIS WhatsApp',
                'paid_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 2,
                'product_id' => 2, // Spotify Premium
                'quantity' => 1,
                'total_harga' => 15000,
                'metode_pembayaran' => 'shopee',
                'status' => 'success',
                'catatan' => 'Pembelian melalui Shopee',
                'paid_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 3,
                'product_id' => 3, // Disney+ Hotstar
                'quantity' => 1,
                'total_harga' => 50000,
                'metode_pembayaran' => 'qris_whatsapp',
                'status' => 'pending',
                'catatan' => 'Menunggu konfirmasi pembayaran',
                'paid_at' => null,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 4,
                'product_id' => 4, // Google Drive
                'quantity' => 1,
                'total_harga' => 120000,
                'metode_pembayaran' => 'shopee',
                'status' => 'success',
                'catatan' => 'Berhasil terbayar melalui Shopee',
                'paid_at' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 5,
                'product_id' => 1, // Netflix Premium
                'quantity' => 1,
                'total_harga' => 25000,
                'metode_pembayaran' => 'qris_whatsapp',
                'status' => 'failed',
                'catatan' => 'Pembayaran gagal, stok dikembalikan',
                'paid_at' => null,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'order_id' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => 1,
                'product_id' => 2, // Spotify Premium
                'quantity' => 2,
                'total_harga' => 30000,
                'metode_pembayaran' => 'shopee',
                'status' => 'success',
                'catatan' => 'Pembelian 2 akun Spotify',
                'paid_at' => now()->subDays(7),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
        ]);
    }
}
