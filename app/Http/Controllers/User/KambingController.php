<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing; // pastikan model ini ada dan benar

class KambingController extends Controller
{
    public function index()
    {
        $kambings = Kambing::all(); // ambil semua data kambing
        return view('user.kambing.kambing', compact('kambings')); // arahkan ke view yang benar
    }
}
