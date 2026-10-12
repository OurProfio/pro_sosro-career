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

        if (! $this->selectedStage()?->isInterview()) {
            return $rules;
        }

        return $rules + [
            'interview_type' => ['required', 'in:virtual,offline'],
            'interview_date' => ['required', 'date', 'after_or_equal:today'],
            'interview_time' => ['required', 'date_format:H:i'],
            'interview_link' => ['required_if:interview_type,virtual', 'nullable', 'url'],
            'interview_address' => ['required_if:interview_type,offline', 'nullable', 'string'],
        ];
    }

    /**
     * Get the stage chosen in the request.
     */
    public function selectedStage(): ?Stage
    {
        return Stage::find($this->input('stages_id'));
    }
}
