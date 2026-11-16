<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar seluruh pesan masuk dan laporan dari halaman kontak.
     */
    public function index(): View
    {
        $messages = ContactMessage::with(['user.applicant', 'user.admin'])
            ->latest()
            ->get();

        return view('auth.admin.contact-message.index', compact('messages'));
    }

    /**
     * Memperbarui status tindak lanjut dan catatan internal admin pada pesan masuk.
     */
    public function updateStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,resolved',
            'admin_notes' => 'nullable|string|max:2000',
        ], [
            'status.required' => 'Status pesan wajib dipilih.',
            'status.in' => 'Status pesan tidak valid.',
            'admin_notes.max' => 'Catatan tindak lanjut maksimal 2000 karakter.',
        ]);

        $contactMessage->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'resolved_at' => $validated['status'] === 'resolved'
                ? ($contactMessage->resolved_at ?? now())
                : null,
        ]);

        return redirect()
            ->route('contact-message.index')
            ->with('success', 'Status pesan dan catatan tindak lanjut berhasil diperbarui.');
    }

    /**
     * Menghapus data pesan masuk dari sistem.
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('contact-message.index')
            ->with('success', 'Pesan masuk berhasil dihapus.');
    }
}
