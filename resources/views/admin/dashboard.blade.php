{{-- 
|--------------------------------------------------------------------------
| Dashboard Admin
| File ini digunakan untuk menampilkan:
| - Statistik pesanan
| - Grafik pesanan per bulan
| - Grafik stok kambing
|--------------------------------------------------------------------------
--}}

@extends('admin.layouts.app')

{{-- Judul halaman --}}
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    {{-- ================= HEADER DASHBOARD ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Menampilkan nama admin yang sedang login --}}
        <h4 class="mb-0">
            Selamat Datang, {{ Auth::user()->name }}!
        </h4>

        <span class="text-muted">Dashboard Admin</span>
    </div>

    {{-- ================= KETERANGAN DASHBOARD ================= --}}
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Dashboard ini menampilkan ringkasan data pesanan dan stok kambing 
        untuk membantu admin memantau sistem.
    </div>

    {{-- ================= STATISTIK CEPAT ================= --}}
    <div class="row">

        {{-- TOTAL PESANAN --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-primary h-100">
                <div class="card-body">
                    <h6 class="text-primary">Total Pesanan</h6>

                    {{-- Menjumlahkan seluruh pesanan --}}
                    <h3>{{ $totalPesanan->sum() }}</h3>

                    <small class="text-muted">
                        Total pesanan tahun {{ date('Y') }}
                    </small>
                </div>
            </div>
        </div>

        {{-- TOTAL STOK KAMBING --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body">
                    <h6 class="text-success">Total Kambing</h6>

                    {{-- Menjumlahkan seluruh stok kambing --}}
                    <h3>{{ $stokKambing->sum('total_stok') }}</h3>

                    <small class="text-muted">
                        Stok kambing tersedia saat ini
                    </small>
                </div>
            </div>
        </div>

        {{-- JUMLAH JENIS KAMBING --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body">
                    <h6 class="text-info">Jenis Kambing</h6>

                    {{-- Menghitung jumlah jenis kambing --}}
                    <h3>{{ $stokKambing->count() }}</h3>

                    <small class="text-muted">
                        Jumlah variasi jenis kambing
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= GRAFIK ================= --}}
    <div class="row mt-4">

        {{-- GRAFIK PESANAN PER BULAN --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-hover">
                <div class="card-header bg-primary text-white">
                    <strong>Pesanan per Bulan ({{ date('Y') }})</strong>
                </div>

                <div class="card-body">
                    {{-- Canvas tempat Chart.js menggambar grafik --}}
                    <canvas id="pesananChart"></canvas>

                    <p class="text-muted mt-3 mb-0">
                        Grafik ini menunjukkan jumlah pesanan yang masuk 
                        setiap bulan dalam satu tahun.
                    </p>
                </div>
            </div>
        </div>

        {{-- GRAFIK STOK KAMBING --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-hover">
                <div class="card-header bg-success text-white">
                    <strong>Stok Kambing per Jenis</strong>
                </div>

                <div class="card-body">
                    {{-- Canvas untuk grafik donut --}}
                    <canvas id="stokChart"></canvas>

                    <p class="text-muted mt-3 mb-0">
                        Diagram ini menampilkan perbandingan stok kambing 
                        berdasarkan jenisnya.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

{{-- ================= STYLE TAMBAHAN ================= --}}
@push('styles')
<style>
    /* Efek hover agar card sedikit terangkat */
    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* Border warna di sisi kiri card */
    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .border-left-info    { border-left: 4px solid #17a2b8 !important; }
</style>
@endpush

{{-- ================= SCRIPT GRAFIK ================= --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /* ================= GRAFIK PESANAN ================= */
    new Chart(document.getElementById('pesananChart'), {
        type: 'bar', // Grafik batang
        data: {
            labels: @json($bulan), // Nama bulan
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($totalPesanan), // Total pesanan per bulan
                backgroundColor: 'rgba(54,162,235,0.7)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    /* ================= GRAFIK STOK ================= */
    new Chart(document.getElementById('stokChart'), {
        type: 'doughnut', // Grafik donut
        data: {
            labels: @json($stokKambing->pluck('jenis_kambing')),
            datasets: [{
                data: @json($stokKambing->pluck('total_stok')),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56',
                    '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
