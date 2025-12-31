@extends('layouts.app')

@section('content')
    <div class="product-page">
        <div class="product-container">

            {{-- BACK BUTTON --}}
            <a href="{{ route('homepage') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Kembali
            </a>

            {{-- ALERT MESSAGES --}}
            @if (session('error'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- PRODUCT CARD --}}
            <div class="product-card">
                {{-- Header dengan gradient --}}
                <div class="card-header">
                    <div class="header-content">
                        @if ($product->logo)
                            <img src="{{ asset('logo/' . $product->logo) }}" alt="{{ $product->nama_produk }}"
                                class="product-logo">
                        @else
                            <div class="product-logo placeholder-logo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                    <path
                                        d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                </svg>
                            </div>
                        @endif
                        <div class="product-title-section">
                            <h1>{{ $product->nama_produk }}</h1>
                            <p class="product-desc">{{ $product->deskripsi ?? 'Produk digital premium berkualitas tinggi' }}
                            </p>
                        </div>
                    </div>
                    <div class="product-badges">
                        <span class="badge badge-category">{{ $product->category->nama_kategori ?? 'Digital' }}</span>
                        @if ($product->tipe_akun)
                            <span class="badge badge-type">{{ ucfirst(str_replace('_', ' ', $product->tipe_akun)) }}</span>
                        @endif
                    </div>
                </div>

                {{-- Product Details --}}
                <div class="card-body">
                    {{-- Platform --}}
                    @if ($product->platform)
                        <div class="platform-section">
                            <span class="section-label">Platform Tersedia</span>
                            <div class="platform-tags">
                                @foreach (explode(',', $product->platform) as $p)
                                    <span class="platform-tag">
                                        @if (trim($p) == 'Web')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                                            </svg>
                                        @elseif(trim($p) == 'Android')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.76 3.061a.5.5 0 0 1 .679.2l1.283 2.352A8.94 8.94 0 0 1 8 5a8.94 8.94 0 0 1 3.278.613l1.283-2.352a.5.5 0 1 1 .878.478l-1.252 2.295C14.475 7.266 16 9.477 16 12H0c0-2.523 1.525-4.734 3.813-5.966L2.56 3.74a.5.5 0 0 1 .2-.678zM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                            </svg>
                                        @elseif(trim($p) == 'iOS')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282z" />
                                            </svg>
                                        @elseif(trim($p) == 'Windows')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.555 1.375 0 2.237v5.45h6.555V1.375zM0 8.313v5.45l6.555.862V8.312H0zm7.278-7.05v6.424H16V.313L7.278 1.262zM16 8.313H7.278v6.425L16 15.687V8.312z" />
                                            </svg>
                                        @elseif(trim($p) == 'MacOS')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282z" />
                                            </svg>
                                        @elseif(trim($p) == 'Smart TV')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 13.5A.5.5 0 0 1 3 13h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zM13.991 3l.024.001a1.46 1.46 0 0 1 .538.143.757.757 0 0 1 .302.254c.067.1.145.277.145.602v5.991l-.001.024a1.464 1.464 0 0 1-.143.538.758.758 0 0 1-.254.302c-.1.067-.277.145-.602.145H2.009l-.024-.001a1.464 1.464 0 0 1-.538-.143.757.757 0 0 1-.302-.254C1.078 10.502 1 10.325 1 10V4.009l.001-.024a1.46 1.46 0 0 1 .143-.538.758.758 0 0 1 .254-.302C1.498 3.078 1.675 3 2 3h11.991zM14 2H2C0 2 0 4 0 4v6c0 2 2 2 2 2h12c2 0 2-2 2-2V4c0-2-2-2-2-2z" />
                                            </svg>
                                        @else<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                                                <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                            </svg>
                                        @endif
                                        {{ trim($p) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Price Card --}}
                    <div class="price-card">
                        <div class="price-info">
                            <span class="duration-label">Durasi Akses</span>
                            <span class="duration-value">{{ $product->durasi }} Hari</span>
                        </div>
                        <div class="price-amount">
                            <span class="currency">Rp</span>
                            <span class="amount">{{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="stock-info">
                            @if ($product->stok > 0)
                                <span class="stock-badge available">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                    Stok Tersedia: {{ $product->stok }}
                                </span>
                            @else
                                <span class="stock-badge empty">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                    </svg>
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- PAYMENT SECTION - QRIS ONLY --}}
            @if ($product->stok > 0)
                <div class="payment-card">
                    <div class="payment-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                        </svg>
                        <h2>Pembayaran QRIS</h2>
                    </div>

                    <div class="qris-section">
                        <div class="qris-image-wrapper">
                            <img src="{{ asset('qris.jpeg') }}" alt="QRIS Payment" class="qris-image">
                        </div>
                        <div class="qris-info">
                            <p class="qris-instruction">Scan QR Code di atas menggunakan aplikasi e-wallet atau mobile
                                banking Anda</p>
                            <div class="qris-supported">
                                <span>Didukung oleh:</span>
                                <div class="wallet-icons">
                                    <span class="wallet-badge">GoPay</span>
                                    <span class="wallet-badge">OVO</span>
                                    <span class="wallet-badge">DANA</span>
                                    <span class="wallet-badge">ShopeePay</span>
                                    <span class="wallet-badge">LinkAja</span>
                                    <span class="wallet-badge">Bank Apps</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="total-section">
                        <div class="total-row">
                            <span class="total-label">Total Pembayaran</span>
                            <span class="total-value">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- CUSTOMER FORM OR WHATSAPP BUTTON --}}
                    <div class="checkout-section">
                        @if (session('order_success'))
                            {{-- ORDER SUCCESS - SHOW WHATSAPP BUTTON --}}
                            @php $order = session('order'); @endphp
                            <div class="order-success-info">
                                <div class="success-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                </div>
                                <h3>Pesanan Berhasil Dibuat!</h3>
                                <p class="order-id">Order ID: <strong>{{ $order['order_id'] }}</strong></p>
                                <div class="order-detail-box">
                                    <div class="detail-row">
                                        <span>Nama</span>
                                        <span>{{ $order['customer_name'] }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span>No. Telepon</span>
                                        <span>{{ $order['customer_phone'] }}</span>
                                    </div>
                                    @if ($order['customer_email'])
                                        <div class="detail-row">
                                            <span>Email</span>
                                            <span>{{ $order['customer_email'] }}</span>
                                        </div>
                                    @endif
                                    <div class="detail-row">
                                        <span>Produk</span>
                                        <span>{{ $order['product_name'] }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span>Durasi</span>
                                        <span>{{ $order['product_duration'] }} Hari</span>
                                    </div>
                                    <div class="detail-row total">
                                        <span>Total</span>
                                        <span>Rp {{ number_format($order['product_price'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-confirm" onclick="confirmPayment()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                                Konfirmasi via WhatsApp
                            </button>
                            <p class="confirm-note">Klik tombol di atas untuk konfirmasi pembayaran ke admin</p>

                            <script>
                                const orderData = @json($order);
                                const adminWhatsapp = "6281239660249";

                                function confirmPayment() {
                                    const priceFormatted = new Intl.NumberFormat('id-ID').format(orderData.product_price);

                                    let message = `Halo Admin Nextzly!

Saya sudah melakukan pembayaran via QRIS untuk pesanan berikut:

*DETAIL PESANAN*
-------------------
Order ID: ${orderData.order_id}
Produk: ${orderData.product_name}
Durasi: ${orderData.product_duration} Hari
Total: Rp ${priceFormatted}

*DATA PELANGGAN*
-------------------
Nama: ${orderData.customer_name}
No. HP: ${orderData.customer_phone}`;

                                    if (orderData.customer_email) {
                                        message += `\nEmail: ${orderData.customer_email}`;
                                    }

                                    if (orderData.catatan) {
                                        message += `\n\nCatatan: ${orderData.catatan}`;
                                    }

                                    message += `\n\nMohon diproses pesanan saya. Terima kasih!`;

                                    const encodedMessage = encodeURIComponent(message.trim());
                                    window.open(`https://wa.me/${adminWhatsapp}?text=${encodedMessage}`, '_blank');
                                }
                            </script>
                        @else
                            {{-- CUSTOMER FORM --}}
                            <div class="customer-form-section">
                                <h3 class="form-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    </svg>
                                    Data Pemesan
                                </h3>
                                <p class="form-subtitle">Isi data di bawah untuk melanjutkan pemesanan</p>

                                <form action="{{ route('product.order', $product->id) }}" method="POST"
                                    class="customer-form">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Masukkan nama lengkap" required>
                                        @error('name')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Nomor WhatsApp <span class="required">*</span></label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="Contoh: 08123456789" required>
                                        @error('phone')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email <span class="optional">(Opsional)</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            placeholder="email@contoh.com">
                                        @error('email')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="catatan">Catatan Pesanan <span
                                                class="optional">(Opsional)</span></label>
                                        <textarea id="catatan" name="catatan" rows="3" placeholder="Contoh: Tolong kirim akun ke email saya">{{ old('catatan') }}</textarea>
                                    </div>

                                    <button type="submit" class="btn-submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                        </svg>
                                        Simpan & Lanjutkan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="out-of-stock-card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                    <h3>Produk Sedang Tidak Tersedia</h3>
                    <p>Stok untuk produk ini sedang habis. Silakan cek kembali nanti atau hubungi admin.</p>
                    <a href="{{ route('homepage') }}" class="btn-back">Kembali ke Home</a>
                </div>
            @endif

        </div>
    </div>

    <style>
        /* ===== MODERN PRODUCT PAGE ===== */
        .product-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            padding: 40px 20px;
        }

        .product-container {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #ffffff;
        }

        /* Product Card */
        .product-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-bottom: 24px;
        }

        .card-header {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            padding: 32px 28px;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .product-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .placeholder-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        .product-title-section h1 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .product-desc {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        .product-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-category {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .badge-type {
            background: rgba(0, 0, 0, 0.3);
            color: white;
        }

        /* Card Body */
        .card-body {
            padding: 28px;
        }

        .platform-section {
            margin-bottom: 24px;
        }

        .section-label {
            display: block;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .platform-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .platform-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            color: #60a5fa;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Price Card */
        .price-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .price-info {
            margin-bottom: 12px;
        }

        .duration-label {
            display: block;
            color: #64748b;
            font-size: 0.8rem;
            margin-bottom: 4px;
        }

        .duration-value {
            color: #e2e8f0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .price-amount {
            margin-bottom: 16px;
        }

        .currency {
            color: #3b82f6;
            font-size: 1.2rem;
            font-weight: 600;
            vertical-align: top;
        }

        .amount {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stock-badge.available {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .stock-badge.empty {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Payment Card */
        .payment-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .payment-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .payment-header h2 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .qris-section {
            padding: 28px;
            text-align: center;
        }

        .qris-image-wrapper {
            background: white;
            border-radius: 16px;
            padding: 20px;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .qris-image {
            max-width: 220px;
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .qris-instruction {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0 0 20px 0;
            line-height: 1.6;
        }

        .qris-supported span {
            color: #64748b;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 10px;
        }

        .wallet-icons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .wallet-badge {
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Total Section */
        .total-section {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px 28px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .total-value {
            color: #10b981;
            font-size: 1.5rem;
            font-weight: 800;
        }

        /* Checkout Section */
        .checkout-section {
            background: rgba(0, 0, 0, 0.3);
            padding: 24px 28px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Customer Form */
        .customer-form-section {
            margin-bottom: 0;
        }

        .form-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #f1f5f9;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 6px 0;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 0.85rem;
            margin: 0 0 20px 0;
        }

        .customer-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .form-group .required {
            color: #ef4444;
        }

        .form-group .optional {
            color: #64748b;
            font-weight: 400;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #f1f5f9;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #475569;
        }

        .form-group textarea {
            resize: none;
        }

        .error-text {
            color: #f87171;
            font-size: 0.8rem;
        }

        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
        }

        /* Order Success */
        .order-success-info {
            text-align: center;
            margin-bottom: 24px;
        }

        .success-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: rgba(16, 185, 129, 0.15);
            border-radius: 50%;
            color: #34d399;
            margin-bottom: 16px;
        }

        .order-success-info h3 {
            color: #34d399;
            font-size: 1.2rem;
            margin: 0 0 8px 0;
        }

        .order-id {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0 0 20px 0;
        }

        .order-id strong {
            color: #f1f5f9;
            font-family: monospace;
        }

        .order-detail-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 16px;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.85rem;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row span:first-child {
            color: #64748b;
        }

        .detail-row span:last-child {
            color: #e2e8f0;
            font-weight: 500;
        }

        .detail-row.total {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
        }

        .detail-row.total span:last-child {
            color: #10b981;
            font-weight: 700;
            font-size: 1rem;
        }

        .btn-confirm {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(34, 197, 94, 0.4);
        }

        .confirm-note {
            color: #64748b;
            font-size: 0.8rem;
            text-align: center;
            margin: 16px 0 0 0;
        }

        /* Out of Stock */
        .out-of-stock-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            padding: 48px 28px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .out-of-stock-card svg {
            color: #ef4444;
            margin-bottom: 20px;
        }

        .out-of-stock-card h3 {
            color: #f1f5f9;
            font-size: 1.25rem;
            margin: 0 0 12px 0;
        }

        .out-of-stock-card p {
            color: #94a3b8;
            font-size: 0.9rem;
            margin: 0 0 24px 0;
        }

        .btn-back {
            display: inline-block;
            padding: 12px 24px;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: rgba(59, 130, 246, 0.3);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .product-page {
                padding: 20px 16px;
            }

            .card-header {
                padding: 24px 20px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .product-badges {
                justify-content: center;
            }

            .card-body {
                padding: 20px;
            }

            .qris-section {
                padding: 20px;
            }

            .checkout-section {
                padding: 20px;
            }

            .total-section {
                padding: 16px 20px;
            }

            .amount {
                font-size: 2rem;
            }

            .total-value {
                font-size: 1.3rem;
            }
        }
    </style>
@endsection
