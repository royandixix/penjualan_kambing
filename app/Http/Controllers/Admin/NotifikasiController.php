<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifs = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.notifikasi.index', compact('notifs'));
    }

    public function markAsRead($id)
    {
        $notif = Auth::user()->notifications()->where('id', $id)->first();
        if ($notif) $notif->markAsRead();

        return back()->with('success', 'Notifikasi ditandai dibaca.');
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->each->markAsRead();

        return back()->with('success', 'Semua notifikasi dibaca.');
    }

    public function delete($id)
    {
        Auth::user()->notifications()->where('id', $id)->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }

    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'Semua notifikasi dihapus.');
    }
}
