<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();

        return view('user.notifikasi.index', compact('notifications'));
    }
}
