@extends('user.layout.app')

@section('title', 'Beranda Pembeli')

@section('content')
    <style>
        #slider-container {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .slide-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transform: translateX(100%);
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
        }

        .slide-img.active {
            opacity: 1;
            transform: translateX(0);
            z-index: 2;
        }

        .slide-img.prev {
            transform: translateX(-100%);
        }

        .slide-img.next {
            transform: translateX(100%);
        }

        @media (max-width: 768px) {
            #slider-container {
                height: 250px;
                margin-top: 2rem;
            }
        }
    </style>

    <div class="container py-5">
        <div class="row align-items-center">
            <!-- Kolom Teks -->
            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="fw-bold mb-3">Hai Pembeli!</h1>
                <p class="text-muted fs-5">
                    Nikmati kemudahan memilih dan membeli kambing berkualitas langsung dari peternakan Kamberu di Belopa.
                </p>
                <a href="{{ route('user.kambing') }}" class="btn btn-success  mt-3 shadow">
                    Lihat Kambing Sekarang
                </a>
            </div>

            <!-- Kolom Slider Gambar -->
            <div class="col-lg-6">
                <div id="slider-container">
                    <img src="{{ asset('img/yhlsnOaD_kambing.jpg') }}" class="slide-img active" alt="Kambing 1">
                    <img src="{{ asset('img/yhlsnOaD_kambing.jpg') }}" class="slide-img next" alt="Kambing 2">
                    <img src="{{ asset('img/yhlsnOaD_kambing.jpg') }}" class="slide-img next" alt="Kambing 3">
                    <img src="{{ asset('img/yhlsnOaD_kambing.jpg') }}" class="slide-img next" alt="Kambing 4">
                </div>
            </div>
        </div>

        <!-- Baris Baru untuk Paragraf Penjelasan -->
        <div class="row mt-5">
            <div class="col-12">
                <p class="text-muted fs-5">
                    Sistem Informasi Penjualan Kambing Berbasis Website ini dirancang untuk memudahkan interaksi antara pembeli dan pihak peternakan Kamberu yang berlokasi di Kecamatan Belopa, Kabupaten Luwu. Dengan adanya platform digital ini, calon pembeli dapat melihat langsung daftar kambing yang tersedia secara real-time, melihat detail spesifikasi kambing seperti umur, bobot, dan harga, serta melakukan pemesanan secara online tanpa harus datang langsung ke lokasi. Hal ini tidak hanya menghemat waktu dan biaya, tetapi juga meningkatkan transparansi dan profesionalisme dalam proses transaksi. Website ini menjadi solusi modern dalam mendukung digitalisasi usaha peternakan tradisional, serta membuka akses pasar yang lebih luas bagi peternak lokal.
                </p>
            </div>
        </div>
    </div>

    {{-- Script animasi otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('.slide-img');
            let current = 0;

            setInterval(() => {
                const currentSlide = slides[current];
                currentSlide.classList.remove('active');
                currentSlide.classList.add('prev');

                current = (current + 1) % slides.length;
                const nextSlide = slides[current];
                nextSlide.classList.remove('next');
                nextSlide.classList.add('active');

                slides.forEach((slide, index) => {
                    if (index !== current) {
                        slide.classList.remove('active', 'prev');
                        slide.classList.add('next');
                    }
                });
            }, 3000);
        });
    </script>
@endsection
