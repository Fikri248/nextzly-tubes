<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Nextzly Tubes</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* --- 1. RESET & BODY --- */
        body {
            font-family: 'Montserrat', 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            color: #1a1a2e;
            margin: 0;
            padding: 0;
        }

        /* --- 2. NAVBAR --- */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .navbar-menu a {
            color: #1a1a2e;
            font-weight: 600;
            text-decoration: none;
            margin-left: 25px;
            transition: color 0.3s;
        }
        .navbar-menu a:hover { color: #667eea; }

        /* --- 3. CONTAINER --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 50px 30px;
        }

        /* --- 4. HERO SECTION (JUMBOTRON) --- */
        .jumbotron {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 50px;
            border-radius: 24px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-bottom: 50px;
            color: #fff;
        }
        .jumbotron h1 { font-size: 3rem; margin-bottom: 15px; font-weight: 800; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .jumbotron p { font-size: 1.2rem; opacity: 0.9; }

        /* --- 5. FILTER BUTTONS --- */
        .features-row {
            display: flex;
            gap: 15px;
            margin-bottom: 50px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .feature-card {
            background: #fff;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            background: #667eea;
            color: #fff;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

   /* --- 6. GRID LAYOUT (4x4) --- */
        .catalog-main {
            display: grid;
            grid-template-columns: repeat(4, 1fr);

            /* JARAK SAMPING (Kiri-Kanan) */
            column-gap: 40px; /* Ditambah dari 30px jadi 40px */

            /* JARAK ATAS-BAWAH (Row) */
            row-gap: 80px; /* Ditambah drastis dari 60px jadi 80px */

            width: 100%;
            margin-bottom: 80px; /* Jarak extra di paling bawah grid */
        }

        /* --- 7. PRODUCT CARD --- */
        .product-card {
            background: #fff;
            border-radius: 24px;
            padding: 25px;
            /* Shadow diperhalus agar tidak terlalu menyebar ke bawah */
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 520px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            /* Tambahan: Memastikan background card putih solid */
            z-index: 1;
        }

        /* Efek Hover: Kartu naik, bayangan makin soft */
        .product-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2);
            z-index: 5; /* Supaya saat hover dia di atas card lain */
        }


        /* Badge Kategori */
        .badge-cat {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            z-index: 2;
            white-space: nowrap;
        }

        /* Logo Area */
        .prod-logo-container {
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .prod-logo {
            max-width: 120px;
            max-height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
        }

        /* Text Content */
        .prod-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 10px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .prod-type-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .prod-type {
            background: #e0e7ff;
            color: #4338ca;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .prod-desc {
            font-size: 0.85rem;
            color: #6b7280;
            text-align: center;
            line-height: 1.5;
            margin-bottom: 20px;
            height: 42px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .prod-price {
            font-size: 1.4rem;
            font-weight: 900;
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 20px;
            margin-top: auto; /* Dorong harga ke bawah */
        }

        /* --- 8. BUTTONS AREA (PERBAIKAN UTAMA) --- */
        .prod-buttons {
            display: grid;
            /* Membagi 2 kolom sama rata */
            grid-template-columns: 1fr 1fr;
            /* Jarak antar tombol (GAP) */
            gap: 15px;
            margin-top: 10px;
        }

        .btn-custom {
            padding: 12px 0;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            text-align: center;
            text-decoration: none;
            transition: transform 0.2s;
            border: none;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        .btn-detail {
            background: #e0e7ff;
            color: #4338ca;
        }
        .btn-order {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(56, 239, 125, 0.3);
        }

        .btn-custom:hover { transform: translateY(-2px); }

        /* --- 9. FOOTER --- */
        footer {
            margin-top: 80px;
            padding: 40px;
            text-align: center;
            color: rgba(255,255,255,0.8);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* --- 10. RESPONSIVE --- */
        @media (max-width: 1200px) {
            .catalog-main { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 900px) {
            .catalog-main { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 500px) {
            .catalog-main { grid-template-columns: 1fr; }
            .features-row { gap: 10px; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a class="navbar-brand" href="{{ route('home') }}">Nextzly Tubes</a>
        <div class="navbar-menu">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">About</a>
        </div>
    </nav>

    <div class="container">

        {{-- HERO --}}
        <div class="jumbotron">
            <h1>Premium Digital Apps</h1>
            <p>Dapatkan akses premium layanan digital favoritmu dengan harga terbaik.</p>
        </div>

        {{-- FILTER --}}
        <div class="features-row">
            <a href="{{ route('home') }}" class="feature-card">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->id]) }}" class="feature-card">
                    {{ $cat->nama_kategori }}
                </a>
            @endforeach
        </div>

        {{-- KATALOG PRODUK --}}
        <div class="catalog-main">
            @forelse($products as $product)
                <div class="product-card">
                    {{-- Badge Kategori --}}
                    <div class="badge-cat">{{ $product->category->nama_kategori ?? 'Digital' }}</div>

                    {{-- Logo --}}
                    <div class="prod-logo-container">
                        <img src="{{ asset('logo/' . $product->logo) }}" class="prod-logo" alt="{{ $product->nama_produk }}">
                    </div>

                    {{-- Judul --}}
                    <div class="prod-title">{{ $product->nama_produk }}</div>

                    {{-- Tipe Akun --}}
                    <div class="prod-type-container">
                        <span class="prod-type">{{ $product->tipe_akun }}</span>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="prod-desc">
                        {{ $product->deskripsi }}
                    </div>

                    {{-- Harga --}}
                    <div class="prod-price">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>

                    {{-- Tombol --}}
                    <div class="prod-buttons">
                        <a href="{{ route('product.show', $product->id) }}" class="btn-custom btn-detail">Detail</a>
                        <a href="#" class="btn-custom btn-order">Order</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 4; text-align: center; color: white; padding: 50px;">
                    <h3>Belum ada produk tersedia.</h3>
                </div>
            @endforelse
        </div>

    </div>

    <footer>
        &copy; 2025 Nextzly Tubes. All Rights Reserved.
    </footer>

</body>
</html>
