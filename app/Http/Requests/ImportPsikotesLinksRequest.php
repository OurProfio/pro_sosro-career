<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPsikotesLinksRequest extends FormRequest
{
    protected $errorBag = 'psikotesImport';

    public function authorize(): bool
    {
        abort_unless(
            $this->route('job')->isManageableBy($this->user()?->admin),
            403,
            'Akses tidak diizinkan untuk kantor cabang lain.'
        );

        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:xlsx', 'max:5120'],
        ];
    }
}
