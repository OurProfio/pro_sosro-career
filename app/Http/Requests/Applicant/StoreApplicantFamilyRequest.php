<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantFamilyRequest extends FormRequest
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
        if ($this->has('families') && is_array($this->input('families'))) {
            $families = $this->input('families');
            $upperFields = ['name', 'place_of_birth', 'work'];

            foreach (['father', 'mother', 'spouse', 'father_in_law', 'mother_in_law'] as $rel) {
                if (isset($families[$rel]) && is_array($families[$rel])) {
                    foreach ($upperFields as $f) {
                        if (isset($families[$rel][$f]) && is_string($families[$rel][$f])) {
                            $families[$rel][$f] = mb_strtoupper(trim($families[$rel][$f]), 'UTF-8');
                        }
                    }
                }
            }

            foreach (['siblings', 'children'] as $listKey) {
                if (isset($families[$listKey]) && is_array($families[$listKey])) {
                    foreach ($families[$listKey] as $k => $item) {
                        if (is_array($item)) {
                            foreach ($upperFields as $f) {
                                if (isset($item[$f]) && is_string($item[$f])) {
                                    $families[$listKey][$k][$f] = mb_strtoupper(trim($item[$f]), 'UTF-8');
                                }
                            }
                        }
                    }
                }
            }

            $this->merge(['families' => $families]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'families.father.name' => ['required', 'string', 'max:255'],
            'families.father.status' => ['required', 'in:alive,deceased,divorced'],
            'families.father.place_of_birth' => ['required', 'string', 'max:100'],
            'families.father.date_of_birth' => ['required', 'date', 'before:today'],
            'families.father.education' => ['required', 'string', 'max:100'],
            'families.father.work' => ['nullable', 'string', 'max:100'],
            'families.father.phone_number' => ['nullable', 'string', 'max:15'],
            'families.father.relationship' => ['required', 'in:father'],
            'families.father.family_type' => ['required', 'in:biological'],
            'families.mother.name' => ['required', 'string', 'max:255'],
            'families.mother.status' => ['required', 'in:alive,deceased,divorced'],
            'families.mother.place_of_birth' => ['required', 'string', 'max:100'],
            'families.mother.date_of_birth' => ['required', 'date', 'before:today'],
            'families.mother.education' => ['required', 'string', 'max:100'],
            'families.mother.work' => ['nullable', 'string', 'max:100'],
            'families.mother.phone_number' => ['nullable', 'string', 'max:15'],
            'families.mother.relationship' => ['required', 'in:mother'],
            'families.mother.family_type' => ['required', 'in:biological'],
            'families.siblings' => ['nullable', 'array'],
            'families.siblings.*.name' => ['required', 'string', 'max:255'],
            'families.siblings.*.place_of_birth' => ['required', 'string', 'max:100'],
            'families.siblings.*.date_of_birth' => ['required', 'date', 'before:today'],
            'families.siblings.*.education' => ['required', 'string', 'max:100'],
            'families.siblings.*.work' => ['required', 'string', 'max:100'],
            'families.siblings.*.phone_number' => ['required', 'numeric', 'digits_between:1,15'],
            'families.siblings.*.relationship' => ['required', 'in:sibling'],
            'families.siblings.*.family_type' => ['required', 'in:biological'],
            'families.siblings.*.gender' => ['nullable', 'in:l,p'],
            'redirect_step' => ['nullable', 'string', 'in:personal,family,education,workExperience,index'],
        ];

        $maritalStatus = auth()->user()->applicant->marital_status ?? 'single';
        if (in_array($maritalStatus, ['married', 'divorced', 'widowed'])) {
            $rules['families.spouse.name'] = ['required', 'string', 'max:255'];
            $rules['families.spouse.place_of_birth'] = ['required', 'string', 'max:100'];
            $rules['families.spouse.date_of_birth'] = ['required', 'date', 'before:today'];
            $rules['families.spouse.education'] = ['required', 'string', 'max:100'];
            $rules['families.spouse.work'] = ['required', 'string', 'max:100'];
            $rules['families.spouse.phone_number'] = ['required', 'numeric', 'digits_between:10,15'];
            $rules['families.spouse.relationship'] = ['required', 'in:spouse'];
            $rules['families.spouse.family_type'] = ['required', 'in:nuclear'];
            $rules['families.spouse.gender'] = ['nullable', 'in:l,p'];
            $rules['families.children'] = ['nullable', 'array', 'max:3'];
            $rules['families.children.*.name'] = ['required', 'string', 'max:255'];
            $rules['families.children.*.place_of_birth'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.date_of_birth'] = ['required', 'date', 'before:today'];
            $rules['families.children.*.education'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.work'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.phone_number'] = ['required', 'numeric', 'digits_between:1,15'];
            $rules['families.children.*.relationship'] = ['required', 'in:child'];
            $rules['families.children.*.family_type'] = ['required', 'in:nuclear'];
            $rules['families.children.*.gender'] = ['nullable', 'in:l,p'];

            $rules['families.father_in_law.name'] = ['nullable', 'string', 'max:255'];
            $rules['families.father_in_law.place_of_birth'] = ['nullable', 'string', 'max:100'];
            $rules['families.father_in_law.date_of_birth'] = ['nullable', 'date', 'before:today'];
            $rules['families.father_in_law.education'] = ['nullable', 'string', 'max:100'];
            $rules['families.father_in_law.work'] = ['nullable', 'string', 'max:100'];
            $rules['families.father_in_law.phone_number'] = ['nullable', 'string', 'max:20'];
            $rules['families.father_in_law.relationship'] = ['nullable', 'in:father_in_law'];
            $rules['families.father_in_law.family_type'] = ['nullable', 'in:nuclear'];
            $rules['families.father_in_law.gender'] = ['nullable', 'in:l,p'];

            $rules['families.mother_in_law.name'] = ['nullable', 'string', 'max:255'];
            $rules['families.mother_in_law.place_of_birth'] = ['nullable', 'string', 'max:100'];
            $rules['families.mother_in_law.date_of_birth'] = ['nullable', 'date', 'before:today'];
            $rules['families.mother_in_law.education'] = ['nullable', 'string', 'max:100'];
            $rules['families.mother_in_law.work'] = ['nullable', 'string', 'max:100'];
            $rules['families.mother_in_law.phone_number'] = ['nullable', 'string', 'max:20'];
            $rules['families.mother_in_law.relationship'] = ['nullable', 'in:mother_in_law'];
            $rules['families.mother_in_law.family_type'] = ['nullable', 'in:nuclear'];
            $rules['families.mother_in_law.gender'] = ['nullable', 'in:l,p'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            // Ayah Kandung
            'families.father.name' => 'nama lengkap ayah',
            'families.father.status' => 'status kondisi ayah',
            'families.father.place_of_birth' => 'tempat lahir ayah',
            'families.father.date_of_birth' => 'tanggal lahir ayah',
            'families.father.education' => 'pendidikan terakhir ayah',
            'families.father.work' => 'pekerjaan ayah',
            'families.father.phone_number' => 'nomor telepon ayah',

            // Ibu Kandung
            'families.mother.name' => 'nama lengkap ibu',
            'families.mother.status' => 'status kondisi ibu',
            'families.mother.place_of_birth' => 'tempat lahir ibu',
            'families.mother.date_of_birth' => 'tanggal lahir ibu',
            'families.mother.education' => 'pendidikan terakhir ibu',
            'families.mother.work' => 'pekerjaan ibu',
            'families.mother.phone_number' => 'nomor telepon ibu',

            // Saudara Kandung
            'families.siblings' => 'data saudara kandung',
            'families.siblings.*.name' => 'nama saudara kandung',
            'families.siblings.*.gender' => 'jenis kelamin saudara kandung',
            'families.siblings.*.place_of_birth' => 'tempat lahir saudara kandung',
            'families.siblings.*.date_of_birth' => 'tanggal lahir saudara kandung',
            'families.siblings.*.education' => 'pendidikan terakhir saudara kandung',
            'families.siblings.*.work' => 'pekerjaan saudara kandung',
            'families.siblings.*.phone_number' => 'nomor telepon saudara kandung',

            // Pasangan
            'families.spouse.name' => 'nama lengkap pasangan',
            'families.spouse.place_of_birth' => 'tempat lahir pasangan',
            'families.spouse.date_of_birth' => 'tanggal lahir pasangan',
            'families.spouse.education' => 'pendidikan terakhir pasangan',
            'families.spouse.work' => 'pekerjaan pasangan',
            'families.spouse.phone_number' => 'nomor telepon pasangan',

            // Anak
            'families.children' => 'data anak',
            'families.children.*.name' => 'nama anak',
            'families.children.*.gender' => 'jenis kelamin anak',
            'families.children.*.place_of_birth' => 'tempat lahir anak',
            'families.children.*.date_of_birth' => 'tanggal lahir anak',
            'families.children.*.education' => 'pendidikan anak',
            'families.children.*.work' => 'pekerjaan anak',
            'families.children.*.phone_number' => 'nomor telepon anak',

            // Mertua
            'families.father_in_law.name' => 'nama lengkap ayah mertua',
            'families.father_in_law.place_of_birth' => 'tempat lahir ayah mertua',
            'families.father_in_law.date_of_birth' => 'tanggal lahir ayah mertua',
            'families.father_in_law.education' => 'pendidikan ayah mertua',
            'families.father_in_law.work' => 'pekerjaan ayah mertua',
            'families.father_in_law.phone_number' => 'nomor telepon ayah mertua',

            'families.mother_in_law.name' => 'nama lengkap ibu mertua',
            'families.mother_in_law.place_of_birth' => 'tempat lahir ibu mertua',
            'families.mother_in_law.date_of_birth' => 'tanggal lahir ibu mertua',
            'families.mother_in_law.education' => 'pendidikan ibu mertua',
            'families.mother_in_law.work' => 'pekerjaan ibu mertua',
            'families.mother_in_law.phone_number' => 'nomor telepon ibu mertua',
        ];
    }

    public function messages(): array
    {
        return [
            // Ayah Kandung
            'families.father.name.required' => 'Nama lengkap ayah kandung wajib diisi.',
            'families.father.status.required' => 'Status kondisi ayah kandung wajib dipilih.',
            'families.father.status.in' => 'Pilihan status ayah tidak valid.',
            'families.father.place_of_birth.required' => 'Tempat lahir ayah kandung wajib diisi.',
            'families.father.date_of_birth.required' => 'Tanggal lahir ayah kandung wajib diisi.',
            'families.father.date_of_birth.date' => 'Format tanggal lahir ayah tidak valid.',
            'families.father.date_of_birth.before' => 'Tanggal lahir ayah harus sebelum hari ini.',
            'families.father.education.required' => 'Pendidikan terakhir ayah kandung wajib dipilih.',
            'families.father.work.string' => 'Pekerjaan ayah harus berupa teks.',
            'families.father.phone_number.string' => 'Format nomor telepon ayah tidak valid.',

            // Ibu Kandung
            'families.mother.name.required' => 'Nama lengkap ibu kandung wajib diisi.',
            'families.mother.status.required' => 'Status kondisi ibu kandung wajib dipilih.',
            'families.mother.status.in' => 'Pilihan status ibu tidak valid.',
            'families.mother.place_of_birth.required' => 'Tempat lahir ibu kandung wajib diisi.',
            'families.mother.date_of_birth.required' => 'Tanggal lahir ibu kandung wajib diisi.',
            'families.mother.date_of_birth.date' => 'Format tanggal lahir ibu tidak valid.',
            'families.mother.date_of_birth.before' => 'Tanggal lahir ibu harus sebelum hari ini.',
            'families.mother.education.required' => 'Pendidikan terakhir ibu kandung wajib dipilih.',
            'families.mother.work.string' => 'Pekerjaan ibu harus berupa teks.',
            'families.mother.phone_number.string' => 'Format nomor telepon ibu tidak valid.',

            // Saudara Kandung
            'families.siblings.*.name.required' => 'Nama lengkap saudara kandung wajib diisi.',
            'families.siblings.*.gender.required' => 'Jenis kelamin saudara kandung wajib dipilih.',
            'families.siblings.*.place_of_birth.required' => 'Tempat lahir saudara kandung wajib diisi.',
            'families.siblings.*.date_of_birth.required' => 'Tanggal lahir saudara kandung wajib diisi.',
            'families.siblings.*.date_of_birth.date' => 'Format tanggal lahir saudara kandung tidak valid.',
            'families.siblings.*.date_of_birth.before' => 'Tanggal lahir saudara kandung harus sebelum hari ini.',
            'families.siblings.*.education.required' => 'Pendidikan terakhir saudara kandung wajib dipilih.',
            'families.siblings.*.work.required' => 'Pekerjaan saudara kandung wajib diisi.',
            'families.siblings.*.phone_number.required' => 'Nomor telepon saudara kandung wajib diisi.',
            'families.siblings.*.phone_number.numeric' => 'Nomor telepon saudara kandung harus berupa angka.',
            'families.siblings.*.phone_number.digits_between' => 'Nomor telepon saudara kandung harus antara 1 sampai 15 digit.',

            // Pasangan
            'families.spouse.name.required' => 'Nama lengkap pasangan wajib diisi.',
            'families.spouse.place_of_birth.required' => 'Tempat lahir pasangan wajib diisi.',
            'families.spouse.date_of_birth.required' => 'Tanggal lahir pasangan wajib diisi.',
            'families.spouse.date_of_birth.date' => 'Format tanggal lahir pasangan tidak valid.',
            'families.spouse.date_of_birth.before' => 'Tanggal lahir pasangan harus sebelum hari ini.',
            'families.spouse.education.required' => 'Pendidikan terakhir pasangan wajib dipilih.',
            'families.spouse.work.required' => 'Pekerjaan pasangan wajib diisi.',
            'families.spouse.phone_number.required' => 'Nomor telepon pasangan wajib diisi.',
            'families.spouse.phone_number.numeric' => 'Nomor telepon pasangan harus berupa angka.',
            'families.spouse.phone_number.digits_between' => 'Nomor telepon pasangan harus antara 10 sampai 15 digit.',

            // Anak
            'families.children.max' => 'Maksimal data anak yang dapat dimasukkan adalah :max anak.',
            'families.children.*.name.required' => 'Nama anak wajib diisi.',
            'families.children.*.place_of_birth.required' => 'Tempat lahir anak wajib diisi.',
            'families.children.*.date_of_birth.required' => 'Tanggal lahir anak wajib diisi.',
            'families.children.*.date_of_birth.date' => 'Format tanggal lahir anak tidak valid.',
            'families.children.*.date_of_birth.before' => 'Tanggal lahir anak harus sebelum hari ini.',
            'families.children.*.education.required' => 'Pendidikan anak wajib dipilih.',
            'families.children.*.work.required' => 'Pekerjaan / status anak wajib diisi.',
            'families.children.*.phone_number.required' => 'Nomor telepon anak wajib diisi (isi 0 jika belum ada).',
            'families.children.*.phone_number.numeric' => 'Nomor telepon anak harus berupa angka.',
            'families.children.*.phone_number.digits_between' => 'Nomor telepon anak harus antara 1 sampai 15 digit.',

            // Mertua
            'families.father_in_law.date_of_birth.before' => 'Tanggal lahir ayah mertua harus sebelum hari ini.',
            'families.mother_in_law.date_of_birth.before' => 'Tanggal lahir ibu mertua harus sebelum hari ini.',

            // Fallback generic
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'before' => ':attribute harus sebelum hari ini.',
            'numeric' => ':attribute harus berupa angka.',
            'digits_between' => ':attribute harus berisi antara :min sampai :max digit.',
            'in' => 'Pilihan :attribute tidak valid.',
            'array' => ':attribute harus berupa format array.',
            'max' => ':attribute tidak boleh melebihi :max data.',
        ];
    }
}
