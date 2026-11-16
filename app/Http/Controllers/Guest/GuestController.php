<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        return view('guest.kontak');
    }

    public function storeKontak(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'region' => 'required|string|max:120',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'region.required' => 'Tujuan wilayah wajib dipilih.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        $contactEntry = [
            'id' => uniqid('msg_', true),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'region' => $validated['region'],
            'message' => $validated['message'],
            'created_at' => now()->toIso8601String(),
        ];

        $currentMessages = [];
        if (Storage::disk('local')->exists('contact_messages.json')) {
            $currentMessages = json_decode(Storage::disk('local')->get('contact_messages.json'), true) ?: [];
        }
        $currentMessages[] = $contactEntry;
        Storage::disk('local')->put(
            'contact_messages.json',
            json_encode($currentMessages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim rekrutmen kami akan segera menindaklanjutinya.');
    }
}
