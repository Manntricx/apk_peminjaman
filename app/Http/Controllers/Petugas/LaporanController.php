<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $status = $request->get('status');

        $query = Peminjaman::with(['peminjam', 'petugas', 'details.alat'])
            ->whereBetween('tgl_pinjam', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        $totalPinjaman = $peminjamans->count();
        $totalAktif = $peminjamans->where('status', 'aktif')->count();
        $totalSelesai = $peminjamans->where('status', 'selesai')->count();
        $totalPending = $peminjamans->where('status', 'pending')->count();

        return view('petugas.laporan.index', compact(
            'peminjamans', 'startDate', 'endDate', 'status',
            'totalPinjaman', 'totalAktif', 'totalSelesai', 'totalPending'
        ));
    }
}
