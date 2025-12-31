@extends('layouts.app')

@section('content')
<div class="home-page">

    {{-- HERO SECTION --}}
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="brand-logo-wrapper">
                <img src="{{ asset('brand.png') }}" alt="Nextzly" class="brand-logo">
            </div>
            <h1 class="hero-title">Nextzly</h1>
            <p class="hero-subtitle">Premium Digital Marketplace</p>
            <p class="hero-desc">Solusi terpercaya untuk kebutuhan akun premium & layanan digital Anda</p>

            {{-- SEARCH BAR --}}
            <form action="{{ route('homepage') }}" method="GET" class="search-form">
                <div class="search-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari produk digital..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('homepage') }}" class="search-clear">&times;</a>
                    @endif
                </div>
                <button type="submit" class="search-btn">Cari</button>
            </form>
        </div>

        {{-- Floating Elements --}}
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <div class="main-content">

        {{-- SEARCH RESULT INFO --}}
        @if($search)
        <div class="search-result-banner">
            <div class="result-left">
                <div class="result-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </div>
                <div class="result-text">
                    <span class="result-label">Hasil pencarian untuk</span>
                    <span class="result-keyword">"{{ $search }}"</span>
                </div>
            </div>
            <div class="result-right">
                <div class="result-count-box">
                    <span class="count-number">{{ $products->count() }}</span>
                    <span class="count-text">produk ditemukan</span>
                </div>
                <a href="{{ route('homepage') }}" class="clear-search-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                    Hapus
                </a>
            </div>
        </div>
        @endif

        {{-- CATEGORY FILTER --}}
        <div class="category-section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 1H1v14h5V1zm9 0h-5v5h5V1zm0 9v5h-5v-5h5zM0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm1 9a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1h-5z"/>
                </svg>
                Kategori
            </h2>
            <div class="category-pills">
                <a href="{{ route('homepage') }}" class="pill {{ !$kategori || $kategori == 'all' ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
                    </svg>
                    Semua
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('homepage', ['kategori' => $cat->id]) }}"
                   class="pill {{ $kategori == $cat->id ? 'active' : '' }}">
                    {{ $cat->nama_kategori }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- PRODUCTS GRID --}}
        <div class="products-section">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg>
                Produk Tersedia
            </h2>

            @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card">
                    <div class="card-glow"></div>

                    <div class="product-image">
                        @if($product->logo)
                            <img src="{{ asset('logo/' . $product->logo) }}" alt="{{ $product->nama_produk }}">
                        @else
                            <div class="placeholder-image">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="category-badge">{{ $product->category->nama_kategori ?? 'Digital' }}</span>
                    </div>

                    <div class="product-info">
                        <h3 class="product-name">{{ $product->nama_produk }}</h3>
                        <p class="product-desc">{{ Str::limit($product->deskripsi ?? 'Produk digital premium', 50) }}</p>

                        <div class="product-meta">
                            @if($product->tipe_akun)
                            <span class="meta-tag">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                                {{ ucfirst($product->tipe_akun) }}
                            </span>
                            @endif
                            <span class="meta-tag">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                {{ $product->durasi }} Hari
                            </span>
                        </div>

                        @if($product->platform)
                        <div class="platform-info">
                            @php $platforms = explode(',', $product->platform); @endphp
                            @foreach(array_slice($platforms, 0, 3) as $p)
                            <span class="platform-chip">{{ trim($p) }}</span>
                            @endforeach
                            @if(count($platforms) > 3)
                            <span class="platform-chip more">+{{ count($platforms) - 3 }}</span>
                            @endif
                        </div>
                        @endif

                        <div class="product-footer">
                            <span class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <span class="buy-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 1A1.5 1.5 0 0 0 1 2.5V3h14v-.5A1.5 1.5 0 0 0 13.5 1h-11zM1 4v9.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5V4H1zm4 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 5 7z"/>
                    </svg>
                </div>
                <h3>Produk Tidak Ditemukan</h3>
                <p>Coba kata kunci lain atau lihat semua produk</p>
                <a href="{{ route('homepage') }}" class="btn-reset">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                    </svg>
                    Lihat Semua Produk
                </a>
            </div>
            @endif
        </div>

        {{-- ABOUT US SECTION --}}
        <section id="about" class="about-section">
            <div class="about-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                    </svg>
                    Tentang Kami
                </h2>
            </div>
            <div class="about-content">
                <div class="about-logo">
                    <img src="{{ asset('brand.png') }}" alt="Nextzly">
                </div>
                <div class="about-text">
                    <p class="about-desc">
                        <strong>Nextzly</strong> adalah marketplace digital terpercaya yang menyediakan berbagai layanan akun premium dengan harga terjangkau. Kami berkomitmen memberikan pengalaman terbaik bagi pelanggan dengan produk berkualitas dan layanan pelanggan yang responsif.
                    </p>
                    <div class="visi-misi">
                        <div class="visi">
                            <h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                                Visi
                            </h4>
                            <p>Menjadi platform digital marketplace terdepan di Indonesia yang memberikan akses mudah dan terjangkau ke layanan premium digital.</p>
                        </div>
                        <div class="misi">
                            <h4>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
                                </svg>
                                Misi
                            </h4>
                            <ul>
                                <li>Menyediakan produk digital berkualitas dengan harga kompetitif</li>
                                <li>Memberikan layanan pelanggan yang cepat dan responsif</li>
                                <li>Menjamin keamanan dan kenyamanan transaksi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- KEUNGGULAN SECTION --}}
        <section id="keunggulan" class="keunggulan-section">
            <div class="keunggulan-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
                    </svg>
                    Kenapa Pilih Kami?
                </h2>
                <p>6 alasan mengapa ribuan pelanggan mempercayai Nextzly</p>
            </div>
            <div class="keunggulan-grid">
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                            <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                        </svg>
                    </div>
                    <h4>Produk Legal & Resmi</h4>
                    <p>Semua akun premium yang kami jual adalah produk resmi dengan lisensi yang sah</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                    </div>
                    <h4>Proses Cepat</h4>
                    <p>Pengiriman akun instan setelah pembayaran dikonfirmasi, maksimal 5 menit</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <h4>Garansi Resmi</h4>
                    <p>Garansi penuh selama masa aktif akun, penggantian atau refund jika ada masalah</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                        </svg>
                    </div>
                    <h4>Harga Terjangkau</h4>
                    <p>Harga kompetitif dan bersaing, dapatkan akun premium dengan budget hemat</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6-.097 1.016-.417 2.13-.771 2.966-.079.186.074.394.273.362 2.256-.37 3.597-.938 4.18-1.234A9.06 9.06 0 0 0 8 15z"/>
                        </svg>
                    </div>
                    <h4>Support 24/7</h4>
                    <p>Tim customer service siap membantu kapanpun Anda butuhkan via WhatsApp</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722z"/>
                        </svg>
                    </div>
                    <h4>Transaksi Aman</h4>
                    <p>Pembayaran melalui transfer bank, QRIS, dan marketplace resmi Shopee</p>
                </div>
            </div>
        </section>

        {{-- SYARAT & KETENTUAN SECTION --}}
        <section id="terms" class="terms-section">
            <div class="terms-header">
                <h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                        <path d="M4.5 12.5A.5.5 0 0 1 5 12h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 10h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm1.639-3.708 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V8.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V8s1.54-1.274 1.639-1.208zM6.25 6a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5z"/>
                    </svg>
                    Syarat & Ketentuan
                </h2>
                <p>Ketentuan klaim garansi dan refund yang berlaku</p>
            </div>
            <div class="terms-content">
                <div class="terms-card">
                    <div class="terms-number">1</div>
                    <div class="terms-info">
                        <h4>Wajib Kirim Screenshot</h4>
                        <p>Setelah klaim Invite Link atau login dengan username dan password yang diberikan, <strong>wajib kirim screenshot</strong> ke Customer Service WhatsApp dengan <strong>batas maksimal waktu 3 jam</strong> sejak akun diterima.</p>
                        <div class="terms-badge warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                            Penting: Lewat 3 jam = garansi hangus
                        </div>
                    </div>
                </div>
                <div class="terms-card">
                    <div class="terms-number">2</div>
                    <div class="terms-info">
                        <h4>Garansi & Refund</h4>
                        <p>Jika ada masalah, terkena banned, atau akun tidak bisa diakses <strong>sebelum masa aktif berakhir</strong>, kami akan memberikan:</p>
                        <div class="terms-options">
                            <div class="option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                </svg>
                                <span>Akun Pengganti Baru</span>
                            </div>
                            <span class="atau">atau</span>
                            <div class="option">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                </svg>
                                <span>Refund 100%</span>
                            </div>
                        </div>
                        <div class="terms-badge success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            Garansi berlaku selama masa aktif akun
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- CONTACT SECTION --}}
        <section id="contact" class="contact-section">
            <div class="contact-header">
                <h2>Hubungi Kami</h2>
                <p>Butuh bantuan? Tim kami siap membantu Anda</p>
            </div>
            <div class="contact-grid">
                <a href="https://wa.me/628213256634" target="_blank" class="contact-card whatsapp">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                        </svg>
                    </div>
                    <span class="contact-label">WhatsApp</span>
                    <span class="contact-hint">Chat langsung</span>
                </a>
                <a href="https://shopee.co.id/nextizen" target="_blank" class="contact-card shopee">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                        </svg>
                    </div>
                    <span class="contact-label">Shopee</span>
                    <span class="contact-hint">Belanja aman</span>
                </a>
                <a href="https://instagram.com/nextizen__" target="_blank" class="contact-card instagram">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                        </svg>
                    </div>
                    <span class="contact-label">Instagram</span>
                    <span class="contact-hint">Follow kami</span>
                </a>
                <a href="https://www.tiktok.com/@nextizen" target="_blank" class="contact-card tiktok">
                    <div class="contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                        </svg>
                    </div>
                    <span class="contact-label">TikTok</span>
                    <span class="contact-hint">Video seru</span>
                </a>
            </div>
        </section>

    </div>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Nextzly. All rights reserved.</p>
        </div>
    </footer>

</div>

<style>
/* ===== MODERN HOME PAGE ===== */
.home-page {
    min-height: 100vh;
    background: #0f172a;
}

/* Hero Section */
.hero-section {
    position: relative;
    padding: 80px 20px 60px;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 50%, #1a1a2e 100%);
    z-index: 0;
}

.hero-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 1;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
}

.brand-logo-wrapper {
    margin-bottom: 24px;
}

.brand-logo {
    width: 100px;
    height: 100px;
    border-radius: 24px;
    object-fit: cover;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    border: 3px solid rgba(255,255,255,0.1);
}

.hero-title {
    font-size: 3rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px 0;
    letter-spacing: -1px;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.1rem;
    color: #3b82f6;
    font-weight: 600;
    margin: 0 0 12px 0;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.hero-desc {
    font-size: 1rem;
    color: #94a3b8;
    margin: 0 0 32px 0;
    line-height: 1.6;
}

/* Search Form */
.search-form {
    display: flex;
    gap: 12px;
    max-width: 500px;
    margin: 0 auto;
}

.search-wrapper {
    flex: 1;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
}

.search-input {
    width: 100%;
    padding: 16px 44px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    color: #ffffff;
    font-size: 0.95rem;
    outline: none;
    transition: all 0.3s;
}

.search-input::placeholder {
    color: #64748b;
}

.search-input:focus {
    background: rgba(255,255,255,0.08);
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
}

.search-clear {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: bold;
}

.search-btn {
    padding: 16px 28px;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
}

/* Floating Shapes */
.floating-shapes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.5;
}

.shape-1 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
    top: -100px;
    right: -50px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
    bottom: -50px;
    left: -50px;
    animation: float 10s ease-in-out infinite reverse;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
    top: 50%;
    left: 20%;
    animation: float 12s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Search Result Banner */
.search-result-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 16px;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.result-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.result-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(59, 130, 246, 0.2);
    border-radius: 10px;
    color: #3b82f6;
}

.result-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.result-label {
    color: #94a3b8;
    font-size: 0.8rem;
}

.result-keyword {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
}

.result-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.result-count-box {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 8px;
}

.count-number {
    color: #10b981;
    font-size: 1.1rem;
    font-weight: 700;
}

.count-text {
    color: #a7f3d0;
    font-size: 0.85rem;
    font-weight: 500;
}

.clear-search-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 8px;
    color: #f87171;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s;
}

.clear-search-btn:hover {
    background: rgba(239, 68, 68, 0.25);
    border-color: rgba(239, 68, 68, 0.5);
}

/* Category Section */
.category-section {
    margin-bottom: 40px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #f1f5f9;
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 20px 0;
}

.section-title svg {
    color: #3b82f6;
}

.category-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s;
}

.pill:hover {
    background: rgba(255,255,255,0.1);
    color: #ffffff;
}

.pill.active {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 5px 20px rgba(59, 130, 246, 0.3);
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.product-card {
    position: relative;
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border-radius: 20px;
    overflow: hidden;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.product-card:hover {
    transform: translateY(-8px);
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 25px 50px rgba(0,0,0,0.4);
}

.card-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.4s;
}

.product-card:hover .card-glow {
    opacity: 1;
}

.product-image {
    position: relative;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 20px;
}

.product-image img {
    max-width: 80px;
    max-height: 80px;
    object-fit: contain;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,0.1));
    transition: transform 0.4s;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.placeholder-image {
    color: #cbd5e1;
}

.category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 6px 12px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 6px;
    color: #ffffff;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-info {
    padding: 20px;
}

.product-name {
    color: #f1f5f9;
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.product-desc {
    color: #64748b;
    font-size: 0.85rem;
    margin: 0 0 16px 0;
    line-height: 1.5;
}

.product-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
}

.meta-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: rgba(255,255,255,0.05);
    border-radius: 6px;
    color: #94a3b8;
    font-size: 0.75rem;
}

.platform-info {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
}

.platform-chip {
    padding: 4px 10px;
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.25);
    border-radius: 6px;
    color: #60a5fa;
    font-size: 0.7rem;
    font-weight: 600;
}

.platform-chip.more {
    background: rgba(139, 92, 246, 0.15);
    border-color: rgba(139, 92, 246, 0.25);
    color: #a78bfa;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.product-price {
    color: #3b82f6;
    font-size: 1.1rem;
    font-weight: 700;
}

.buy-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 10px;
    color: white;
    transition: transform 0.3s;
}

.product-card:hover .buy-btn {
    transform: translateX(4px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    color: #334155;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #f1f5f9;
    font-size: 1.25rem;
    margin: 0 0 8px 0;
}

.empty-state p {
    color: #64748b;
    margin: 0 0 24px 0;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: rgba(59, 130, 246, 0.2);
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 10px;
    color: #60a5fa;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-reset:hover {
    background: rgba(59, 130, 246, 0.3);
}

/* ===== ABOUT SECTION ===== */
.about-section {
    margin-top: 60px;
    padding: 40px;
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 24px;
}

.about-header h2 {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #f1f5f9;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 32px 0;
}

.about-header h2 svg {
    color: #3b82f6;
}

.about-content {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 40px;
    align-items: start;
}

.about-logo {
    display: flex;
    justify-content: center;
}

.about-logo img {
    width: 150px;
    height: 150px;
    border-radius: 24px;
    object-fit: cover;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    border: 3px solid rgba(59, 130, 246, 0.3);
}

.about-desc {
    color: #94a3b8;
    font-size: 1rem;
    line-height: 1.8;
    margin: 0 0 24px 0;
}

.about-desc strong {
    color: #3b82f6;
}

.visi-misi {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.visi, .misi {
    padding: 24px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
}

.visi h4, .misi h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #f1f5f9;
    font-size: 1.1rem;
    margin: 0 0 12px 0;
}

.visi h4 svg, .misi h4 svg {
    color: #3b82f6;
}

.visi p, .misi p {
    color: #94a3b8;
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
}

.misi ul {
    color: #94a3b8;
    font-size: 0.9rem;
    line-height: 1.8;
    margin: 0;
    padding-left: 20px;
}

.misi li {
    margin-bottom: 8px;
}

/* ===== KEUNGGULAN SECTION ===== */
.keunggulan-section {
    margin-top: 60px;
}

.keunggulan-header {
    text-align: center;
    margin-bottom: 40px;
}

.keunggulan-header h2 {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #f1f5f9;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 12px 0;
}

.keunggulan-header h2 svg {
    color: #f59e0b;
}

.keunggulan-header p {
    color: #64748b;
    margin: 0;
}

.keunggulan-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.keunggulan-card {
    padding: 28px 24px;
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 20px;
    text-align: center;
    transition: all 0.4s;
}

.keunggulan-card:hover {
    transform: translateY(-8px);
    border-color: rgba(59, 130, 246, 0.3);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.keunggulan-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
    border-radius: 20px;
    color: #3b82f6;
}

.keunggulan-card h4 {
    color: #f1f5f9;
    font-size: 1.05rem;
    font-weight: 600;
    margin: 0 0 12px 0;
}

.keunggulan-card p {
    color: #64748b;
    font-size: 0.85rem;
    line-height: 1.6;
    margin: 0;
}

/* ===== TERMS SECTION ===== */
.terms-section {
    margin-top: 60px;
}

.terms-header {
    text-align: center;
    margin-bottom: 40px;
}

.terms-header h2 {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #f1f5f9;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 12px 0;
}

.terms-header h2 svg {
    color: #3b82f6;
}

.terms-header p {
    color: #64748b;
    margin: 0;
}

.terms-content {
    display: grid;
    gap: 20px;
}

.terms-card {
    display: flex;
    gap: 24px;
    padding: 28px;
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 20px;
}

.terms-number {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 14px;
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
}

.terms-info h4 {
    color: #f1f5f9;
    font-size: 1.15rem;
    font-weight: 600;
    margin: 0 0 12px 0;
}

.terms-info p {
    color: #94a3b8;
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0 0 16px 0;
}

.terms-info p strong {
    color: #f1f5f9;
}

.terms-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 500;
}

.terms-badge.warning {
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #fbbf24;
}

.terms-badge.success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #34d399;
}

.terms-options {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.terms-options .option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    color: #60a5fa;
    font-weight: 600;
}

.terms-options .atau {
    color: #64748b;
    font-size: 0.9rem;
}

/* Contact Section */
.contact-section {
    margin-top: 60px;
    text-align: center;
}

.contact-section .contact-header {
    margin-bottom: 32px;
}

.contact-section .contact-header h2 {
    color: #f1f5f9;
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.contact-section .contact-header p {
    color: #64748b;
    margin: 0;
    font-size: 1rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.contact-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 28px 20px;
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 20px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.contact-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.contact-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.05);
    border-radius: 16px;
    color: #94a3b8;
    transition: all 0.3s;
}

.contact-label {
    color: #f1f5f9;
    font-size: 1rem;
    font-weight: 600;
}

.contact-hint {
    color: #64748b;
    font-size: 0.8rem;
}

.contact-card.whatsapp:hover {
    border-color: rgba(37, 211, 102, 0.4);
}
.contact-card.whatsapp:hover .contact-icon {
    background: rgba(37, 211, 102, 0.2);
    color: #25d366;
}

.contact-card.shopee:hover {
    border-color: rgba(238, 77, 45, 0.4);
}
.contact-card.shopee:hover .contact-icon {
    background: rgba(238, 77, 45, 0.2);
    color: #ee4d2d;
}

.contact-card.instagram:hover {
    border-color: rgba(225, 48, 108, 0.4);
}
.contact-card.instagram:hover .contact-icon {
    background: rgba(225, 48, 108, 0.2);
    color: #e1306c;
}

.contact-card.tiktok:hover {
    border-color: rgba(255, 0, 80, 0.4);
}
.contact-card.tiktok:hover .contact-icon {
    background: rgba(255, 0, 80, 0.2);
    color: #ff0050;
}

/* Footer */
.site-footer {
    margin-top: 60px;
    padding: 24px 20px;
    border-top: 1px solid rgba(255,255,255,0.05);
    text-align: center;
}

.site-footer p {
    color: #475569;
    font-size: 0.85rem;
    margin: 0;
}

/* Responsive */
@media (max-width: 1024px) {
    .keunggulan-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .hero-section { padding: 60px 20px 40px; }
    .hero-title { font-size: 2rem; }
    .hero-subtitle { font-size: 0.9rem; letter-spacing: 2px; }
    .search-form { flex-direction: column; }
    .search-btn { width: 100%; }
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
    .contact-grid { grid-template-columns: repeat(2, 1fr); }
    .about-content { grid-template-columns: 1fr; text-align: center; }
    .about-section { padding: 28px; }
    .visi-misi { grid-template-columns: 1fr; }
    .keunggulan-grid { grid-template-columns: 1fr; }
    .terms-card { flex-direction: column; text-align: center; }
    .terms-number { margin: 0 auto; }
}

@media (max-width: 600px) {
    .search-result-banner {
        flex-direction: column;
        align-items: flex-start;
    }
    .result-right {
        width: 100%;
        justify-content: space-between;
    }
    .terms-options {
        flex-direction: column;
        align-items: stretch;
    }
    .terms-options .option {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .contact-grid { grid-template-columns: 1fr; }
}
</style>
@endsection
