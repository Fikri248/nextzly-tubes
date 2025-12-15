<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Nextzly</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
            background: #fff;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 3px;
            font-weight: 700;
        }

        .header .subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .header .meta {
            font-size: 10px;
            color: #9ca3af;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* ===== SUMMARY CARDS ===== */
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            text-align: center;
        }

        .summary-item.highlight {
            background: #dbeafe;
            border-color: #0284c7;
        }

        .summary-item.warning {
            background: #fef3c7;
            border-color: #eab308;
        }

        .summary-item.success {
            background: #dcfce7;
            border-color: #22c55e;
        }

        .summary-item .label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .summary-item .value {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
        }

        .summary-item.highlight .value {
            color: #0284c7;
        }

        .summary-item.warning .value {
            color: #b45309;
        }

        .summary-item.success .value {
            color: #15803d;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
            background: #f3f4f6;
            padding: 8px 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #3b82f6;
        }

        /* ===== TABLES ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        thead {
            background: #374151;
            color: #fff;
        }

        thead th {
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid #1f2937;
        }

        tbody td {
            padding: 7px 8px;
            border: 1px solid #e5e7eb;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        /* Alignment */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }

        .footer-item {
            display: inline-block;
            margin: 0 15px;
        }

        /* ===== PAGE BREAK ===== */
        .page-break {
            page-break-after: always;
            margin: 20px 0;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-pending {
            background: #fef3c7;
            color: #b45309;
        }

        /* ===== PRINT ===== */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- HEADER --}}
        <div class="header">
            <h1>LAPORAN PENDAPATAN</h1>
            <p class="subtitle">NEXTZLY - PLATFORM DIGITAL ACCOUNT</p>
            <div class="meta">
                <span>Periode: <strong>{{ $namaBulan }}</strong></span>
                <span>Tanggal Cetak: <strong>{{ now()->locale('id')->translatedFormat('d F Y, H:i') }}</strong></span>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="summary">
            <div class="summary-item highlight">
                <div class="label">Pendapatan Bulan Ini</div>
                <div class="value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item success">
                <div class="label">Total Pendapatan (All Time)</div>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item warning">
                <div class="label">Pajak 11% + Total</div>
                <div class="value">Rp {{ number_format($totalDenganPajak, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- PENJUALAN PER PRODUK --}}
        <div class="section-title">PENJUALAN TERBAIK (TOP 10 PRODUK)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Nama Produk</th>
                    <th style="width: 15%; text-align: center;">Terjual</th>
                    <th style="width: 25%; text-align: right;">Pendapatan</th>
                    <th style="width: 10%; text-align: right;">%</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualanPerProduk as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td class="text-center">{{ $item->total_terjual }} akun</td>
                    <td class="text-right"><strong>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</strong></td>
                    <td class="text-right">{{ number_format(($item->total_pendapatan / $totalPendapatan) * 100, 1, ',', '.') }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGE BREAK --}}
        <div class="page-break"></div>

        {{-- DETAIL TRANSAKSI --}}
        <div class="section-title">DETAIL TRANSAKSI TERBARU ({{ count($transaksi) }} TRANSAKSI)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 35%;">Produk</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 22%; text-align: right;">Total</th>
                    <th style="width: 15%; text-align: center;">Tanggal</th>
                    <th style="width: 10%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $trx)
                <tr>
                    <td>#{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $trx->nama_produk }}</td>
                    <td class="text-center">{{ $trx->quantity }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</strong></td>
                    <td class="text-center">{{ $trx->created_at->locale('id')->translatedFormat('d M Y') }}</td>
                    <td class="text-center">
                        <span class="badge badge-success">Berhasil</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- FOOTER --}}
        <div class="footer">
            <div class="footer-item">© 2025 Nextzly - All Rights Reserved</div>
            <div class="footer-item">Laporan Otomatis Generated</div>
        </div>
    </div>
</body>
</html>
