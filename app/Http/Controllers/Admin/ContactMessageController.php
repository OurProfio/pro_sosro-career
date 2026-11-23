<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactMessageRequest;
use App\Mail\ContactMessageReplyMail;
use App\Models\ContactMessage;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar pesan masuk sesuai cakupan peran admin.
     */
    public function index(): View
    {
        $admin = auth()->user()->admin;
        abort_if($admin === null, 403);

        $isSuperAdmin = $admin->role === 'superadmin';

        $messagesQuery = ContactMessage::with(['user.applicant', 'user.admin', 'assignedOffice'])
            ->latest();

        if (! $isSuperAdmin) {
            if ($admin->office_id === null) {
                $messagesQuery->whereRaw('1 = 0');
            } else {
                $messagesQuery->where('assigned_office_id', $admin->office_id);
            }
        }

        $messages = $messagesQuery->get();
        $groupedOffices = $isSuperAdmin ? Office::groupedWithActiveBranchAdmins() : collect();

        return view('auth.admin.contact-message.index', compact('messages', 'isSuperAdmin', 'groupedOffices'));
    }

    /**
     * Mengirim balasan email penyelesaian ke pelapor atau melempar pesan ke admin cabang tujuan.
     */
    public function updateStatus(UpdateContactMessageRequest $request, ContactMessage $contactMessage): RedirectResponse
    {
        $admin = auth()->user()->admin;
        abort_if($admin === null, 403);

        $isSuperAdmin = $admin->role === 'superadmin';

        if (! $isSuperAdmin) {
            if ($admin->office_id === null || $contactMessage->assigned_office_id !== $admin->office_id) {
                abort(403, 'Akses tidak diizinkan untuk pesan kantor cabang lain.');
            }

            $replyMessage = trim((string) $request->validated('reply_message'));

            Mail::to($contactMessage->email)->send(new ContactMessageReplyMail($contactMessage, $replyMessage));

            $contactMessage->update([
                'reply_message' => $replyMessage,
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);

            return redirect()
                ->route('contact-message.index')
                ->with('success', 'Balasan berhasil dikirim ke email pelapor dan pesan ditandai sudah ditangani.');
        }

        $assignedOfficeId = $request->validated('assigned_office_id');

        if ($assignedOfficeId !== null) {
            $office = Office::findOrFail($assignedOfficeId);

            $contactMessage->update([
                'assigned_office_id' => $office->id,
                'assigned_at' => now(),
                'status' => 'unread',
                'resolved_at' => null,
            ]);

            return redirect()
                ->route('contact-message.index')
                ->with('success', 'Pesan berhasil dilempar ke Admin Cabang '.$office->name.'.');
        }

        $replyMessage = trim((string) $request->validated('reply_message'));

        Mail::to($contactMessage->email)->send(new ContactMessageReplyMail($contactMessage, $replyMessage));

        $contactMessage->update([
            'assigned_office_id' => null,
            'assigned_at' => null,
            'reply_message' => $replyMessage,
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return redirect()
            ->route('contact-message.index')
            ->with('success', 'Balasan berhasil dikirim ke email pelapor dan pesan ditandai sudah ditangani.');
    }

    /**
     * Menghapus data pesan masuk dari sistem (khusus Superadmin).
     */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('contact-message.index')
            ->with('success', 'Pesan masuk berhasil dihapus.');
    }
}
