<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - Nextzly</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            color: #333;
        }

        .container {
            max-width: 297mm;
            margin: 0 auto;
            padding: 10mm;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 2px;
            font-weight: 700;
        }

        .header .meta {
            font-size: 9px;
            color: #6b7280;
        }

        .summary-box {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-cell {
            display: table-cell;
            width: 50%;
            padding: 8px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .summary-cell .label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .summary-cell .value {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: #374151;
            padding: 6px 8px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        thead {
            background: #374151;
            color: #fff;
        }

        thead th {
            padding: 6px;
            text-align: left;
            font-size: 9px;
            font-weight: 600;
            border: 1px solid #1f2937;
        }

        tbody td {
            padding: 5px 6px;
            border: 1px solid #e5e7eb;
            font-size: 9px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
        }

        @media print {
            body { margin: 0; padding: 0; }
            .container { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- HEADER --}}
        <div class="header">
            <h1>LAPORAN TRANSAKSI LENGKAP</h1>
            <div class="meta">
                Periode: <strong>{{ Carbon\Carbon::parse($startDate)->locale('id')->translatedFormat('d F Y') }}</strong>
                s/d
                <strong>{{ Carbon\Carbon::parse($endDate)->locale('id')->translatedFormat('d F Y') }}</strong>
                | Cetak: {{ now()->locale('id')->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="summary-box">
            <div class="summary-cell">
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="summary-cell">
                <div class="label">Pajak 11%</div>
                <div class="value">Rp {{ number_format($pajak, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="section-title">DAFTAR TRANSAKSI ({{ count($transaksi) }} TOTAL)</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 6%;">ID</th>
                    <th style="width: 28%;">Produk</th>
                    <th style="width: 8%; text-align: center;">Qty</th>
                    <th style="width: 18%; text-align: right;">Harga Total</th>
                    <th style="width: 22%; text-align: center;">Tanggal Transaksi</th>
                    <th style="width: 12%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $trx)
                <tr>
                    <td>#{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $trx->nama_produk }}</td>
                    <td class="text-center">{{ $trx->quantity }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</strong></td>
                    <td class="text-center">{{ $trx->created_at->locale('id')->translatedFormat('d/m/Y H:i') }}</td>
                    <td class="text-center">Berhasil</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            © 2025 Nextzly | Laporan Otomatis
        </div>
    </div>
</body>
</html>
