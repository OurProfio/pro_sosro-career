<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCabangRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|in:HO,KPW,Pabrik,Lainnya',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama cabang harus diisi.',
            'nama.string' => 'Nama cabang harus berupa teks.',
            'nama.max' => 'Nama cabang tidak boleh lebih dari 255 karakter.',
            'tipe.required' => 'Tipe cabang harus diisi.',
            'tipe.string' => 'Tipe cabang harus berupa teks.',
            'tipe.in' => 'Tipe cabang tidak valid.',
        ];
    }
}
