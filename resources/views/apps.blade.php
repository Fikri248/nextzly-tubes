@extends('layouts.app')

@section('content')
<h2>Katalog Produk Akun Digital Premium</h2>
<div class="catalog-row">

    <div class="catalog-sidebar">
        <h4>Kategori</h4>
        <ul>
            @foreach($categories as $category)
            <li>
                <a href="{{ url('/apps?category='.$category->id) }}">{{ $category->nama_kategori }}</a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="catalog-main">
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
            <div class="prod-price">Rp {{ number_format($product->harga,0,',','.') }}</div>
            <div class="prod-status {{ $product->status == 'tersedia' ? 'ready' : 'out' }}">{{ ucfirst($product->status) }}</div>
            <span class="prod-stock">Stok: {{ $product->stok }}</span>
            <button class="prod-btn">Order</button>
            <button class="prod-btn-detail" onclick="showModal({{ $product->id }})">Detail</button>
        </div>
        @empty
        <p>Belum ada produk.</p>
        @endforelse
    </div>

</div>
@endsection
