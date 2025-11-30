<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel categories
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->string('nama_produk');
            $table->string('logo');
            $table->string('tipe_akun')->default('premium');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('durasi')->default(30);
            $table->integer('stok')->default(100);
            $table->enum('status', ['tersedia', 'habis', 'nonaktif'])->default('tersedia');
            $table->json('paket_harga')->nullable();
            $table->string('platform')->nullable(); // kalau dipakai di seeder
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
