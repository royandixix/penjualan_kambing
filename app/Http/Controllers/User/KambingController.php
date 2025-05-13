<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KambingController extends Controller
{
    public function index()
    {
        // Kamu bisa ambil data kambing dari model nanti
        return view('user.kambing.kambing');
    }
}
