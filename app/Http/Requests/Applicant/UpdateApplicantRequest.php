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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('salary_expectation') && is_string($this->input('salary_expectation'))) {
            $cleanedSalary = preg_replace('/[^0-9]/', '', $this->input('salary_expectation'));
            $merge['salary_expectation'] = $cleanedSalary !== '' ? (int) $cleanedSalary : null;
        }

        if ($this->has('instagram')) {
            $ig = trim((string) $this->input('instagram'));
            $ig = preg_replace('#^https?://(www\.)?instagram\.com/#i', '', $ig);
            $ig = ltrim($ig, '@/');
            $ig = rtrim($ig, '/');
            $merge['instagram'] = $ig !== '' ? $ig : null;
        }

        if ($this->has('linkedin')) {
            $li = trim((string) $this->input('linkedin'));
            $li = preg_replace('#^https?://(www\.)?linkedin\.com/in/#i', '', $li);
            $li = ltrim($li, '@/');
            $li = rtrim($li, '/');
            $merge['linkedin'] = $li !== '' ? $li : null;
        }

        if (! empty($merge)) {
            $this->merge($merge);
        }
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
            'postal_code_ktp' => ['nullable', 'string', 'max:10'],
            'address_domisili' => ['required', 'string'],
            'postal_code_domisili' => ['nullable', 'string', 'max:10'],
            'gender' => ['required', 'in:l,p'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:'.now()->subYears(15)->format('Y-m-d')],
            'height' => ['required', 'integer', 'min:100', 'max:250'],
            'weight' => ['required', 'integer', 'min:30', 'max:250'],
            'blood_type' => ['required', 'in:A,B,AB,O'],
            'phone_number' => ['required', 'string', 'between:10,15'],
            'religion' => ['required', 'string', 'exists:treligion,RELIGION_ID'],
            'medical_history' => ['nullable', 'string'],
            'is_smoker' => ['required', 'in:y,n'],
            'has_tattoo' => ['required', 'in:y,n'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'marital_date' => ['nullable', 'integer', 'digits:4', 'min:1950', 'max:'.(int) date('Y')],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_relationship' => ['required', 'string', 'in:Orang Tua,Pasangan (Suami/Istri),Saudara Kandung,Kerabat/Keluarga Besar'],
            'emergency_contact_phone' => ['required', 'string', 'between:10,15'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'linkedin' => ['nullable', 'string', 'max:100'],
            'driver_licenses' => ['nullable', 'array'],
            'driver_licenses.*' => ['string', 'in:A,B1,B2,C,D'],
            'division_preferences' => ['nullable', 'array'],
            'division_preferences.*' => ['integer', 'exists:divisions,id'],
            'salary_expectation' => ['required', 'numeric', 'min:0'],
            'facility_expectation' => ['nullable', 'string', 'max:1000'],
            'ready_to_relocate' => ['required', 'boolean'],
            'ready_to_travel' => ['required', 'boolean'],
            'job_source' => ['required', 'string', 'in:Career Page,Jobfair,Jobstreet,KitaLulus,LinkedIn,Approach by HR,Social Media,Instagram Career,University Job Portal,Referral'],
            'reference_by' => ['nullable', 'required_if:job_source,Referral', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
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
            'date_of_birth.date' => 'Format tanggal lahir tidak valid.',
            'date_of_birth.before_or_equal' => 'Usia pelamar minimal harus 15 tahun.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'height.required' => 'Tinggi badan wajib diisi.',
            'weight.required' => 'Berat badan wajib diisi.',
            'blood_type.required' => 'Golongan darah wajib dipilih.',
            'blood_type.in' => 'Pilihan golongan darah tidak valid.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'religion.required' => 'Agama wajib diisi.',
            'religion.string' => 'Format agama tidak valid.',
            'religion.exists' => 'Pilihan agama tidak valid atau tidak terdaftar.',
            'is_smoker.required' => 'Status perokok wajib diisi.',
            'has_tattoo.required' => 'Status bertato wajib diisi.',
            'marital_status.required' => 'Status pernikahan wajib diisi.',
            'salary_expectation.required' => 'Ekspektasi gaji wajib diisi.',
            'salary_expectation.numeric' => 'Ekspektasi gaji harus berupa angka.',
            'salary_expectation.min' => 'Ekspektasi gaji tidak boleh bernilai negatif.',
            'facility_expectation.max' => 'Ekspektasi fasilitas maksimal 1000 karakter.',
            'ready_to_relocate.required' => 'Pilih kesiapan relokasi.',
            'ready_to_relocate.boolean' => 'Pilihan kesiapan relokasi tidak valid.',
            'ready_to_travel.required' => 'Pilih kesiapan perjalanan dinas.',
            'ready_to_travel.boolean' => 'Pilihan kesiapan perjalanan dinas tidak valid.',
            'job_source.required' => 'Sumber informasi lowongan wajib dipilih.',
            'job_source.in' => 'Pilihan sumber informasi lowongan tidak valid.',
            'reference_by.required_if' => 'Nama lengkap karyawan pemberi referensi wajib diisi jika memilih Referral.',
            'reference_by.max' => 'Nama referensi maksimal 255 karakter.',
            'photo.image' => 'Berkas yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Format pas foto harus berupa JPEG, PNG, atau JPG.',
            'photo.max' => 'Ukuran pas foto tidak boleh melebihi 2MB.',
            'emergency_contact_name.required' => 'Nama kontak darurat wajib diisi.',
            'emergency_contact_relationship.required' => 'Hubungan kontak darurat wajib dipilih.',
            'emergency_contact_relationship.in' => 'Hubungan kontak darurat yang dipilih tidak valid.',
            'emergency_contact_phone.required' => 'Nomor telepon kontak darurat wajib diisi.',
            'emergency_contact_phone.between' => 'Nomor telepon kontak darurat harus antara 10 sampai 15 digit.',
        ];
    }
}
