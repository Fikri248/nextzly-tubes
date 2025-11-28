@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HERO SECTION --}}
    <div class="jumbotron-modern">
        <div class="hero-decoration"></div>
        <div class="hero-content">
            <h1 class="hero-title">Nextzly</h1>
            <p class="hero-subtitle">Marketplace premium untuk aplikasi digital terbaik</p>

            {{-- SEARCH BAR --}}
            <div class="search-container">
                <form action="{{ route('home') }}" method="GET" class="search-form">
                    <div class="search-box">
                        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" class="search-input" placeholder="Cari produk..." value="{{ $search ?? '' }}">
                        @if($search)
                            <a href="{{ route('home') }}" class="search-clear">×</a>
                        @endif
                    </div>
                    <button type="submit" class="search-button">Cari</button>
                </form>
            </div>
        </div>
    </div>

    {{-- SEARCH RESULT INFO --}}
    @if($search)
        <div class="search-result-info">
            <p>Hasil pencarian untuk: <strong>"{{ $search }}"</strong></p>
            <span class="result-count">{{ $products->count() }} produk</span>
        </div>
    @endif

    {{-- FILTER KATEGORI --}}
    <div class="features-row">
        <a href="{{ route('home') }}" class="feature-card {{ !$kategori || $kategori == 'all' ? 'active' : '' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('home', ['kategori' => $cat->id]) }}"
               class="feature-card {{ $kategori == $cat->id ? 'active' : '' }}">
                {{ $cat->nama_kategori }}
            </a>
        @endforeach
    </div>

    {{-- GRID PRODUK --}}
    <div class="catalog-main">
        @forelse($products as $product)
            <a href="{{ route('product.show', $product->id) }}" class="product-card">
                <span class="badge-cat">{{ $product->category->nama_kategori }}</span>
                <div class="prod-logo-wrapper">
                    <img src="{{ asset('logo/' . $product->logo) }}" alt="{{ $product->nama_produk }}" class="prod-logo">
                </div>
                <div class="prod-overlay">
                    <h3 class="prod-title">{{ $product->nama_produk }}</h3>
                    <span class="prod-badge">Mulai Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                </div>
            </a>
        @empty
            <div class="no-results">
                <div class="no-results-icon">🔍</div>
                <h3>Produk tidak ditemukan</h3>
                <p>Coba kata kunci lain atau lihat semua produk</p>
                <a href="{{ route('home') }}" class="btn-back-home">Lihat Semua Produk</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
