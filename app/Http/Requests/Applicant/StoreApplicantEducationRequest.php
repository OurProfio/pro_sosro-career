<?php

namespace App\Http\Requests\Applicant;

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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('educations') && is_array($this->input('educations'))) {
            $educations = $this->input('educations');
            $upperEduFields = ['institution_name', 'city', 'major', 'degree_level'];
            foreach ($educations as $k => $edu) {
                if (is_array($edu)) {
                    foreach ($upperEduFields as $f) {
                        if (isset($edu[$f]) && is_string($edu[$f])) {
                            $educations[$k][$f] = mb_strtoupper(trim($edu[$f]), 'UTF-8');
                        }
                    }
                }
            }
            $merge['educations'] = $educations;
        }

        if ($this->has('trainings') && is_array($this->input('trainings'))) {
            $trainings = $this->input('trainings');
            $upperTrainFields = ['training_name', 'organizer'];
            foreach ($trainings as $k => $tr) {
                if (is_array($tr)) {
                    foreach ($upperTrainFields as $f) {
                        if (isset($tr[$f]) && is_string($tr[$f])) {
                            $trainings[$k][$f] = mb_strtoupper(trim($tr[$f]), 'UTF-8');
                        }
                    }
                }
            }
            $merge['trainings'] = $trainings;
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
        $currentYear = date('Y');

        return [
            'educations' => ['required', 'array', 'min:1'],
            'educations.*.institution_name' => ['required', 'string', 'max:255'],
            'educations.*.city' => ['required', 'string', 'max:255'],
            'educations.*.degree_level' => ['required', 'string', 'max:100'],
            'educations.*.major' => ['required', 'string', 'max:150'],
            'educations.*.gpa' => ['required', 'numeric', 'between:0,100.00'],
            'educations.*.entry_year' => ['required', 'digits:4', 'integer', 'min:1970', 'max:'.$currentYear],
            'educations.*.graduation_year' => ['required', 'digits:4', 'integer', 'min:1970', 'gte:educations.*.entry_year'],
            'trainings' => ['nullable', 'array'],
            'trainings.*.training_name' => ['required_with:trainings', 'string', 'max:255'],
            'trainings.*.organizer' => ['required_with:trainings', 'string', 'max:255'],
            'trainings.*.finished' => ['required_with:trainings', 'date', 'before_or_equal:today'],
            'redirect_step' => ['nullable', 'string', 'in:personal,family,education,workExperience,index'],
        ];
    }

    public function attributes(): array
    {
        return [
            'educations' => 'riwayat pendidikan',
            'educations.*.institution_name' => 'nama sekolah / universitas',
            'educations.*.city' => 'kota/kabupaten sekolah',
            'educations.*.degree_level' => 'jenjang pendidikan',
            'educations.*.major' => 'jurusan / program studi',
            'educations.*.gpa' => 'IPK / nilai rata-rata',
            'educations.*.entry_year' => 'tahun masuk',
            'educations.*.graduation_year' => 'tahun lulus',
            'trainings' => 'riwayat pelatihan / kursus',
            'trainings.*.training_name' => 'nama pelatihan / kursus',
            'trainings.*.organizer' => 'penyelenggara pelatihan',
            'trainings.*.finished' => 'tanggal selesai pelatihan',
        ];
    }

    public function messages(): array
    {
        return [
            'educations.required' => 'Data riwayat pendidikan wajib diisi.',
            'educations.min' => 'Minimal sertakan 1 riwayat pendidikan terakhir.',
            'educations.*.institution_name.required' => 'Nama sekolah / universitas wajib diisi.',
            'educations.*.city.required' => 'Kota/Kabupaten sekolah wajib diisi.',
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
