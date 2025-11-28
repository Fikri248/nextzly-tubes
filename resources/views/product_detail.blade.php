<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_produk }} - Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    {{-- Panggil CSS yang sama dengan home agar tampilan konsisten --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Tambahan CSS khusus halaman detail */
        .detail-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        .detail-img {
            max-width: 200px;
            margin-bottom: 30px;
            border-radius: 15px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>

    {{-- Navbar Sederhana --}}
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Nextzly Tubes</a>
        </div>
    </nav>

    <div class="detail-container">
        {{-- Logo Produk --}}
        <img src="{{ asset('logo/' . $product->logo) }}" alt="{{ $product->nama_produk }}" class="detail-img">

        {{-- Judul --}}
        <h1 style="font-size: 2rem; color: #1a1a2e; margin-bottom: 10px;">{{ $product->nama_produk }}</h1>

        {{-- Badge Kategori --}}
        <span class="prod-type">{{ $product->tipe_akun }}</span>

        {{-- Harga --}}
        <h2 class="prod-price" style="margin: 20px 0;">Rp {{ number_format($product->harga, 0, ',', '.') }}</h2>

        {{-- Deskripsi Lengkap --}}
        <p style="line-height: 1.8; color: #555; font-size: 1.1rem;">
            {{ $product->deskripsi }}
        </p>
        <p style="color: #888; margin-top: 10px;">Durasi: <strong>{{ $product->durasi }} Hari</strong></p>

        {{-- Tombol Aksi --}}
        <div style="margin-top: 40px;">
            {{-- Link Pembayaran (WA/Eksternal) --}}
            <a href="#" class="prod-btn" style="padding: 15px 40px; font-size: 1.1rem;">Beli Sekarang</a>
        </div>

        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Home</a>
    </div>

</body>
</html>
