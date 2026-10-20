<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
        $applicantId = optional($this->user()->applicant)->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email:rfc',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255',
                Rule::unique('applicants', 'email')->ignore($applicantId),
            ],
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
            'date_of_birth' => ['required', 'date', 'before:today'],
            'height' => ['required', 'integer', 'min:150', 'max:250'],
            'weight' => ['required', 'integer', 'min:40', 'max:250'],
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
            'division_preferences' => ['required', 'array', 'min:1'],
            'division_preferences.*' => ['required', 'integer', 'distinct', 'exists:divisions,id'],
            'salary_expectation' => ['required', 'numeric', 'min:0'],
            'facility_expectation' => ['nullable', 'string', 'max:1000'],
            'ready_to_relocate' => ['required', 'boolean'],
            'ready_to_travel' => ['required', 'boolean'],
            'job_source' => ['required', 'string', 'in:Career Page,Jobfair,Jobstreet,KitaLulus,LinkedIn,Approach by HR,Social Media,Instagram Career,University Job Portal,Referral'],
            'reference_by' => ['nullable', 'required_if:job_source,Referral', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Format email harus resmi dan valid (contoh: nama@domain.com atau nama@perusahaan.co.id).',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah terdaftar oleh pelamar lain.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar oleh pelamar lain.',
            'address_ktp.required' => 'Alamat sesuai KTP wajib diisi.',
            'address_ktp.string' => 'Alamat sesuai KTP harus berupa teks.',
            'address_domisili.required' => 'Alamat domisili wajib diisi.',
            'address_domisili.string' => 'Alamat domisili harus berupa teks.',
            'gender.required' => 'Jenis kelamin wajib diisi.',
            'gender.in' => 'Pilihan jenis kelamin tidak valid.',
            'place_of_birth.required' => 'Tempat lahir wajib diisi.',
            'place_of_birth.string' => 'Tempat lahir harus berupa teks.',
            'place_of_birth.max' => 'Tempat lahir maksimal 255 karakter.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'height.required' => 'Tinggi badan wajib diisi.',
            'height.integer' => 'Tinggi badan harus berupa angka bulat.',
            'height.min' => 'Tinggi badan tidak logis (minimal 100 cm).',
            'height.max' => 'Tinggi badan tidak logis (maksimal 250 cm).',
            'weight.required' => 'Berat badan wajib diisi.',
            'weight.integer' => 'Berat badan harus berupa angka bulat.',
            'weight.min' => 'Berat badan tidak logis (minimal 30 kg).',
            'weight.max' => 'Berat badan tidak logis (maksimal 250 kg).',
            'blood_type.required' => 'Golongan darah wajib dipilih.',
            'blood_type.in' => 'Pilihan golongan darah tidak valid.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.string' => 'Format nomor telepon tidak valid.',
            'phone_number.between' => 'Nomor telepon harus memiliki panjang 10 hingga 15 digit.',
            'religion.required' => 'Agama wajib diisi.',
            'religion.string' => 'Format agama tidak valid.',
            'religion.in' => 'Pilihan agama tidak valid.',
            'medical_history.string' => 'Riwayat penyakit harus berupa teks.',
            'is_smoker.required' => 'Status perokok wajib diisi.',
            'is_smoker.in' => 'Pilihan status perokok tidak valid.',
            'has_tattoo.required' => 'Status bertato wajib diisi.',
            'has_tattoo.in' => 'Pilihan status bertato tidak valid.',
            'marital_status.required' => 'Status pernikahan wajib diisi.',
            'marital_status.in' => 'Pilihan status pernikahan tidak valid.',
            'instagram.url' => 'Format URL Instagram tidak valid (gunakan format http:// atau https://).',
            'linkedin.url' => 'Format URL LinkedIn tidak valid (gunakan format http:// atau https://).',
            'driver_licenses.array' => 'Format data SIM tidak valid.',
            'driver_licenses.*.in' => 'Pilihan jenis SIM tidak valid.',
            'division_preferences.required' => 'Urutan prioritas divisi wajib ditentukan.',
            'division_preferences.array' => 'Format data minat divisi tidak valid.',
            'division_preferences.min' => 'Minimal pilih 1 divisi.',
            'division_preferences.*.required' => 'Divisi tidak boleh kosong.',
            'division_preferences.*.integer' => 'Format ID divisi tidak valid.',
            'division_preferences.*.distinct' => 'Terdapat duplikasi divisi dalam pilihan Anda.',
            'division_preferences.*.exists' => 'Divisi yang dipilih tidak ditemukan dalam sistem.',
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
