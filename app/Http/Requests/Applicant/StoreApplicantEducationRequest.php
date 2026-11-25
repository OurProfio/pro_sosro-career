<?php

namespace App\Http\Requests\Applicant;

use App\Http\Requests\Concerns\UppercasesInput;
use Database\Seeders\ThrmListFacultySeeder;
use Database\Seeders\ThrmListMajorSeeder;
use Database\Seeders\ThrmListSchoolSeeder;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class StoreApplicantEducationRequest extends FormRequest
{
    use UppercasesInput;

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
        $this->uppercaseInput([
            'educations.*.institution_name',
            'educations.*.faculty',
            'educations.*.state',
            'educations.*.degree_level',
            'educations.*.major',
            'trainings.*.training_name',
            'trainings.*.organizer',
        ]);

        $educations = $this->input('educations');
        if (is_array($educations)) {
            $hasOtherSchool = DB::table('thrm_list_school')
                ->where('EDU_ID', ThrmListSchoolSeeder::OTHER_EDU_ID)
                ->exists();
            $hasOtherFaculty = DB::table('thrm_list_faculty')
                ->where('FACULTY_ID', ThrmListFacultySeeder::OTHER_FACULTY_ID)
                ->exists();
            $hasOtherMajor = DB::table('thrm_list_major')
                ->where('MAJOR_ID', ThrmListMajorSeeder::OTHER_MAJOR_ID)
                ->exists();

            foreach ($educations as $index => $education) {
                if (! is_array($education)) {
                    continue;
                }

                $degreeLevel = trim((string) ($education['degree_level'] ?? ''));
                $isHighSchool = (bool) preg_match('/\b(SMA|SMK|STM)\b/i', $degreeLevel);

                if (empty($education['edutype_id']) && $degreeLevel !== '') {
                    $resolvedEduTypeId = DB::table('thrm_education')
                        ->whereRaw('UPPER(EDUTYPE_NAME_ID) = ?', [strtoupper($degreeLevel)])
                        ->orWhereRaw('UPPER(EDUTYPE_NAME_EN) = ?', [strtoupper($degreeLevel)])
                        ->value('EDUTYPE_ID');

                    if ($resolvedEduTypeId !== null) {
                        $educations[$index]['edutype_id'] = (int) $resolvedEduTypeId;
                    }
                } elseif (! empty($education['edutype_id']) && is_numeric($education['edutype_id'])) {
                    $educations[$index]['edutype_id'] = (int) $education['edutype_id'];
                } else {
                    $educations[$index]['edutype_id'] = null;
                }

                $institutionName = trim((string) ($education['institution_name'] ?? ''));
                if (empty($education['school_id']) && $institutionName !== '') {
                    $resolvedSchoolId = DB::table('thrm_list_school')
                        ->whereRaw('LOWER(EDU_NAME) = ?', [mb_strtolower($institutionName, 'UTF-8')])
                        ->value('EDU_ID');

                    if ($resolvedSchoolId !== null) {
                        $educations[$index]['school_id'] = (int) $resolvedSchoolId;
                    } elseif ($hasOtherSchool) {
                        $educations[$index]['school_id'] = ThrmListSchoolSeeder::OTHER_EDU_ID;
                    }
                } elseif (! empty($education['school_id']) && is_numeric($education['school_id'])) {
                    $educations[$index]['school_id'] = (int) $education['school_id'];
                } else {
                    $educations[$index]['school_id'] = null;
                }

                if ($isHighSchool) {
                    $educations[$index]['faculty'] = null;
                    $educations[$index]['faculty_id'] = null;
                } else {
                    $facultyName = trim((string) ($education['faculty'] ?? ''));
                    if (empty($education['faculty_id']) && $facultyName !== '') {
                        $resolvedFacultyId = DB::table('thrm_list_faculty')
                            ->whereRaw('LOWER(FACULTY_NAME) = ?', [mb_strtolower($facultyName, 'UTF-8')])
                            ->value('FACULTY_ID');

                        if ($resolvedFacultyId !== null) {
                            $educations[$index]['faculty_id'] = (int) $resolvedFacultyId;
                        } elseif ($hasOtherFaculty) {
                            $educations[$index]['faculty_id'] = ThrmListFacultySeeder::OTHER_FACULTY_ID;
                        }
                    } elseif (! empty($education['faculty_id']) && is_numeric($education['faculty_id'])) {
                        $educations[$index]['faculty_id'] = (int) $education['faculty_id'];
                    } else {
                        $educations[$index]['faculty_id'] = null;
                    }
                }

                $majorName = trim((string) ($education['major'] ?? ''));
                if (empty($education['major_id']) && $majorName !== '') {
                    $resolvedMajorId = DB::table('thrm_list_major')
                        ->whereRaw('LOWER(MAJOR_NAME) = ?', [mb_strtolower($majorName, 'UTF-8')])
                        ->value('MAJOR_ID');

                    if ($resolvedMajorId !== null) {
                        $educations[$index]['major_id'] = (int) $resolvedMajorId;
                    } elseif ($hasOtherMajor) {
                        $educations[$index]['major_id'] = ThrmListMajorSeeder::OTHER_MAJOR_ID;
                    }
                } elseif (! empty($education['major_id']) && is_numeric($education['major_id'])) {
                    $educations[$index]['major_id'] = (int) $education['major_id'];
                } else {
                    $educations[$index]['major_id'] = null;
                }
            }

            $this->merge(['educations' => $educations]);
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
            'educations.*.edutype_id' => ['nullable', 'integer', 'exists:thrm_education,EDUTYPE_ID'],
            'educations.*.school_id' => ['nullable', 'integer', 'exists:thrm_list_school,EDU_ID'],
            'educations.*.faculty_id' => ['nullable', 'integer', 'exists:thrm_list_faculty,FACULTY_ID'],
            'educations.*.major_id' => ['nullable', 'integer', 'exists:thrm_list_major,MAJOR_ID'],
            'educations.*.institution_name' => ['required', 'string', 'max:255'],
            'educations.*.faculty' => ['nullable', 'string', 'max:255'],
            'educations.*.state' => ['required', 'string', 'max:255'],
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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $educations = $this->input('educations', []);
            if (! is_array($educations)) {
                return;
            }

            foreach ($educations as $index => $education) {
                if (! is_array($education)) {
                    continue;
                }

                $degreeLevel = (string) ($education['degree_level'] ?? '');
                if (preg_match('/\b(SMA|SMK|STM)\b/i', $degreeLevel)) {
                    continue;
                }

                $faculty = trim((string) ($education['faculty'] ?? ''));
                if ($faculty === '') {
                    $validator->errors()->add("educations.{$index}.faculty", 'Fakultas wajib diisi.');
                }
            }
        });
    }

    public function attributes(): array
    {
        return [
            'educations' => 'riwayat pendidikan',
            'educations.*.institution_name' => 'nama sekolah / universitas',
            'educations.*.faculty' => 'fakultas',
            'educations.*.state' => 'kota/provinsi sekolah',
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
            'educations.*.state.required' => 'Kota/Provinsi sekolah wajib diisi.',
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
