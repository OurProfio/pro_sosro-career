<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;
use App\Mail\DocumentCollectionMail;
use App\Mail\InterviewOfflineMail;
use App\Mail\InterviewOnlineMail;
use App\Mail\MedicalCheckUpMail;
use App\Mail\OfferingLetterMail;
use App\Mail\PanelBodMail;
use App\Mail\psikotesMail;
use App\Mail\RejectedMail;
use App\Mail\StudyCaseMail;
use App\Mail\tesKepribadianMail;
use App\Mail\VerifyEmailMail;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MailController extends Controller
{
    /**
     * Label tiap template email yang bisa dikirim sebagai tes.
     *
     * @return array<string, string>
     */
    protected function templateOptions(): array
    {
        return [
            'interview-online' => 'Interview Online',
            'interview-offline' => 'Interview Offline',
            'psikotes' => 'Psikotes',
            'tes-kepribadian' => 'Tes Kepribadian',
            'medical-check-up' => 'Medical Check Up',
            'offering-letter' => 'Offering Letter',
            'accepted-ho' => 'Diterima (HO)',
            'accepted-kpw' => 'Diterima (KPW)',
            'rejected' => 'Ditolak',
            'study-case' => 'Studi Kasus (MT)',
            'panel-bod' => 'Panel BOD (MT)',
            'document-collection' => 'Pengumpulan Berkas',
            'verify-email' => 'Verifikasi Email',
        ];
    }

    /**
     * Nilai bawaan untuk data yang dimasukkan ke email; dipakai bila input dikosongkan.
     *
     * @return array<string, string>
     */
    protected function dataDefaults(): array
    {
        return [
            'interview_date' => '2026-11-01',
            'interview_time' => '09:00',
            'interview_link' => 'https://meet.google.com/xxx',
            'interview_address' => 'Jl. Contoh No. 1',
            'psikotes_date' => '2026-11-02',
            'psikotes_time' => '10:00',
            'psikotes_link' => 'https://tes.test',
            'psikotes_code' => 'ABC123',
            'mcu_date' => '2026-11-03',
            'mcu_time' => '08:00',
            'mcu_location' => 'Klinik X',
            'mcu_address' => 'Jl. Sehat 2',
            'start_date' => '2026-12-01',
            'work_address' => 'Jakarta',
            'study_case_topic' => 'Strategi distribusi produk',
            'study_case_deadline' => '2026-11-05 17:00',
            'study_case_link' => 'https://drive.google.com/drive/folders/xxx',
            'panel_bod_date' => '2026-11-10',
            'panel_bod_time' => '10:00',
            'document_deadline' => '2026-11-15 17:00',
        ];
    }

    /**
     * Susun mailable contoh untuk satu template.
     *
     * @param  array<string, string>  $data
     */
    protected function makeMailable(string $template, Application $application, array $data): Mailable
    {
        return match ($template) {
            'interview-online' => new InterviewOnlineMail($application, $data['interview_date'], $data['interview_time'], $data['interview_link']),
            'interview-offline' => new InterviewOfflineMail($application, $data['interview_date'], $data['interview_time'], $data['interview_address']),
            'psikotes' => new psikotesMail(application: $application, link: $data['psikotes_link'], code: $data['psikotes_code'], date: $data['psikotes_date'], time: $data['psikotes_time']),
            'tes-kepribadian' => new tesKepribadianMail,
            'medical-check-up' => new MedicalCheckUpMail(application: $application, date: $data['mcu_date'], time: $data['mcu_time'], location: $data['mcu_location'], address: $data['mcu_address']),
            'offering-letter' => new OfferingLetterMail($application),
            'accepted-ho' => new AcceptedHOMail($application, $data['start_date'], $data['work_address']),
            'accepted-kpw' => new AcceptedKpwMail($application, $data['start_date'], $data['work_address']),
            'rejected' => new RejectedMail($application),
            'study-case' => new StudyCaseMail($application, $data['study_case_topic'], $data['study_case_deadline'], $data['study_case_link']),
            'panel-bod' => new PanelBodMail($application, $data['panel_bod_date'], $data['panel_bod_time']),
            'document-collection' => new DocumentCollectionMail($application, $data['document_deadline']),
            'verify-email' => new VerifyEmailMail(
                name: $application->applicant?->name ?? 'Kandidat',
                url: URL::temporarySignedRoute('verification.verify', now()->addMinutes((int) config('auth.verification.expire')), [
                    'id' => $application->applicant->user_id,
                    'hash' => sha1((string) $application->applicant->user?->email),
                ]),
                expire: (int) config('auth.verification.expire'),
            ),
        };
    }

    public function index(): View
    {
        return view('mail.index', [
            'templates' => $this->templateOptions(),
            'defaults' => $this->dataDefaults(),
        ]);
    }

    /**
     * Kirim template email contoh yang dipilih ke alamat tes (bukan ke pelamar).
     */
    public function sendEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'templates' => ['required', 'array', 'min:1'],
            'templates.*' => ['string', Rule::in(array_keys($this->templateOptions()))],
            'interview_date' => ['nullable', 'date'],
            'interview_time' => ['nullable', 'date_format:H:i'],
            'interview_link' => ['nullable', 'string', 'max:255'],
            'interview_address' => ['nullable', 'string', 'max:255'],
            'psikotes_date' => ['nullable', 'date'],
            'psikotes_time' => ['nullable', 'date_format:H:i'],
            'psikotes_link' => ['nullable', 'string', 'max:255'],
            'psikotes_code' => ['nullable', 'string', 'max:50'],
            'mcu_date' => ['nullable', 'date'],
            'mcu_time' => ['nullable', 'date_format:H:i'],
            'mcu_location' => ['nullable', 'string', 'max:255'],
            'mcu_address' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'work_address' => ['nullable', 'string', 'max:255'],
            'study_case_topic' => ['nullable', 'string', 'max:255'],
            'study_case_deadline' => ['nullable', 'date'],
            'study_case_link' => ['nullable', 'string', 'max:255'],
            'panel_bod_date' => ['nullable', 'date'],
            'panel_bod_time' => ['nullable', 'date_format:H:i'],
            'document_deadline' => ['nullable', 'date'],
        ]);

        $application = Application::with(['applicant', 'job.office', 'stage'])->latest()->first();

        if (! $application) {
            return back()->with('error', 'Belum ada data lamaran untuk dijadikan contoh email.');
        }

        $data = array_merge(
            $this->dataDefaults(),
            array_filter(
                Arr::only($validated, array_keys($this->dataDefaults())),
                fn (?string $value): bool => $value !== null,
            ),
        );

        foreach ($validated['templates'] as $template) {
            Mail::to($validated['email'])->send($this->makeMailable($template, $application, $data));
        }

        return back()->with('success', count($validated['templates']).' email contoh dikirim ke '.$validated['email']);
    }
}
