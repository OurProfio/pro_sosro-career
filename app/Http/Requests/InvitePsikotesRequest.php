<?php

namespace App\Http\Requests;

use App\Models\Application;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvitePsikotesRequest extends FormRequest
{
    protected $errorBag = 'psikotesInvite';

    public function authorize(): bool
    {
        abort_unless(
            $this->route('job')->isManageableBy($this->user()?->admin),
            403,
            'Akses tidak diizinkan untuk kantor cabang lain.'
        );

        return true;
    }

    /**
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_ids' => ['required', 'array', 'min:1'],
            'application_ids.*' => [
                'integer',
                'distinct',
                Rule::exists('applications', 'id')
                    ->where('job_id', $this->route('job')->id)
                    ->whereIn('status', ['pending', 'progress']),
            ],
            'psikotes_date' => ['nullable', 'date'],
            'psikotes_time' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $psikotesStage = $this->route('job')->psikotesStage();

                if (! $psikotesStage) {
                    $validator->errors()->add('application_ids', 'Lowongan ini tidak memiliki tahap psikotes.');

                    return;
                }

                $hasIneligible = Application::with(['stage', 'psikotesLink'])
                    ->whereIn('id', $this->input('application_ids'))
                    ->get()
                    ->contains(fn (Application $application) => ! $application->canBeInvitedToPsikotes($psikotesStage));

                if ($hasIneligible) {
                    $validator->errors()->add('application_ids', 'Beberapa pelamar sudah diundang psikotes atau sudah melewati tahap tersebut.');
                }
            },
        ];
    }
}
