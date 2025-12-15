<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransaksiExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $totalPendapatan;
    protected $pajak;
    protected $countTransaksi;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->totalPendapatan = Transaction::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->where('status', 'success')->sum('total_harga');

        $this->pajak = $this->totalPendapatan * 0.11;

        $this->countTransaksi = Transaction::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->where('status', 'success')->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Transaction::select(
                'transactions.id',
                'products.nama_produk',
                'transactions.quantity',
                'transactions.total_harga',
                'transactions.created_at',
                'transactions.status'
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->where('transactions.status', 'success')
            ->orderBy('transactions.created_at', 'desc')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'id_transaksi' => 'TRX-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
                    'nama_produk' => $item->nama_produk,
                    'quantity' => $item->quantity . ' akun',
                    'total_harga' => 'Rp ' . number_format($item->total_harga, 0, ',', '.'),
                    'tanggal' => Carbon::parse($item->created_at)->locale('id')->translatedFormat('d/m/Y H:i'),
                    'status' => ucfirst($item->status),
                ];
            });

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['LAPORAN TRANSAKSI LENGKAP NEXTZLY'],
            [],
            ['Periode:', Carbon::parse($this->startDate)->locale('id')->translatedFormat('d F Y') . ' - ' . Carbon::parse($this->endDate)->locale('id')->translatedFormat('d F Y')],
            ['Tanggal Export:', now()->locale('id')->translatedFormat('d F Y H:i:s')],
            [],
            ['TOTAL PENDAPATAN', 'Rp ' . number_format($this->totalPendapatan, 0, ',', '.'), '', 'PAJAK 11%', 'Rp ' . number_format($this->pajak, 0, ',', '.')],
            [],
            ['DAFTAR TRANSAKSI (' . $this->countTransaksi . ' TOTAL)'],
            ['No', 'ID Transaksi', 'Nama Produk', 'Qty', 'Harga Total', 'Tanggal Transaksi', 'Status']
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // TITLE
            1 => [
                'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            ],
            // PERIODE
            3 => [
                'font' => ['bold' => true, 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E5E7EB']],
            ],
            4 => [
                'font' => ['size' => 10],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']],
            ],
            // SUMMARY
            6 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0369A1']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            // TABLE INFO
            8 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F2937']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BFDBFE']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // TABLE HEADER
            9 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '374151']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Transaksi';
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 18,
            'C' => 50,
            'D' => 12,
            'E' => 18,
            'F' => 22,
            'G' => 14,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Merge Title
                $sheet->mergeCells('A1:G1');
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Merge Periode
                $sheet->mergeCells('B3:G3');
                $sheet->mergeCells('B4:G4');

                // Merge Summary
                $sheet->mergeCells('A6:B6');
                $sheet->mergeCells('D6:E6');
                $sheet->getRowDimension(6)->setRowHeight(22);

                // Merge Table Header Info
                $sheet->mergeCells('A8:G8');
                $sheet->getRowDimension(8)->setRowHeight(20);

                // Auto Filter & Freeze
                $sheet->setAutoFilter('A9:G9');
                $sheet->getRowDimension(9)->setRowHeight(25);
                $sheet->freezePane('A10');

                // Border untuk Summary
                $sheet->getStyle('A6:G6')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '0369A1'],
                        ],
                    ],
                ]);

                // Border untuk Table Header
                $sheet->getStyle('A8:G9')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '374151'],
                        ],
                    ],
                ]);

                // Data rows styling
                $highestRow = $sheet->getHighestRow();
                if ($highestRow > 9) {
                    for ($row = 10; $row <= $highestRow; $row++) {
                        // Center alignment
                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        // Alternating row colors
                        if ($row % 2 == 0) {
                            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'F9FAFB'],
                                ],
                            ]);
                        }

                        // Border
                        $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['rgb' => 'E5E7EB'],
                                ],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
