<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktifitas;
use Illuminate\Http\Request;

class LogAktifitasController extends Controller
{
    public function index()
    {
        $logs = LogAktifitas::with('user')->orderBy('waktu', 'desc')->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }

    public function clear()
    {
        LogAktifitas::truncate();
        return redirect()->route('admin.logs.index')->with('success', 'Semua log aktifitas telah dihapus.');
    }
}
