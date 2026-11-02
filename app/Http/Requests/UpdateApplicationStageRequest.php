<?php

namespace App\Http\Requests;

use App\Models\Stage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
                'interview_type' => ['required', 'in:virtual,offline'],
                'interview_date' => ['required', 'date', 'after_or_equal:today'],
                'interview_time' => ['required', 'date_format:H:i'],
                'interview_link' => ['required_if:interview_type,virtual', 'nullable', 'url'],
                'interview_address' => ['required_if:interview_type,offline', 'nullable', 'string'],
            ];
        }

        if ($stageName === 'panel bod') {
            return $rules + [
                'panel_bod_type' => ['required', 'in:virtual,offline'],
                'panel_bod_date' => ['nullable', 'date', 'after_or_equal:today'],
                'panel_bod_time' => ['nullable', 'date_format:H:i'],
                'panel_bod_link' => ['required_if:panel_bod_type,virtual', 'nullable', 'url'],
                'panel_bod_address' => ['required_if:panel_bod_type,offline', 'nullable', 'string'],
            ];
        }

        if ($stageName === 'psikotes') {
            return $rules + [
                'psikotes_link' => ['nullable', 'url'],
                'psikotes_code' => ['nullable', 'string', 'max:100'],
                'psikotes_date' => ['nullable', 'date'],
                'psikotes_time' => ['nullable', 'string', 'max:100'],
            ];
        }

        if ($stageName === 'mcu') {
            return $rules + [
                'mcu_date' => ['nullable', 'date'],
                'mcu_time' => ['nullable', 'string', 'max:50'],
                'mcu_location' => ['nullable', 'string', 'max:255'],
                'mcu_address' => ['nullable', 'string'],
            ];
        }

        if ($stageName === 'study case') {
            return $rules + [
                'study_case_link' => ['nullable', 'url'],
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
