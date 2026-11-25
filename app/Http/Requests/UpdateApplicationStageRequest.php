<?php

namespace App\Http\Requests;

use App\Models\Stage;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        abort_unless(
            $this->route('application')->job->isManageableBy($this->user()?->admin),
            403,
            'Akses tidak diizinkan untuk kantor cabang lain.'
        );

        return true;
    }

    /**
     * Get the closures to run after validation.
     *
     * @return array<int, Closure(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->route('application')->isClosed()) {
                    $validator->errors()->add('application', 'Lamaran ini sudah berstatus final dan tidak dapat diubah lagi.');
                }
            },
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'stages_id' => [
                'required',
                Rule::exists('stages', 'id')->where('type', $this->route('application')->job->category),
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];

        $stage = $this->selectedStage();
        if (! $stage) {
            return $rules;
        }

        if ($stage->isUserConfirmation()) {
            return $rules + ['user_email' => ['required', 'email', 'max:255']];
        }

        $stageName = strtolower(trim($stage->name));

        if (str_starts_with($stageName, 'interview')) {
            return $rules + [
                'interview_type' => ['required', 'in:online,offline'],
                'interview_date' => ['required', 'date', 'after_or_equal:today'],
                'interview_time' => ['required', 'date_format:H:i'],
                'interview_link' => ['required_if:interview_type,online', 'nullable', 'url', 'max:2048'],
                'interview_address' => ['required_if:interview_type,offline', 'nullable', 'string', 'max:1000'],
            ];
        }

        if ($stageName === 'panel bod') {
            return $rules + [
                'panel_bod_type' => ['required', 'in:online,offline'],
                'panel_bod_date' => ['nullable', 'date', 'after_or_equal:today'],
                'panel_bod_time' => ['nullable', 'date_format:H:i'],
                'panel_bod_link' => ['required_if:panel_bod_type,online', 'nullable', 'url', 'max:2048'],
                'panel_bod_address' => ['required_if:panel_bod_type,offline', 'nullable', 'string', 'max:1000'],
            ];
        }

        if ($stageName === 'psikotes') {
            return $rules + [
                'psikotes_link' => ['nullable', 'url', 'max:2048'],
                'psikotes_code' => ['nullable', 'string', 'max:100'],
                'psikotes_date' => ['nullable', 'date', 'after_or_equal:today'],
                'psikotes_time' => ['nullable', 'date_format:H:i'],
            ];
        }

        if ($stageName === 'mcu') {
            return $rules + [
                'mcu_date' => ['nullable', 'date', 'after_or_equal:today'],
                'mcu_time' => ['nullable', 'date_format:H:i'],
                'mcu_location' => ['nullable', 'string', 'max:255'],
                'mcu_address' => ['nullable', 'string', 'max:1000'],
            ];
        }

        if ($stageName === 'study case') {
            return $rules + [
                'study_case_link' => ['nullable', 'url', 'max:2048'],
                'study_case_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            ];
        }

        return $rules;
    }

    /**
     * Get the stage chosen in the request.
     */
    public function selectedStage(): ?Stage
    {
        return Stage::find($this->input('stages_id'));
    }
}
