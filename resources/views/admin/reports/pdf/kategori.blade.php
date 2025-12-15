<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kategori - Nextzly</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 3px;
            font-weight: 700;
        }
        .header .meta {
            font-size: 9px;
            color: #6b7280;
        }
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background: #374151;
            padding: 6px 8px;
            margin: 10px 0;
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
            padding: 7px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }
        tbody td {
            padding: 6px 7px;
            border: 1px solid #e5e7eb;
            font-size: 10px;
        }
        tbody tr:nth-child(even) { background: #f9fafb; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LAPORAN PENJUALAN PER KATEGORI</h1>
            <div class="meta">
                Periode: <strong>{{ $namaBulan }}</strong> | Cetak: {{ now()->locale('id')->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="section-title">ANALISIS PENJUALAN BERDASARKAN KATEGORI</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 35%;">Kategori</th>
                    <th style="width: 15%; text-align: center;">Jumlah Transaksi</th>
                    <th style="width: 15%; text-align: center;">Total Terjual</th>
                    <th style="width: 20%; text-align: right;">Pendapatan</th>
                    <th style="width: 7%; text-align: right;">%</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriData as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item->nama_kategori }}</strong></td>
                    <td class="text-center">{{ $item->jumlah_transaksi }}</td>
                    <td class="text-center">{{ $item->total_terjual }} akun</td>
                    <td class="text-right"><strong>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</strong></td>
                    <td class="text-right">{{ number_format(($item->total_pendapatan / $totalPendapatan) * 100, 1, ',', '.') }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
                <tr style="background: #f3f4f6; font-weight: 700;">
                    <td colspan="4" class="text-right">TOTAL:</td>
                    <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    <td class="text-right">100%</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">© 2025 Nextzly | Laporan Otomatis</div>
    </div>
</body>
</html>
