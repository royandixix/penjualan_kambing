{{-- 
|--------------------------------------------------------------------------
| Dashboard Admin - Enhanced Version
| File ini digunakan untuk menampilkan:
| - Statistik pesanan dengan animasi
| - Grafik pesanan per bulan (Bar Chart)
| - Grafik stok kambing (Doughnut Chart)
| - Informasi real-time dan interaktif
|--------------------------------------------------------------------------
--}}

@extends('admin.layouts.app')

{{-- Judul halaman --}}
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    {{-- ================= HEADER DASHBOARD ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h2 class="mb-1 font-weight-bold text-gradient">
                👋 Selamat Datang, {{ Auth::user()->name }}!
            </h2>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary px-3 py-2">
                <i class="fas fa-user-shield me-1"></i> Dashboard Admin
            </span>
        </div>
    </div>

    {{-- ================= KETERANGAN DASHBOARD ================= --}}
    <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon me-3">
                <i class="fas fa-info-circle fa-2x"></i>
            </div>
            <div>
                <h6 class="alert-heading mb-1">Informasi Dashboard</h6>
                <p class="mb-0">
                    Dashboard ini menampilkan ringkasan data pesanan dan stok kambing 
                    untuk membantu Anda memantau sistem secara real-time.
                </p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    {{-- ================= STATISTIK CEPAT ================= --}}
    <div class="row g-3 mb-4">

        {{-- TOTAL PESANAN --}}
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-2 text-uppercase small fw-bold">
                                Total Pesanan
                            </p>
                            <h2 class="mb-0 fw-bold text-primary counter" data-target="{{ $totalPesanan->sum() }}">
                                0
                            </h2>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Tahun {{ date('Y') }}
                            </small>
                        </div>
                        <div class="stats-icon bg-primary-light">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" 
                             style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL STOK KAMBING --}}
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-2 text-uppercase small fw-bold">
                                Total Kambing
                            </p>
                            <h2 class="mb-0 fw-bold text-success counter" data-target="{{ $stokKambing->sum('total_stok') }}">
                                0
                            </h2>
                            <small class="text-muted">
                                <i class="fas fa-box me-1"></i>
                                Stok Tersedia
                            </small>
                        </div>
                        <div class="stats-icon bg-success-light">
                            <i class="fas fa-warehouse text-success"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JUMLAH JENIS KAMBING --}}
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-2 text-uppercase small fw-bold">
                                Jenis Kambing
                            </p>
                            <h2 class="mb-0 fw-bold text-info counter" data-target="{{ $stokKambing->count() }}">
                                0
                            </h2>
                            <small class="text-muted">
                                <i class="fas fa-list-alt me-1"></i>
                                Variasi Produk
                            </small>
                        </div>
                        <div class="stats-icon bg-info-light">
                            <i class="fas fa-layer-group text-info"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" 
                             style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PESANAN HARI INI (DUMMY) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-2 text-uppercase small fw-bold">
                                Pesanan Hari Ini
                            </p>
                            <h2 class="mb-0 fw-bold text-warning counter" data-target="12">
                                0
                            </h2>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                +23% dari kemarin
                            </small>
                        </div>
                        <div class="stats-icon bg-warning-light">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= GRAFIK ================= --}}
    <div class="row g-3">

        {{-- GRAFIK PESANAN PER BULAN --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm card-hover h-100">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="fas fa-chart-bar me-2"></i>
                                Pesanan per Bulan
                            </h5>
                            <small class="opacity-75">Tahun {{ date('Y') }}</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" 
                                    id="chartDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="chartDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Download</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="pesananChart"></canvas>
                    </div>
                    
                    <div class="alert alert-light mt-3 mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        <small>
                            Grafik menunjukkan tren pesanan bulanan. Bulan dengan pesanan tertinggi 
                            dapat membantu perencanaan stok.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK STOK KAMBING --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm card-hover h-100">
                <div class="card-header bg-gradient-success text-white border-0">
                    <h5 class="mb-1 fw-bold">
                        <i class="fas fa-chart-pie me-2"></i>
                        Distribusi Stok
                    </h5>
                    <small class="opacity-75">Per Jenis Kambing</small>
                </div>

                <div class="card-body text-center">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="stokChart"></canvas>
                    </div>
                    
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Total Stok</small>
                            <strong>{{ $stokKambing->sum('total_stok') }} Ekor</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Jenis Tersedia</small>
                            <strong>{{ $stokKambing->count() }} Jenis</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= QUICK ACTIONS ================= --}}
   

</div>
@endsection

{{-- ================= STYLE TAMBAHAN ================= --}}
@push('styles')
<style>
    /* ========== ANIMASI & EFEK ========== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-card {
        animation: fadeInUp 0.5s ease-out;
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }

    /* ========== GRADIENT BACKGROUNDS ========== */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ========== STATS ICON ========== */
    .stats-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
    }

    .bg-primary-light {
        background-color: rgba(102, 126, 234, 0.1);
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    /* ========== PROGRESS BAR ========== */
    .progress {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 1.5s ease;
    }

    /* ========== ALERT STYLING ========== */
    .alert {
        border: none;
        border-radius: 10px;
    }

    .alert-icon {
        opacity: 0.8;
    }

    /* ========== CARD HEADER ========== */
    .card-header {
        padding: 1.25rem;
        border-radius: 10px 10px 0 0 !important;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    /* ========== RESPONSIVE CHART ========== */
    .chart-container {
        position: relative;
    }

    /* ========== BADGE STYLING ========== */
    .badge {
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* ========== BUTTON HOVER ========== */
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-info:hover,
    .btn-outline-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
</style>
@endpush

{{-- ================= SCRIPT GRAFIK ================= --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ========== COUNTER ANIMATION ==========
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000; // 2 detik
            const increment = target / (duration / 16); // 60 FPS
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });
    });

    // ========== GRAFIK PESANAN ==========
    const pesananCtx = document.getElementById('pesananChart').getContext('2d');
    
    const gradientBlue = pesananCtx.createLinearGradient(0, 0, 0, 350);
    gradientBlue.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
    gradientBlue.addColorStop(1, 'rgba(118, 75, 162, 0.2)');

    new Chart(pesananCtx, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($totalPesanan),
                backgroundColor: gradientBlue,
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return ' Pesanan: ' + context.parsed.y + ' order';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // ========== GRAFIK STOK ==========
    const stokCtx = document.getElementById('stokChart').getContext('2d');

    new Chart(stokCtx, {
        type: 'doughnut',
        data: {
            labels: @json($stokKambing->pluck('jenis_kambing')),
            datasets: [{
                data: @json($stokKambing->pluck('total_stok')),
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(237, 100, 166, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 205, 86, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return ' ' + label + ': ' + value + ' ekor (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
@endpush