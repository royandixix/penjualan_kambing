<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        return view('user.notifikasi.index', compact('notifications'));
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}
