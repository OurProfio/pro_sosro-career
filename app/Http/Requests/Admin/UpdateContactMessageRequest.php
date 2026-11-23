<?php

namespace App\Http\Requests\Admin;

use App\Models\Office;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->admin !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'assigned_office_id' => ['nullable', 'integer', 'exists:offices,id'],
            'reply_message' => ['nullable', 'string', 'max:3000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'assigned_office_id.integer' => 'Kantor cabang tujuan tidak valid.',
            'assigned_office_id.exists' => 'Kantor cabang tujuan tidak ditemukan.',
            'reply_message.string' => 'Format balasan tidak valid.',
            'reply_message.max' => 'Balasan maksimal 3000 karakter.',
        ];
    }

    /**
     * Validasi tambahan:
     * - Kantor tujuan wajib memiliki admin aktif saat Superadmin melempar ke cabang.
     * - Balasan email wajib diisi saat Admin Cabang atau Superadmin menangani sendiri.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $admin = $this->user()?->admin;
            $isSuperAdmin = $admin?->role === 'superadmin';
            $officeId = $this->input('assigned_office_id');
            $isDispatchingToBranch = $isSuperAdmin && $officeId !== null && $officeId !== '';

            if ($isDispatchingToBranch) {
                $hasActiveBranchAdmin = Office::query()
                    ->whereKey($officeId)
                    ->withActiveBranchAdmins()
                    ->exists();

                if (! $hasActiveBranchAdmin) {
                    $validator->errors()->add('assigned_office_id', 'Kantor cabang tujuan harus non-HO dan memiliki admin cabang aktif terdaftar.');
                }

                return;
            }

            $replyMessage = trim((string) $this->input('reply_message', ''));

            if ($replyMessage === '') {
                $validator->errors()->add('reply_message', 'Pesan balasan / solusi wajib diisi sebelum mengirim email.');
            }
        });
    }
}
