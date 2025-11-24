@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <h1 class="display-4">Jual Akun Digital Premium Tanpa Ribet</h1>
    <p class="lead">Akses resmi berbagai layanan digital favorit dengan harga hemat dan proses cepat</p>
    <a href="/apps" class="btn">Lihat Daftar Produk</a>
    <img src="/icon/hero.svg" class="hero-img" alt="Digital Premium">
</div>

<h2>Keunggulan Kami</h2>
<div class="features-row">
    <div class="feature-card">Tanpa Login</div>
    <div class="feature-card">Proses Cepat</div>
    <div class="feature-card">Banyak Pilihan Produk</div>
    <div class="feature-card">Pembayaran Aman</div>
</div>

<h2>Produk Unggulan</h2>
<div class="product-row">
    @forelse($products as $product)
        <div class="product-card">
            <img
                src="{{ $product->logo
                    ? asset('logo/' . $product->logo)
                    : asset('icon/' . ($product->platform ?? 'default.png')) }}"
                alt="{{ $product->nama_produk }}"
                class="prod-logo">
            <div class="prod-title">{{ $product->nama_produk }}</div>
            <span class="badge-cat">{{ $product->category->nama_kategori ?? 'Kategori' }}</span>
            <div class="prod-type">{{ ucfirst($product->tipe_akun) }}</div>
            <div class="prod-desc">{{ $product->deskripsi }}</div>
            <div class="prod-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
            <div class="prod-status {{ $product->status == 'tersedia' ? 'ready' : 'out' }}">
                {{ ucfirst($product->status) }}
            </div>
            <a href="/apps" class="prod-btn">Order</a>
        </div>
    @empty
        <p>Belum ada produk unggulan.</p>
    @endforelse
</div>
@endsection
