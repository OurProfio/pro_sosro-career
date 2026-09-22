<?php

namespace App\Http\Requests;

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
                'email',
                'max:255',
                Rule::unique('applicants', 'email')->ignore($applicantId),
            ],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('applicants', 'nik')->ignore($applicantId),
            ],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'tinggi_badan' => ['required', 'integer', 'min:100', 'max:250'],
            'berat_badan' => ['required', 'integer', 'min:30', 'max:250'],
            'no_telepon' => ['required', 'string', 'between:10,15'],
            'agama' => ['required', 'string', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya'],
            'status_pernikahan' => ['required', 'in:belum_menikah,sudah_menikah,cerai_hidup,cerai_mati'],
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
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah terdaftar oleh pelamar lain.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar oleh pelamar lain.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.integer' => 'Tinggi badan harus berupa angka bulat.',
            'tinggi_badan.min' => 'Tinggi badan tidak logis (minimal 100 cm).',
            'tinggi_badan.max' => 'Tinggi badan tidak logis (maksimal 250 cm).',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.integer' => 'Berat badan harus berupa angka bulat.',
            'berat_badan.min' => 'Berat badan tidak logis (minimal 30 kg).',
            'berat_badan.max' => 'Berat badan tidak logis (maksimal 250 kg).',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Format nomor telepon tidak valid.',
            'no_telepon.between' => 'Nomor telepon harus memiliki panjang 10 hingga 15 digit.',
            'agama.required' => 'Agama wajib diisi.',
            'agama.string' => 'Format agama tidak valid.',
            'agama.in' => 'Pilihan agama tidak valid.',
            'status_pernikahan.required' => 'Status pernikahan wajib diisi.',
            'status_pernikahan.in' => 'Pilihan status pernikahan tidak valid.',
        ];
    }
}
