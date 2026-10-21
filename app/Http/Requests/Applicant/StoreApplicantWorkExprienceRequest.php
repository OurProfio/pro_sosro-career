<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantWorkExprienceRequest extends FormRequest
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
        if ($this->has('experiences') && is_array($this->input('experiences'))) {
            $experiences = $this->input('experiences');
            foreach ($experiences as $key => $exp) {
                if (isset($exp['salary']) && is_string($exp['salary'])) {
                    $cleaned = preg_replace('/[^0-9]/', '', $exp['salary']);
                    $experiences[$key]['salary'] = $cleaned !== '' ? (int) $cleaned : null;
                }
            }
            $this->merge(['experiences' => $experiences]);
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
            'has_applied_sosro' => ['nullable', 'in:y,n'],
            'previous_applied_position' => ['required_if:has_applied_sosro,y', 'nullable', 'string', 'max:255'],
            'previous_applied_year' => ['required_if:has_applied_sosro,y', 'nullable', 'digits:4', 'integer'],
            'experiences' => ['nullable', 'array', 'max:3'],
            'experiences.*.company_name' => ['nullable', 'string', 'max:255'],
            'experiences.*.company_address' => ['nullable', 'string'],
            'experiences.*.company_phone' => ['nullable', 'string', 'max:20'],
            'experiences.*.position' => ['nullable', 'string', 'max:255'],
            'experiences.*.division' => ['nullable', 'string', 'max:255'],
            'experiences.*.salary' => ['nullable', 'numeric', 'min:0'],
            'experiences.*.start_date' => ['nullable', 'date', 'before_or_equal:today'],
            'experiences.*.end_date' => ['nullable', 'date', 'after_or_equal:experiences.*.start_date'],
            'experiences.*.facility' => ['nullable', 'string', 'max:255'],
            'experiences.*.reason_for_leaving' => ['nullable', 'string', 'max:255'],
            'experiences.*.reference_name' => ['nullable', 'string', 'max:255'],
            'experiences.*.reference_position' => ['nullable', 'string', 'max:255'],
            'experiences.*.reference_phone' => ['nullable', 'string', 'max:20'],
            'redirect_step' => ['nullable', 'string', 'in:personal,family,education,workExperience,index'],
        ];
    }

    public function messages(): array
    {
        return [
            'experiences.*.company_name.string' => 'Nama perusahaan harus berupa teks.',
            'experiences.*.company_name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'experiences.*.position.string' => 'Jabatan / posisi harus berupa teks.',
            'experiences.*.position.max' => 'Jabatan / posisi maksimal 255 karakter.',
            'experiences.*.division.string' => 'Divisi / departemen harus berupa teks.',
            'experiences.*.division.max' => 'Divisi / departemen maksimal 255 karakter.',
            'experiences.*.salary.numeric' => 'Gaji terakhir harus berupa angka.',
            'experiences.*.salary.min' => 'Gaji terakhir tidak boleh bernilai negatif.',
            'experiences.*.start_date.date' => 'Format tanggal mulai bekerja tidak valid.',
            'experiences.*.start_date.before_or_equal' => 'Tanggal mulai bekerja tidak boleh melebihi hari ini.',
            'experiences.*.end_date.date' => 'Format tanggal selesai bekerja tidak valid.',
            'experiences.*.end_date.after_or_equal' => 'Tanggal selesai bekerja harus sama atau setelah tanggal mulai.',
            'experiences.*.facility.string' => 'Fasilitas harus berupa teks.',
            'experiences.*.facility.max' => 'Fasilitas maksimal 255 karakter.',
            'experiences.*.reference_name.string' => 'Nama & telepon referensi harus berupa teks.',
            'experiences.*.reference_name.max' => 'Nama & telepon referensi maksimal 255 karakter.',
            'experiences.*.reason_for_leaving.string' => 'Alasan berhenti harus berupa teks.',
            'experiences.*.reason_for_leaving.max' => 'Alasan berhenti maksimal 255 karakter.',
            'experiences.max' => 'Maksimal riwayat pengalaman kerja yang dapat dimasukkan adalah 3.',
            'previous_applied_position.required_if' => 'Jabatan posisi wajib diisi jika pernah melamar di Sinar Sosro / Group.',
            'previous_applied_year.required_if' => 'Tahun wajib diisi jika pernah melamar di Sinar Sosro / Group.',
            'previous_applied_year.digits' => 'Tahun melamar harus terdiri dari 4 digit angka.',
        ];
    }
}
