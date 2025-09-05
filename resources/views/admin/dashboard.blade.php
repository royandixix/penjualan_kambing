@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Selamat Datang, {{ Auth::user()->name }}!</h4>
        <span class="text-muted">Dashboard Admin</span>
    </div>

    <!-- Statistik Cepat -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-primary h-100">
                <div class="card-body">
                    <h6 class="text-primary">Total Pesanan</h6>
                    <h3>{{ $totalPesanan->sum() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body">
                    <h6 class="text-success">Total Kambing</h6>
                    <h3>{{ $stokKambing->sum('total_stok') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body">
                    <h6 class="text-info">Jenis Kambing</h6>
                    <h3>{{ $stokKambing->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-4">

        <!-- Grafik Pesanan Per Bulan -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-hover">
                <div class="card-header bg-primary text-white">
                    <strong>Pesanan per Bulan ({{ date('Y') }})</strong>
                </div>
                <div class="card-body">
                    <canvas id="pesananChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Stok Kambing -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm card-hover">
                <div class="card-header bg-success text-white">
                    <strong>Stok Kambing per Jenis</strong>
                </div>
                <div class="card-body">
                    <canvas id="stokChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    /* Hover efek untuk card */
    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .border-left-primary { border-left: 4px solid #007bff !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .border-left-info { border-left: 4px solid #17a2b8 !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pesanan Per Bulan
    const ctxPesanan = document.getElementById('pesananChart').getContext('2d');
    const pesananChart = new Chart(ctxPesanan, {
        type: 'bar',
        data: {
            labels: @json($bulan),
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($totalPesanan),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Stok Kambing per Jenis
    const ctxStok = document.getElementById('stokChart').getContext('2d');
    const stokChart = new Chart(ctxStok, {
        type: 'doughnut',
        data: {
            labels: @json($stokKambing->pluck('jenis_kambing')),
            datasets: [{
                label: 'Stok Kambing',
                data: @json($stokKambing->pluck('total_stok')),
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush
