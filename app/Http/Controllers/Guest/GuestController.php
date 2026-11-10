<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Job;

class GuestController extends Controller
{
    public function index()
    {
        Job::where('status', 'aktif')
            ->whereDate('closing_date', '<', today())
            ->update(['status' => 'nonaktif']);

        // Hanya tampilkan lowongan yang aktif dan belum melewati batas tanggal tutup
        $jobs = Job::where('status', 'aktif')
            ->whereDate('closing_date', '>=', today())
            ->with('office')
            ->latest()
            ->get();

        return view('guest.index', compact('jobs'));
    }

    public function lowongan()
    {
        Job::where('status', 'aktif')
            ->whereDate('closing_date', '<', today())
            ->update(['status' => 'nonaktif']);

        // Hanya tampilkan lowongan yang aktif dan belum melewati batas tanggal tutup
        $jobs = Job::where('status', 'aktif')
            ->whereDate('closing_date', '>=', today())
            ->with('office')
            ->latest()
            ->get();

        return view('guest.lowongan', compact('jobs'));
    }
}
