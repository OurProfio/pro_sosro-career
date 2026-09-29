<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:HO,KPW,Pabrik,Lainnya',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama cabang harus diisi.',
            'name.string' => 'Nama cabang harus berupa teks.',
            'name.max' => 'Nama cabang tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Tipe cabang harus diisi.',
            'type.string' => 'Tipe cabang harus berupa teks.',
            'type.in' => 'Tipe cabang tidak valid.',
        ];
    }
}
