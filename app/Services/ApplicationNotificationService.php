<?php

namespace App\Services;

use App\Mail\AcceptedHOMail;
use App\Mail\AcceptedKpwMail;
use App\Mail\InterviewOfflineMail;
use App\Mail\InterviewOnlineMail;
use App\Mail\MedicalCheckUpMail;
use App\Mail\OfferingLetterMail;
use App\Mail\psikotesMail;
use App\Mail\RejectedMail;
use App\Models\Application;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ApplicationNotificationService
{
    /**
     * Resolve and dispatch notification email for an application stage change.
     */
    public function sendStageNotification(Application $application, array $data): ?Mailable
    {
        $stage = $application->stage;
        if (! $stage) {
            return null;
        }

        $stageName = strtolower(trim($stage->name));
        $mailable = null;

        if (str_starts_with($stageName, 'interview') || $stageName === 'panel bod') {
            $isVirtual = ($data['interview_type'] ?? $data['panel_bod_type'] ?? 'virtual') === 'virtual';
            $date = $data['interview_date'] ?? $data['panel_bod_date'] ?? date('Y-m-d');
            $time = $data['interview_time'] ?? $data['panel_bod_time'] ?? '09:00';

            if ($isVirtual) {
                $link = $data['interview_link'] ?? $data['panel_bod_link'] ?? '';
                $mailable = new InterviewOnlineMail($application, $date, $time, $link);
            } else {
                $address = $data['interview_address'] ?? $data['panel_bod_address'] ?? '';
                $mailable = new InterviewOfflineMail($application, $date, $time, $address);
            }
        } elseif ($stageName === 'psikotes') {
            $mailable = new psikotesMail(
                application: $application,
                link: $data['psikotes_link'] ?? null,
                code: $data['psikotes_code'] ?? null,
                date: $data['psikotes_date'] ?? null,
                time: $data['psikotes_time'] ?? null,
            );
        } elseif ($stageName === 'mcu') {
            $mailable = new MedicalCheckUpMail(
                application: $application,
                date: $data['mcu_date'] ?? null,
                time: $data['mcu_time'] ?? null,
                location: $data['mcu_location'] ?? null,
                address: $data['mcu_address'] ?? null,
            );
        } elseif ($stageName === 'offering') {
            $mailable = new OfferingLetterMail($application);
        }

        if ($mailable) {
            $this->dispatchEmail($application, $mailable);
        }

        return $mailable;
    }

    /**
     * Resolve and dispatch notification email for final application status change (accepted/rejected).
     */
    public function sendStatusNotification(Application $application, array $data): ?Mailable
    {
        $status = $data['status'] ?? $application->status;
        $mailable = null;

        if ($status === 'rejected') {
            $mailable = new RejectedMail($application);
        } elseif ($status === 'accepted') {
            $startDate = $data['start_date'] ?? date('Y-m-d');
            $workAddress = $data['work_address'] ?? '-';

            if (strtoupper((string) ($application->job->office->type ?? '')) === 'HO') {
                $mailable = new AcceptedHOMail($application, $startDate, $workAddress);
            } else {
                $mailable = new AcceptedKpwMail($application, $startDate, $workAddress);
            }
        }

        if ($mailable) {
            $this->dispatchEmail($application, $mailable);
        }

        return $mailable;
    }

    /**
     * Dispatch email safely to the applicant.
     */
    protected function dispatchEmail(Application $application, Mailable $mailable): void
    {
        $recipientEmail = $application->applicant?->email ?? $application->applicant?->user?->email;

        if (! $recipientEmail) {
            Log::warning('Recipient email not found for application ID: '.$application->id);

            return;
        }

        try {
            Mail::to($recipientEmail)->send($mailable);
        } catch (Throwable $e) {
            Log::error('Failed to send application email: '.$e->getMessage(), [
                'application_id' => $application->id,
                'recipient' => $recipientEmail,
                'mailable' => get_class($mailable),
            ]);
        }
    }
}
