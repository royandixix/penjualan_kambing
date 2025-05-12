<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kambing;

class KambingController extends Controller
{
    public function index()
    {
        $kambings = Kambing::all();
        return view('admin.dashboard', compact('kambings'));
    }
}
