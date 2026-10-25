<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
        $admin = $this->user()?->admin;

        if ($admin && $admin->role !== 'superadmin' && $admin->office_id) {
            $this->merge([
                'office_id' => $admin->office_id,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'office_id' => ['required', 'exists:offices,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:profesional,management_trainee,internship,magang'],
            'occupation' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'qualification' => ['required', 'string'],
            'closing_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'office_id.required' => 'Kantor/Cabang penempatan wajib dipilih.',
            'office_id.exists' => 'Kantor/Cabang yang dipilih tidak valid.',
            'title.required' => 'Judul lowongan wajib diisi.',
            'title.string' => 'Judul lowongan harus berupa teks.',
            'title.max' => 'Judul lowongan tidak boleh lebih dari 255 karakter.',
            'category.required' => 'Kategori lowongan wajib diisi.',
            'category.in' => 'Kategori lowongan yang dipilih tidak valid.',
            'occupation.required' => 'Bidang pekerjaan (occupation) wajib diisi.',
            'occupation.string' => 'Bidang pekerjaan harus berupa teks.',
            'occupation.max' => 'Bidang pekerjaan tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Tipe pekerjaan wajib diisi.',
            'type.string' => 'Tipe pekerjaan harus berupa teks.',
            'type.max' => 'Tipe pekerjaan tidak boleh lebih dari 255 karakter.',
            'location.required' => 'Lokasi kerja wajib diisi.',
            'location.string' => 'Lokasi kerja harus berupa teks.',
            'location.max' => 'Lokasi kerja tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi pekerjaan wajib diisi.',
            'description.string' => 'Deskripsi pekerjaan harus berupa teks.',
            'qualification.required' => 'Kualifikasi pelamar wajib diisi.',
            'qualification.string' => 'Kualifikasi pelamar harus berupa teks.',
            'opening_date.required' => 'Tanggal buka lowongan wajib diisi.',
            'opening_date.date' => 'Format tanggal buka lowongan tidak valid.',
            'opening_date.after_or_equal' => 'Tanggal buka lowongan harus hari ini atau tanggal yang akan datang.',
            'closing_date.required' => 'Tanggal tutup lowongan wajib diisi.',
            'closing_date.date' => 'Format tanggal tutup lowongan tidak valid.',
            'closing_date.after_or_equal' => 'Tanggal tutup tidak boleh sebelum tanggal buka.',
        ];
    }
}
