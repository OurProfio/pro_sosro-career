<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationStatusRequest extends FormRequest
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
        return [
            'status' => ['required', 'in:accepted,rejected'],
            'start_date' => ['required_if:status,accepted', 'nullable', 'date', 'after_or_equal:today'],
            'work_address' => ['required_if:status,accepted', 'nullable', 'string'],
        ];
    }
}
