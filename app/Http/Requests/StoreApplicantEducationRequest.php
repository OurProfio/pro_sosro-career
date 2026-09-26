<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantEducationRequest extends FormRequest
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
        $currentYear = date('Y');

        return [
            'educations' => ['required', 'array', 'min:1'],
            'educations.*.institution_name' => ['required', 'string', 'max:255'],
            'educations.*.degree_level' => ['required', 'string', 'in:SMA/SMK,D3,D4/S1,S2,S3'],
            'educations.*.major' => ['required', 'string', 'max:150'],
            'educations.*.gpa' => ['required', 'numeric', 'between:0,100.00'],
            'educations.*.entry_year' => ['required', 'digits:4', 'integer', 'min:1970', 'max:' . $currentYear],
            'educations.*.graduation_year' => ['required', 'digits:4', 'integer', 'min:1970', 'gte:educations.*.entry_year'],
            'trainings' => ['nullable', 'array'],
            'trainings.*.training_name' => ['required_with:trainings', 'string', 'max:255'],
            'trainings.*.organizer' => ['required_with:trainings', 'string', 'max:255'],
            'trainings.*.finished' => ['required_with:trainings', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'educations.required' => 'Data riwayat pendidikan wajib diisi.',
            'educations.min' => 'Minimal sertakan 1 riwayat pendidikan terakhir.',
            'educations.*.institution_name.required' => 'Nama sekolah / universitas wajib diisi.',
            'educations.*.degree_level.required' => 'Jenjang pendidikan wajib dipilih.',
            'educations.*.degree_level.in' => 'Pilihan jenjang pendidikan tidak valid.',
            'educations.*.major.required' => 'Jurusan / program studi wajib diisi.',
            'educations.*.gpa.required' => 'IPK / nilai rata-rata wajib diisi.',
            'educations.*.gpa.numeric' => 'IPK / nilai harus berupa angka.',
            'educations.*.gpa.between' => 'IPK / nilai harus bernilai antara 0 sampai 100.00.',
            'educations.*.entry_year.required' => 'Tahun masuk wajib diisi.',
            'educations.*.entry_year.digits' => 'Tahun masuk harus terdiri dari 4 digit angka.',
            'educations.*.entry_year.min' => 'Tahun masuk tidak valid (minimal tahun 1970).',
            'educations.*.entry_year.max' => 'Tahun masuk tidak boleh melebihi tahun saat ini.',
            'educations.*.graduation_year.required' => 'Tahun lulus wajib diisi.',
            'educations.*.graduation_year.digits' => 'Tahun lulus harus terdiri dari 4 digit angka.',
            'educations.*.graduation_year.gte' => 'Tahun lulus tidak boleh lebih kecil dari tahun masuk.',
            'trainings.*.training_name.required_with' => 'Nama pelatihan / kursus wajib diisi.',
            'trainings.*.training_name.string' => 'Nama pelatihan / kursus harus berupa teks.',
            'trainings.*.training_name.max' => 'Nama pelatihan / kursus maksimal 255 karakter.',

            'trainings.*.organizer.required_with' => 'Penyelenggara / lembaga wajib diisi.',
            'trainings.*.organizer.string' => 'Penyelenggara / lembaga harus berupa teks.',
            'trainings.*.organizer.max' => 'Penyelenggara / lembaga maksimal 255 karakter.',

            'trainings.*.finished.required_with' => 'Tanggal / tahun selesai pelatihan wajib diisi.',
            'trainings.*.finished.date' => 'Format tanggal selesai pelatihan tidak valid.',
            'trainings.*.finished.before_or_equal' => 'Tanggal selesai pelatihan tidak boleh melebihi hari ini.',
        ];
    }
}
