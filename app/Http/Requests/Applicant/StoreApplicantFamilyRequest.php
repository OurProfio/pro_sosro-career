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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'families.father.name' => ['required', 'string', 'max:255'],
            'families.father.place_of_birth' => ['required', 'string', 'max:100'],
            'families.father.date_of_birth' => ['required', 'date', 'before:today'],
            'families.father.education' => ['required', 'string', 'max:100'],
            'families.father.work' => ['required', 'string', 'max:100'],
            'families.father.phone_number' => ['required', 'numeric', 'digits_between:10,15'],
            'families.father.relationship' => ['required', 'in:father'],
            'families.father.family_type' => ['required', 'in:biological'],
            'families.mother.name' => ['required', 'string', 'max:255'],
            'families.mother.place_of_birth' => ['required', 'string', 'max:100'],
            'families.mother.date_of_birth' => ['required', 'date', 'before:today'],
            'families.mother.education' => ['required', 'string', 'max:100'],
            'families.mother.work' => ['required', 'string', 'max:100'],
            'families.mother.phone_number' => ['required', 'numeric', 'digits_between:10,15'],
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
            $rules['families.children'] = ['nullable', 'array', 'max:3'];
            $rules['families.children.*.name'] = ['required', 'string', 'max:255'];
            $rules['families.children.*.place_of_birth'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.date_of_birth'] = ['required', 'date', 'before:today'];
            $rules['families.children.*.education'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.work'] = ['required', 'string', 'max:100'];
            $rules['families.children.*.phone_number'] = ['required', 'numeric', 'digits_between:1,15'];
            $rules['families.children.*.relationship'] = ['required', 'in:child'];
            $rules['families.children.*.family_type'] = ['required', 'in:nuclear'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
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
