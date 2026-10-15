<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    /**
     * Show temporary feedback form.
     */
    public function feedback(): View
    {
        return view('feedback');
    }

    /**
     * Store feedback submission.
     */
    public function storeFeedback(Request $request): Response
    {
        $validated = $request->validate([
            'notes' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'notes.required' => 'Catatan kritik atau saran wajib diisi.',
            'screenshot.image' => 'File harus berupa gambar.',
            'screenshot.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('feedback', 'public');
        }

        // Simpan log feedback sementara ke storage/app/feedback.json
        $feedbackEntry = [
            'id' => uniqid('fb_', true),
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'notes' => $validated['notes'],
            'screenshot' => $screenshotPath,
            'created_at' => now()->toIso8601String(),
        ];

        $currentData = [];
        if (Storage::disk('local')->exists('feedback.json')) {
            $currentData = json_decode(Storage::disk('local')->get('feedback.json'), true) ?: [];
        }
        $currentData[] = $feedbackEntry;
        Storage::disk('local')->put('feedback.json', json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Terima kasih! Kritik dan saran berhasil dikirim.');
    }
}
