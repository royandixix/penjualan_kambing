<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $riwayat = $user->pesanan()->with('kambings')->latest()->get();

        return view('user.riwayat.riwayat', compact('riwayat'));
    }
}
