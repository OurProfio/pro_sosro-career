<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationStatusRequest extends FormRequest
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
        return [
            'status' => ['required', 'in:accepted,rejected'],
            'start_date' => ['required_if:status,accepted', 'nullable', 'date', 'after_or_equal:today'],
            'work_address' => ['required_if:status,accepted', 'nullable', 'string', 'max:1000'],
        ];
    }
}
