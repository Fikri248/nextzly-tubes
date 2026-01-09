<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

class KategoriExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $periodeLabel;

    public function __construct(?string $startDate = null, ?string $endDate = null, ?string $periodeLabel = null)
    {
        if ($startDate || $endDate) {
            $this->startDate = Carbon::parse($startDate ?? Carbon::now()->startOfMonth()->toDateString())->startOfDay();
            $this->endDate = Carbon::parse($endDate ?? Carbon::now()->toDateString())->endOfDay();
            $this->periodeLabel = $periodeLabel ?: $this->startDate->locale('id')->translatedFormat('d M Y') . ' - ' . $this->endDate->locale('id')->translatedFormat('d M Y');
        } else {
            $baseDate = Carbon::now();
            $this->startDate = $baseDate->copy()->startOfMonth();
            $this->endDate = $baseDate->copy()->endOfMonth();
            $this->periodeLabel = $periodeLabel ?: $baseDate->locale('id')->translatedFormat('F Y');
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Transaction::select(
                'categories.nama_kategori',
                DB::raw('SUM(transactions.quantity) as total_terjual'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT transactions.id) as jumlah_transaksi')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$this->startDate, $this->endDate])
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderByDesc('total_pendapatan')
            ->get()
            ->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'nama_kategori' => $item->nama_kategori,
                    'jumlah_transaksi' => $item->jumlah_transaksi,
                    'total_terjual' => $item->total_terjual . ' akun',
                    'total_pendapatan' => 'Rp ' . number_format($item->total_pendapatan, 0, ',', '.'),
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
            ['LAPORAN PENJUALAN PER KATEGORI - NEXTZLY'],
            [],
            ['Periode:', $this->periodeLabel],
            ['Tanggal Export:', now()->locale('id')->translatedFormat('d F Y H:i:s')],
            [],
            ['KATEGORI TERLARIS BULAN INI'],
            ['No', 'Kategori', 'Jumlah Transaksi', 'Total Terjual', 'Total Pendapatan']
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
            // TABLE INFO
            6 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1F2937']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCD34D']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // TABLE HEADER
            7 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Kategori';
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 50,
            'C' => 20,
            'D' => 18,
            'E' => 22,
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
                $sheet->mergeCells('A1:E1');
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Merge Periode
                $sheet->mergeCells('B3:E3');
                $sheet->mergeCells('B4:E4');

                // Merge Table Info
                $sheet->mergeCells('A6:E6');
                $sheet->getRowDimension(6)->setRowHeight(22);

                // Auto Filter & Freeze
                $sheet->setAutoFilter('A7:E7');
                $sheet->getRowDimension(7)->setRowHeight(25);
                $sheet->freezePane('A8');

                // Border untuk Table Header
                $sheet->getStyle('A6:E7')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '7C3AED'],
                        ],
                    ],
                ]);

                // Data rows styling
                $highestRow = $sheet->getHighestRow();
                if ($highestRow > 7) {
                    for ($row = 8; $row <= $highestRow; $row++) {
                        // Alignment
                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                        // Alternating row colors
                        if ($row % 2 == 0) {
                            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'F9FAFB'],
                                ],
                            ]);
                        }

                        // Border
                        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
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
