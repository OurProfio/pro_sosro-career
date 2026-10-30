<?php

namespace App\Http\Requests\Applicant;

use App\Http\Requests\Concerns\UppercasesInput;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantFamilyRequest extends FormRequest
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
            'families.father.name',
            'families.father.place_of_birth',
            'families.father.education',
            'families.father.work',
            'families.mother.name',
            'families.mother.place_of_birth',
            'families.mother.education',
            'families.mother.work',
            'families.siblings.*.name',
            'families.siblings.*.place_of_birth',
            'families.siblings.*.education',
            'families.siblings.*.work',
            'families.spouse.name',
            'families.spouse.place_of_birth',
            'families.spouse.education',
            'families.spouse.work',
            'families.children.*.name',
            'families.children.*.place_of_birth',
            'families.children.*.education',
            'families.children.*.work',
            'families.father_in_law.name',
            'families.father_in_law.place_of_birth',
            'families.father_in_law.education',
            'families.father_in_law.work',
            'families.mother_in_law.name',
            'families.mother_in_law.place_of_birth',
            'families.mother_in_law.education',
            'families.mother_in_law.work',
        ]);
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

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'families.father.date_of_birth.required' => 'Tanggal lahir ayah kandung wajib diisi.',
            'families.mother.date_of_birth.required' => 'Tanggal lahir ibu kandung wajib diisi.',

            // Fallback generic
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'before' => ':attribute harus sebelum hari ini.',
            'numeric' => ':attribute harus berupa angka.',
            'digits_between' => ':attribute harus berisi antara :min sampai :max digit.',
            'in' => 'Pilihan :attribute tidak valid.',
            'array' => ':attribute harus berupa format array.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'families.children.max' => ':attribute tidak boleh lebih dari :max data.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $labels = [
            'name' => 'nama lengkap',
            'status' => 'kondisi/status',
            'place_of_birth' => 'tempat lahir',
            'date_of_birth' => 'tanggal lahir',
            'education' => 'pendidikan terakhir',
            'work' => 'pekerjaan',
            'phone_number' => 'nomor telepon',
            'gender' => 'jenis kelamin',
            'relationship' => 'hubungan keluarga',
            'family_type' => 'tipe keluarga',
        ];

        $members = [
            'father' => 'ayah',
            'mother' => 'ibu',
            'spouse' => 'pasangan',
            'siblings.*' => 'saudara kandung ke-:position',
            'children.*' => 'anak ke-:position',
        ];

        $attributes = [
            'families.siblings' => 'data saudara kandung',
            'families.children' => 'data anak',
            'redirect_step' => 'langkah tujuan',
        ];

        foreach ($members as $member => $memberLabel) {
            foreach ($labels as $field => $label) {
                $attributes["families.{$member}.{$field}"] = "{$label} {$memberLabel}";
            }
        }

        return $attributes;
    }
}
