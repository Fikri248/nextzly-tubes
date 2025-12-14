@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')
@section('page-description', 'Ringkasan penjualan dan data akun digital Nextzly.')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    {{-- GRID 4 SUMMARY CARDS --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Card 1: Total Akun Tersedia --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 text-xl">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Akun Tersedia</p>
                <p class="text-xl font-bold text-slate-800">{{ number_format($totalAkunTersedia, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Card 2: Total Akun Terjual --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl">
                <i class="bi bi-cart-check"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Akun Terjual</p>
                <p class="text-xl font-bold text-slate-800">{{ number_format($totalAkunTerjual, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Card 3: Total Semua Aplikasi --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600 text-xl">
                <i class="bi bi-grid-3x3-gap"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Semua Aplikasi</p>
                <p class="text-xl font-bold text-slate-800">{{ number_format($totalAplikasi, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Card 4: Pendapatan Bulan Ini --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-xl">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Pendapatan {{ $namaBulan }}</p>
                <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</p>
            </div>
        </div>
    </section>

    {{-- DETAIL PENDAPATAN KESELURUHAN --}}
    <section class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
            <i class="bi bi-calculator text-slate-400"></i>
            Rincian Pendapatan Keseluruhan
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-xs text-slate-500 mb-1">Pendapatan Bersih</p>
                <p class="text-lg font-bold text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                <p class="text-xs text-slate-500 mb-1">Pajak 11%</p>
                <p class="text-lg font-bold text-red-500">Rp {{ number_format($pajak, 0, ',', '.') }}</p>
            </div>
            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                <p class="text-xs text-slate-500 mb-1">Total + Pajak</p>
                <p class="text-lg font-bold text-emerald-600">Rp {{ number_format($pendapatanDenganPajak, 0, ',', '.') }}</p>
            </div>
        </div>
    </section>

    {{-- CHARTS GRID - 2 COLUMNS --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- CHART 1: Penjualan per Aplikasi --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <i class="bi bi-bar-chart-fill text-sky-500"></i>
                    Penjualan {{ $namaBulan }}
                </h2>
                <div class="flex items-center gap-1">
                    <button type="button" id="btn-sales-bar"
                        class="px-2.5 py-1 text-[10px] font-medium rounded-lg bg-slate-900 text-white transition-all">
                        Bar
                    </button>
                    <button type="button" id="btn-sales-line"
                        class="px-2.5 py-1 text-[10px] font-medium rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Line
                    </button>
                </div>
            </div>

            @if(count($chartLabels) > 0)
            <div class="relative h-64">
                <canvas id="salesChart"></canvas>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-[10px] text-slate-500">
                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                <span>Jumlah Akun Terjual (Top 10)</span>
            </div>
            @else
            <div class="h-64 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                <div class="text-center">
                    <i class="bi bi-inbox text-3xl mb-2"></i>
                    <p class="text-xs font-medium">Belum Ada Data Bulan Ini</p>
                </div>
            </div>
            @endif
        </div>

        {{-- CHART 2: Pendapatan per Aplikasi --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <i class="bi bi-cash-coin text-emerald-500"></i>
                    Pendapatan {{ $namaBulan }}
                </h2>
                <div class="flex items-center gap-1">
                    <button type="button" id="btn-revenue-bar"
                        class="px-2.5 py-1 text-[10px] font-medium rounded-lg bg-slate-900 text-white transition-all">
                        Bar
                    </button>
                    <button type="button" id="btn-revenue-doughnut"
                        class="px-2.5 py-1 text-[10px] font-medium rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">
                        Donut
                    </button>
                </div>
            </div>

            @if(count($chartLabels) > 0)
            <div class="relative h-64">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-[10px] text-slate-500">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span>Total Pendapatan dalam Rupiah (Top 10)</span>
            </div>
            @else
            <div class="h-64 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                <div class="text-center">
                    <i class="bi bi-inbox text-3xl mb-2"></i>
                    <p class="text-xs font-medium">Belum Ada Data Bulan Ini</p>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    @if(count($chartLabels) > 0)
    const chartLabels = @json($chartLabels);
    const chartDataSales = @json($chartData);
    const chartDataRevenue = @json($chartRevenue);

    // Format angka ke Rupiah
function formatRupiah(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

    // =====================
    // CHART 1: PENJUALAN
    // =====================
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const gradientSales = ctxSales.createLinearGradient(0, 0, 0, 300);
    gradientSales.addColorStop(0, 'rgba(14, 165, 233, 0.8)');
    gradientSales.addColorStop(1, 'rgba(14, 165, 233, 0.2)');

    let salesChart = new Chart(ctxSales, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Akun Terjual',
                data: chartDataSales,
                backgroundColor: gradientSales,
                borderColor: 'rgba(14, 165, 233, 1)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: (ctx) => `Terjual: ${ctx.raw} akun`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, family: 'Montserrat' },
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, family: 'Montserrat' },
                        stepSize: 1
                    }
                }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });

    // Toggle Sales Chart Type
    document.getElementById('btn-sales-bar').addEventListener('click', function() {
        salesChart.config.type = 'bar';
        salesChart.data.datasets[0].backgroundColor = gradientSales;
        salesChart.data.datasets[0].fill = false;
        salesChart.data.datasets[0].tension = 0;
        salesChart.update();
        this.classList.add('bg-slate-900', 'text-white');
        this.classList.remove('bg-slate-100', 'text-slate-600');
        document.getElementById('btn-sales-line').classList.remove('bg-slate-900', 'text-white');
        document.getElementById('btn-sales-line').classList.add('bg-slate-100', 'text-slate-600');
    });

    document.getElementById('btn-sales-line').addEventListener('click', function() {
        salesChart.config.type = 'line';
        salesChart.data.datasets[0].backgroundColor = 'rgba(14, 165, 233, 0.1)';
        salesChart.data.datasets[0].borderColor = 'rgba(14, 165, 233, 1)';
        salesChart.data.datasets[0].fill = true;
        salesChart.data.datasets[0].tension = 0.4;
        salesChart.data.datasets[0].pointBackgroundColor = 'rgba(14, 165, 233, 1)';
        salesChart.data.datasets[0].pointRadius = 4;
        salesChart.update();
        this.classList.add('bg-slate-900', 'text-white');
        this.classList.remove('bg-slate-100', 'text-slate-600');
        document.getElementById('btn-sales-bar').classList.remove('bg-slate-900', 'text-white');
        document.getElementById('btn-sales-bar').classList.add('bg-slate-100', 'text-slate-600');
    });

    // =====================
    // CHART 2: PENDAPATAN
    // =====================
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const gradientRevenue = ctxRevenue.createLinearGradient(0, 0, 0, 300);
    gradientRevenue.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
    gradientRevenue.addColorStop(1, 'rgba(16, 185, 129, 0.2)');

    // Warna untuk doughnut chart
    const doughnutColors = [
        'rgba(14, 165, 233, 0.8)',   // sky
        'rgba(16, 185, 129, 0.8)',   // emerald
        'rgba(139, 92, 246, 0.8)',   // violet
        'rgba(245, 158, 11, 0.8)',   // amber
        'rgba(239, 68, 68, 0.8)',    // red
        'rgba(236, 72, 153, 0.8)',   // pink
        'rgba(34, 211, 238, 0.8)',   // cyan
        'rgba(163, 230, 53, 0.8)',   // lime
        'rgba(251, 146, 60, 0.8)',   // orange
        'rgba(167, 139, 250, 0.8)',  // purple
    ];

    let revenueChart = new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan',
                data: chartDataRevenue,
                backgroundColor: gradientRevenue,
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: (ctx) => `Pendapatan: ${formatRupiah(ctx.raw)}`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, family: 'Montserrat' },
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: {
                        color: '#64748b',
                        font: { size: 10, family: 'Montserrat' },
                        callback: (value) => 'Rp ' + (value / 1000) + 'K'
                    }
                }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });

    // Toggle Revenue Chart Type - Bar
    document.getElementById('btn-revenue-bar').addEventListener('click', function() {
        revenueChart.destroy();
        revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: chartDataRevenue,
                    backgroundColor: gradientRevenue,
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: (ctx) => `Pendapatan: ${formatRupiah(ctx.raw)}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 10, family: 'Montserrat' },
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.1)' },
                        ticks: {
                            color: '#64748b',
                            font: { size: 10, family: 'Montserrat' },
                            callback: (value) => 'Rp ' + (value / 1000) + 'K'
                        }
                    }
                },
                animation: { duration: 800, easing: 'easeOutQuart' }
            }
        });
        this.classList.add('bg-slate-900', 'text-white');
        this.classList.remove('bg-slate-100', 'text-slate-600');
        document.getElementById('btn-revenue-doughnut').classList.remove('bg-slate-900', 'text-white');
        document.getElementById('btn-revenue-doughnut').classList.add('bg-slate-100', 'text-slate-600');
    });

    // Toggle Revenue Chart Type - Doughnut
    document.getElementById('btn-revenue-doughnut').addEventListener('click', function() {
        revenueChart.destroy();
        revenueChart = new Chart(ctxRevenue, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartDataRevenue,
                    backgroundColor: doughnutColors,
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 8,
                            font: { size: 9, family: 'Montserrat' },
                            color: '#64748b'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: (ctx) => `${ctx.label}: ${formatRupiah(ctx.raw)}`
                        }
                    }
                },
                animation: { duration: 800, easing: 'easeOutQuart' }
            }
        });
        this.classList.add('bg-slate-900', 'text-white');
        this.classList.remove('bg-slate-100', 'text-slate-600');
        document.getElementById('btn-revenue-bar').classList.remove('bg-slate-900', 'text-white');
        document.getElementById('btn-revenue-bar').classList.add('bg-slate-100', 'text-slate-600');
    });
    @endif
</script>
@endpush
