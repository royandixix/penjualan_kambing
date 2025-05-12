<!-- resources/views/admin/dashboard.blade.php -->

@extends('admin.layouts.app')

@section('title', 'Dashboard') <!-- Title halaman -->

@section('content')
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item">
                            <a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </nav>
               
            </div>
            <div class="col-6">
                <div class="text-end upgrade-btn">
                    <!-- Button upgrade or other actions -->
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h4 class="mb-4">Daftar Kambing</h4>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kambings as $kambing)
                <tr>
                    <td>{{ $kambing->nama }}</td>
                    <td>{{ $kambing->umur }} bulan</td>
                    <td>{{ $kambing->berat }} kg</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($kambing->foto)
                            <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->nama }}" width="80">
                        @else
                            <em>Belum ada foto</em>
                        @endif
                    </td>
                    <td>{{ $kambing->deskripsi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
  
        {{-- <div class="row">
            <!-- column -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Comments</h4>
                    </div>
                    <div class="comment-widgets scrollable">
                        <!-- Comment Row -->
                        <div class="d-flex flex-row comment-row m-t-0">
                            <div class="p-2">
                                <img src="images/users/1.jpg" alt="user" width="50" class="rounded-circle" />
                            </div>
                            <div class="comment-text w-100">
                                <h6 class="font-medium">James Anderson</h6>
                                <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and
                                    type setting industry.
                                </span>
                                <div class="comment-footer">
                                    <span class="text-muted float-end">April 14, 2024</span>
                                    <span class="label label-rounded label-primary">Pending</span>
                                    <span class="action-icons">
                                        <a href="javascript:void(0)"><i class="mdi mdi-pencil-box-outline fs-4"></i></a>
                                        <a href="javascript:void(0)"><i class="mdi mdi-check fs-4"></i></a>
                                        <a href="javascript:void(0)"><i class="mdi mdi-heart-outline fs-4"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Comment Row -->
                        <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                                <img src="images/users/4.jpg" alt="user" width="50" class="rounded-circle" />
                            </div>
                            <div class="comment-text active w-100">
                                <h6 class="font-medium">Michael Jorden</h6>
                                <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and
                                    type setting industry.
                                </span>
                                <div class="comment-footer">
                                    <span class="text-muted float-end">April 14, 2024</span>
                                    <span class="label label-success label-rounded">Approved</span>
                                    <span class="action-icons active">
                                        <a href="javascript:void(0)"><i class="mdi mdi-pencil-box-outline fs-4"></i></a>
                                        <a href="javascript:void(0)"><i class="mdi mdi-window-close fs-4"></i></a>
                                        <a href="javascript:void(0)"><i
                                                class="mdi mdi-heart-outline fs-4 text-danger"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Comment Row -->
                        <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                                <img src="images/users/5.jpg" alt="user" width="50" class="rounded-circle" />
                            </div>
                            <div class="comment-text w-100">
                                <h6 class="font-medium">Johnathan Doeting</h6>
                                <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and
                                    type setting industry.
                                </span>
                                <div class="comment-footer">
                                    <span class="text-muted float-end">April 14, 2024</span>
                                    <span class="label label-rounded label-danger">Rejected</span>
                                    <span class="action-icons">
                                        <a href="javascript:void(0)"><i class="mdi mdi-pencil-box-outline fs-4"></i></a>
                                        <a href="javascript:void(0)"><i class="mdi mdi-check fs-4"></i></a>
                                        <a href="javascript:void(0)"><i class="mdi mdi-heart-outline fs-4"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Temp Guide</h4>
                        <div class="d-flex align-items-center flex-row m-t-30">
                            <div class="display-5 text-info">
                                <i class="mdi mdi-weather-lightning-rainy"></i>
                                <span>73<sup>°</sup></span>
                            </div>
                            <div class="m-l-10">
                                <h3 class="m-b-0">Saturday</h3>
                                <small>Ahmedabad, India</small>
                            </div>
                        </div>
                        <table class="table no-border mini-table m-t-20">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Wind</td>
                                    <td class="font-medium">ESE 17 mph</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Humidity</td>
                                    <td class="font-medium">83%</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Pressure</td>
                                    <td class="font-medium">28.56 in</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Cloud Cover</td>
                                    <td class="font-medium">78%</td>
                                </tr>
                            </tbody>
                        </table>
                        <ul class="row list-style-none text-center m-t-30">
                            <li class="col-3">
                                <h4 class="text-info">
                                    <i class="mdi mdi-weather-sunny fs-3"></i>
                                </h4>
                                <span class="d-block text-muted">09:30</span>
                                <h3 class="m-t-5">70<sup>°</sup></h3>
                            </li>
                            <li class="col-3">
                                <h4 class="text-info">
                                    <i class="mdi mdi-weather-partlycloudy fs-3"></i>
                                </h4>
                                <span class="d-block text-muted">11:30</span>
                                <h3 class="m-t-5">72<sup>°</sup></h3>
                            </li>
                            <li class="col-3">
                                <h4 class="text-info">
                                    <i class="mdi mdi-weather-pouring fs-3"></i>
                                </h4>
                                <span class="d-block text-muted">13:30</span>
                                <h3 class="m-t-5">75<sup>°</sup></h3>
                            </li>
                            <li class="col-3">
                                <h4 class="text-info">
                                    <i class="mdi mdi-weather-hail fs-3"></i>
                                </h4>
                                <span class="d-block text-muted">15:30</span>
                                <h3 class="m-t-5">76<sup>°</sup></h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection
