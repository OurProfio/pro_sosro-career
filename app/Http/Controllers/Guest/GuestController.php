<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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

    public function tentang(): View
    {
        return view('guest.tentang');
    }

    public function program(): View
    {
        return view('guest.program');
    }

    public function kontak(): View
    {
        $regions = ContactMessage::REGIONS;

        return view('guest.kontak', compact('regions'));
    }

    public function storeKontak(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'region' => ['required', 'string', 'max:120', Rule::in(ContactMessage::REGIONS)],
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'region.required' => 'Tujuan wilayah wajib dipilih.',
            'region.in' => 'Tujuan wilayah yang dipilih tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        ContactMessage::create([
            'user_id' => auth()->id(),
            'assigned_office_id' => null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'region' => $validated['region'],
            'message' => $validated['message'],
            'status' => 'unread',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'assigned_at' => null,
        ]);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim rekrutmen kami akan segera menindaklanjutinya.');
    }
}
