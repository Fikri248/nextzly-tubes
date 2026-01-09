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

class PendapatanExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $periodeLabel;
    protected $totalPendapatan;
    protected $pajak;
    protected $totalDenganPajak;

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

        $this->totalPendapatan = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total_harga');
        $this->pajak = $this->totalPendapatan * 0.11;
        $this->totalDenganPajak = $this->totalPendapatan + $this->pajak;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Transaction::select(
                'products.nama_produk',
                DB::raw('SUM(transactions.quantity) as total_terjual'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$this->startDate, $this->endDate])
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_pendapatan')
            ->limit(10)
            ->get()
            ->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'nama_produk' => $item->nama_produk,
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
            ['LAPORAN PENDAPATAN NEXTZLY'],
            [],
            ['Periode:', $this->periodeLabel],
            ['Tanggal Export:', now()->locale('id')->translatedFormat('d F Y H:i:s')],
            [],
            ['RINGKASAN PENDAPATAN'],
            ['Total Pendapatan', 'Rp ' . number_format($this->totalPendapatan, 0, ',', '.')],
            ['Pajak (11%)', 'Rp ' . number_format($this->pajak, 0, ',', '.')],
            ['Total + Pajak', 'Rp ' . number_format($this->totalDenganPajak, 0, ',', '.')],
            [],
            ['TOP 10 PRODUK TERLARIS'],
            ['No', 'Nama Produk', 'Total Terjual', 'Total Pendapatan']
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
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F2937'],
                ],
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
            // SUMMARY HEADER
            6 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '1F2937']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
            // SUMMARY ROWS
            7 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '059669']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ECFDF5']],
            ],
            8 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'F59E0B']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFBEB']],
            ],
            9 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DC2626']],
            ],
            // TABLE HEADER
            11 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1F2937']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCD34D']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            12 => [
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
        return 'Pendapatan';
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 50,
            'C' => 18,
            'D' => 22,
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

                // Merge & Center Title
                $sheet->mergeCells('A1:D1');
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Merge Periode
                $sheet->mergeCells('B3:D3');
                $sheet->mergeCells('B4:D4');

                // Merge Summary Header
                $sheet->mergeCells('A6:D6');
                $sheet->getRowDimension(6)->setRowHeight(22);

                // Merge Summary Rows
                $sheet->mergeCells('B7:D7');
                $sheet->mergeCells('B8:D8');
                $sheet->mergeCells('B9:D9');
                $sheet->getRowDimension(7)->setRowHeight(20);
                $sheet->getRowDimension(8)->setRowHeight(20);
                $sheet->getRowDimension(9)->setRowHeight(20);

                // Merge Table Info
                $sheet->mergeCells('A11:D11');
                $sheet->getRowDimension(11)->setRowHeight(20);

                // Auto Filter
                $sheet->setAutoFilter('A12:D12');
                $sheet->getRowDimension(12)->setRowHeight(25);

                // Border untuk Summary
                $sheet->getStyle('A6:D9')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '9CA3AF'],
                        ],
                    ],
                ]);

                // Border untuk Table Header
                $sheet->getStyle('A11:D12')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '374151'],
                        ],
                    ],
                ]);

                // Data rows styling
                $highestRow = $sheet->getHighestRow();
                if ($highestRow > 12) {
                    for ($row = 13; $row <= $highestRow; $row++) {
                        // Alignment
                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                        // Alternating row colors
                        if ($row % 2 == 0) {
                            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'F9FAFB'],
                                ],
                            ]);
                        }

                        // Border
                        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['rgb' => 'E5E7EB'],
                                ],
                            ],
                        ]);
                    }
                }

                // Freeze Header
                $sheet->freezePane('A13');
            },
        ];
    }
}
