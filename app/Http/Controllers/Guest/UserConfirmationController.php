<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserConfirmationRequest;
use App\Models\UserConfirmation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserConfirmationController extends Controller
{
    public function show(string $token): View
    {
        $confirmation = $this->resolveConfirmation($token);

        return view('guest.user-confirmation', [
            'confirmation' => $confirmation,
            'application' => $confirmation->application,
            'applicant' => $confirmation->application->applicant,
            'isLocked' => $confirmation->isLocked(),
        ]);
    }

    /**
     * Tampilkan detail lengkap kandidat untuk user, seperti halaman detail admin.
     */
    public function detail(string $token): View
    {
        $application = $this->resolveConfirmation($token)->application;

        return view('guest.user-confirmation-detail', [
            ...$application->applicant->profileViewData($application),
            'token' => $token,
        ]);
    }

    /**
     * Tampilkan formulir biodata kandidat untuk dicetak oleh user.
     */
    public function print(string $token): View
    {
        $application = $this->resolveConfirmation($token)->application;

        return view('auth.applicant.biodata.print', [
            ...$application->applicant->biodataPrintData($application->job),
            'showJobTitle' => true,
        ]);
    }

    public function update(UpdateUserConfirmationRequest $request, string $token): RedirectResponse
    {
        $confirmation = $this->resolveConfirmation($token);

        if ($confirmation->isLocked()) {
            return back()->with('error', 'Proses seleksi kandidat ini sudah dilanjutkan oleh tim rekrutmen.');
        }

        $confirmation->update([
            'decision' => $request->validated('decision'),
            'note' => $request->validated('note'),
            'decided_at' => now(),
        ]);

        return redirect()
            ->route('user-confirmation.show', $token)
            ->with('success', 'Keputusan Anda telah disimpan.');
    }

    /**
     * Resolve an active confirmation by its plain token or abort with 404.
     */
    private function resolveConfirmation(string $token): UserConfirmation
    {
        $confirmation = UserConfirmation::findActiveByToken($token) ?? abort(404);

        return $confirmation->load([
            'application.stage',
            'application.applicant.educations' => fn ($query) => $query->orderByDesc('graduation_year'),
            'application.applicant.workExperiences',
            'application.job.office',
        ]);
    }
}
