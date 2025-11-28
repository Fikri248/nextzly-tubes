@extends('layouts.app')

@section('content')
<div class="product-page-wrapper">
    <div class="product-page-container">

        {{-- PRODUCT INFO --}}
        <div class="product-header-box">
            <img src="{{ asset('logo/' . $product->logo) }}" alt="{{ $product->nama_produk }}" class="product-logo">
            <div class="product-info">
                <h1>{{ $product->nama_produk }}</h1>
                <p>{{ $product->deskripsi }}</p>
            </div>
        </div>

        {{-- PILIH NOMINAL LAYANAN --}}
        <div class="selection-section">
            <div class="section-main-header">
                <span class="icon-payment">🎯</span>
                <h2>Pilih Nominal Layanan</h2>
            </div>

            <div class="price-packages-container">
                @foreach($product->paket_harga as $index => $package)
                    <label class="package-item">
                        <div class="package-info">
                            <div class="package-details">
                                <span class="package-duration">{{ $package['durasi'] }}</span>
                                <span class="package-price">Rp {{ number_format($package['harga'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <input type="radio" name="selected_package" value="{{ $index }}"
                               data-duration="{{ $package['durasi'] }}"
                               data-price="{{ $package['harga'] }}"
                               {{ $index == 0 ? 'checked' : '' }}>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- PILIH PEMBAYARAN --}}
        <div class="payment-section-unified">
            <div class="section-main-header">
                <span class="icon-payment">💳</span>
                <h2>Pilih Pembayaran</h2>
            </div>

            <div class="payment-methods-container">

                {{-- SCAN QRIS --}}
                <div class="payment-method-group">
                    <div class="method-header" onclick="toggleMethod('qris')">
                        <div class="method-title">
                            <span class="icon-small">📱</span>
                            <span>Scan QRIS</span>
                        </div>
                        <span class="chevron-small rotated" id="qris-chevron">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <div class="method-content" id="qris-content">
                        <label class="payment-item">
                            <div class="payment-info">
                                <div class="qris-logo-wrapper">
                                    <svg viewBox="0 0 100 40" class="payment-logo">
                                        <rect fill="#FF0000" width="100" height="40" rx="6"/>
                                        <text x="50" y="26" font-size="18" fill="white" text-anchor="middle" font-weight="bold">QRIS</text>
                                    </svg>
                                </div>
                                <span class="payment-name">QRIS (Semua Bank & E-Wallet)</span>
                            </div>
                            <input type="radio" name="payment_method" value="qris" data-label="QRIS" checked>
                        </label>
                    </div>
                </div>

                {{-- E-WALLET --}}
                <div class="payment-method-group">
                    <div class="method-header" onclick="toggleMethod('ewallet')">
                        <div class="method-title">
                            <span class="icon-small">💳</span>
                            <span>E-Wallet</span>
                        </div>
                        <span class="chevron-small" id="ewallet-chevron">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <div class="method-content collapsed" id="ewallet-content">
                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
                                     alt="OVO" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%234a148c%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2718%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EOVO%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">OVO</span>
                            </div>
                            <input type="radio" name="payment_method" value="ovo" data-label="OVO">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg"
                                     alt="DANA" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%23118eea%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2718%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EDANA%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">DANA</span>
                            </div>
                            <input type="radio" name="payment_method" value="dana" data-label="DANA">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg"
                                     alt="ShopeePay" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%23ee4d2d%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2714%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3ESHOPEEPAY%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">SHOPEEPAY</span>
                            </div>
                            <input type="radio" name="payment_method" value="shopeepay" data-label="ShopeePay">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/LinkAja.svg"
                                     alt="LinkAja" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%23e01e1e%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2716%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3ELINKAJA%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">LINKAJA</span>
                            </div>
                            <input type="radio" name="payment_method" value="linkaja" data-label="LinkAja">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg"
                                     alt="GoPay" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%2300aa13%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2718%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EGOPAY%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">GOPAY</span>
                            </div>
                            <input type="radio" name="payment_method" value="gopay" data-label="GoPay">
                        </label>
                    </div>
                </div>

                {{-- VIRTUAL ACCOUNT --}}
                <div class="payment-method-group">
                    <div class="method-header" onclick="toggleMethod('va')">
                        <div class="method-title">
                            <span class="icon-small">🏦</span>
                            <span>Virtual Account</span>
                        </div>
                        <span class="chevron-small" id="va-chevron">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <div class="method-content collapsed" id="va-content">
                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg"
                                     alt="BNI" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%23fd7e14%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2718%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EBNI%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">BNI VIRTUAL ACCOUNT</span>
                            </div>
                            <input type="radio" name="payment_method" value="bni_va" data-label="BNI Virtual Account">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                                     alt="Mandiri" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%23003d79%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2714%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EMANDIRI%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">MANDIRI VIRTUAL ACCOUNT</span>
                            </div>
                            <input type="radio" name="payment_method" value="mandiri_va" data-label="Mandiri Virtual Account">
                        </label>

                        <label class="payment-item">
                            <div class="payment-info">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg"
                                     alt="BRI" class="payment-logo"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 40%27%3E%3Crect fill=%27%230066a1%27 width=%27100%27 height=%2740%27 rx=%275%27/%3E%3Ctext x=%2750%27 y=%2726%27 font-size=%2718%27 fill=%27white%27 text-anchor=%27middle%27 font-weight=%27bold%27%3EBRI%3C/text%3E%3C/svg%3E'">
                                <span class="payment-name">BRI VIRTUAL ACCOUNT</span>
                            </div>
                            <input type="radio" name="payment_method" value="bri_va" data-label="BRI Virtual Account">
                        </label>
                    </div>
                </div>

            </div>
        </div>

        {{-- ORDER SUMMARY & BUTTON --}}
        <div class="checkout-footer">
            <div class="total-display">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-price" id="totalPrice">Rp {{ number_format($product->paket_harga[0]['harga'], 0, ',', '.') }}</span>
            </div>
            <button class="btn-checkout" onclick="processPayment()">
                Bayar Sekarang
            </button>
        </div>

    </div>
</div>

<script>
// Data produk dari backend
const productName = "{{ $product->nama_produk }}";
const adminWhatsapp = "6281239660249"; // GANTI dengan nomor admin

// Update total saat pilih paket
document.querySelectorAll('input[name="selected_package"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const price = this.dataset.price;
        document.getElementById('totalPrice').textContent =
            'Rp ' + parseInt(price).toLocaleString('id-ID');
    });
});

function toggleMethod(method) {
    const content = document.getElementById(method + '-content');
    const chevron = document.getElementById(method + '-chevron');

    content.classList.toggle('collapsed');
    chevron.classList.toggle('rotated');
}

function processPayment() {
    const selectedPackage = document.querySelector('input[name="selected_package"]:checked');
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

    if (!selectedPackage || !selectedPayment) {
        alert('Silakan pilih paket dan metode pembayaran!');
        return;
    }

    const duration = selectedPackage.dataset.duration;
    const price = selectedPackage.dataset.price;
    const paymentLabel = selectedPayment.dataset.label;

    // Format pesan WhatsApp TANPA EMOJI
    const message = `
*PESANAN BARU*

Produk: ${productName}
Paket: ${duration}
Total: Rp ${parseInt(price).toLocaleString('id-ID')}
Pembayaran: ${paymentLabel}

Mohon konfirmasi untuk melanjutkan pembayaran. Terima kasih!
    `.trim();

    // Encode URL
    const encodedMessage = encodeURIComponent(message);

    // Redirect ke WhatsApp
    const whatsappUrl = `https://wa.me/${adminWhatsapp}?text=${encodedMessage}`;
    window.open(whatsappUrl, '_blank');
}
</script>

<style>
/* ===== PRODUCT PAGE THEME ===== */
.product-page-wrapper {
    min-height: 100vh;
    background: #cbd5e1;
    padding: 40px 20px;
}

.product-page-container {
    max-width: 700px;
    margin: 0 auto;
}

/* Product Header */
.product-header-box {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.product-logo {
    width: 80px;
    height: 80px;
    object-fit: contain;
    background: white;
    border-radius: 12px;
    padding: 12px;
    border: 1px solid #e2e8f0;
}

.product-info h1 {
    color: #1e293b;
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.product-info p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0;
}

/* Selection Section */
.selection-section {
    background: #2c3e50;
    border: 1px solid #cbd5e1;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.section-main-header {
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #2c3e50;
}

.icon-payment {
    font-size: 1.5rem;
}

.section-main-header h2 {
    color: #f8fafc;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
}

/* Price Packages Container */
.price-packages-container {
    background: #e2e8f0;
    padding: 20px 24px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
}

.package-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 16px;
    background: white;
    border: 2px solid #cbd5e1;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
}

.package-item:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

.package-item:has(input:checked) {
    background: white;
    border-color: #38bdf8;
    box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
}

.package-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 12px;
}

.package-duration {
    color: #1e293b;
    font-weight: 600;
    font-size: 0.95rem;
}

.package-price {
    color: #38bdf8;
    font-weight: 700;
    font-size: 1.1rem;
}

.package-item input[type="radio"] {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #38bdf8;
}

/* Payment Section Unified */
.payment-section-unified {
    background: #2c3e50;
    border: 1px solid #cbd5e1;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.payment-methods-container {
    background: #e2e8f0;
    padding: 0;
}

.payment-method-group {
    border-bottom: 1px solid #cbd5e1;
}

.payment-method-group:last-child {
    border-bottom: none;
}

.method-header {
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    background: #5f6c7a;
    transition: background 0.2s;
    min-height: 56px;
}

.method-header:hover {
    background: #6b7888;
}

.method-title {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #f8fafc;
    font-weight: 500;
    font-size: 0.95rem;
}

.icon-small {
    font-size: 1.2rem;
}

.chevron-small {
    color: #cbd5e1;
    transition: transform 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
}

.chevron-small svg {
    stroke: currentColor;
}

.chevron-small.rotated {
    transform: rotate(180deg);
}

.method-content {
    max-height: 1000px;
    overflow: hidden;
    transition: max-height 0.4s ease-in-out, padding 0.4s;
    padding: 16px 24px 16px 24px;
    background: #e2e8f0;
}

.method-content.collapsed {
    max-height: 0;
    padding: 0 24px;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: white;
    border: 2px solid #cbd5e1;
    border-radius: 12px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-item:last-child {
    margin-bottom: 0;
}

.payment-item:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

.payment-item:has(input:checked) {
    background: white;
    border-color: #38bdf8;
    box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
}

.payment-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.qris-logo-wrapper {
    width: 60px;
    height: 30px;
}

.payment-logo {
    width: 60px;
    height: 30px;
    object-fit: contain;
}

.payment-name {
    color: #1e293b;
    font-weight: 500;
    font-size: 0.95rem;
}

.payment-item input[type="radio"] {
    width: 22px;
    height: 22px;
    cursor: pointer;
    accent-color: #38bdf8;
}

/* Checkout Footer */
.checkout-footer {
    margin-top: 32px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.total-display {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.total-label {
    color: #475569;
    font-size: 1rem;
    font-weight: 500;
}

.total-price {
    color: #38bdf8;
    font-size: 1.8rem;
    font-weight: 700;
}

.btn-checkout {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(56, 189, 248, 0.4);
}

.btn-checkout:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .product-page-wrapper {
        padding: 20px 16px;
    }

    .product-header-box {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }

    .price-packages-container {
        grid-template-columns: repeat(2, 1fr);
        padding: 16px;
        gap: 10px;
    }

    .package-item {
        padding: 12px;
    }

    .package-duration {
        font-size: 0.85rem;
    }

    .package-price {
        font-size: 1rem;
    }

    .method-header {
        padding: 14px 20px;
    }

    .method-content {
        padding: 12px 20px 12px 20px;
    }

    .payment-item {
        padding: 14px 16px;
    }

    .payment-logo {
        width: 50px;
        height: 25px;
    }

    .payment-name {
        font-size: 0.9rem;
    }

    .total-price {
        font-size: 1.5rem;
    }
}
</style>
@endsection
