<?php

namespace App\Http\Requests\Applicant;

use App\Models\Applicant;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->applicant !== null);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $applicant = $this->route('applicant');
        $applicantId = $applicant instanceof Applicant ? $applicant->id : ($applicant ?? optional($this->user()->applicant)->id);

        return [
            'name' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('applicants', 'nik')->ignore($applicantId),
            ],
            'address_ktp' => ['required', 'string'],
            'address_domisili' => ['required', 'string'],
            'gender' => ['required', 'in:l,p'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'height' => ['required', 'integer', 'min:100', 'max:250'],
            'weight' => ['required', 'integer', 'min:30', 'max:250'],
            'phone_number' => ['required', 'string', 'between:10,15'],
            'religion' => ['required', 'string', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya'],
            'medical_history' => ['nullable', 'string'],
            'is_smoker' => ['required', 'in:y,n'],
            'has_tattoo' => ['required', 'in:y,n'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'driver_licenses' => ['nullable', 'array'],
            'driver_licenses.*' => ['string', 'in:A,B1,B2,C,D'],
            'division_preferences' => ['nullable', 'array'],
            'division_preferences.*' => ['integer', 'exists:divisions,id'],
            'redirect_step' => ['nullable', 'string', 'in:family,education,workExperience,index'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar oleh pelamar lain.',
            'address_ktp.required' => 'Alamat sesuai KTP wajib diisi.',
            'address_domisili.required' => 'Alamat domisili wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'place_of_birth.required' => 'Tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'height.required' => 'Tinggi badan wajib diisi.',
            'weight.required' => 'Berat badan wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'religion.required' => 'Agama wajib diisi.',
            'is_smoker.required' => 'Status perokok wajib diisi.',
            'has_tattoo.required' => 'Status bertato wajib diisi.',
            'marital_status.required' => 'Status pernikahan wajib diisi.',
        ];
    }
}
