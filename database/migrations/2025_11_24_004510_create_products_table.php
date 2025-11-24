<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('nama_produk');
            $table->enum('tipe_akun', ['invite_email', 'family_plan', 'sharing_user', 'personal']);
            $table->decimal('harga', 10, 2);
            $table->integer('durasi'); // dalam hari
            $table->integer('stok');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->string('platform')->nullable(); // Netflix, Spotify, dll
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
