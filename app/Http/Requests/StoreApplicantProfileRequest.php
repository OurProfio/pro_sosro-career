<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicantProfileRequest extends FormRequest
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
        return [
            'nik' => 'required|digits:16|unique:applicant_profiles,nik',
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'tinggi_badan' => 'required|numeric|min:100|max:250',
            'berat_badan' => 'required|numeric|min:30|max:250',
            'alamat_ktp' => 'required|string',
            'alamat_domisili' => 'required|string',
            'no_telepon' => 'required|string|between:10,15',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya',
            'status_pernikahan' => 'required|in:belum_menikah,sudah_menikah,cerai_hidup,cerai_mati',
            'jenis_sim' => 'nullable|array',
            'jenis_sim.*' => 'string|in:A,B1,B2,C,D',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'referensi_perusahaan' => 'nullable|string|max:255',
            'pernah_bekerja_internal' => 'required|boolean',
            'nama_perusahaan_lama' => 'required_if:pernah_bekerja_internal,true|nullable|string|max:255',
            'jabatan_terakhir' => 'required_if:pernah_bekerja_internal,true|nullable|string|max:255',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'perokok' => 'required|boolean',
            'bertato' => 'required|boolean',
            'ekspektasi_gaji' => 'required|numeric|min:0',
            'ekspektasi_fasilitas' => 'nullable|string|max:255',
            'bersedia_dinas_luar' => 'required|boolean',
            'bersedia_penempatan_luar' => 'required|boolean',
            'minat_ids'   => 'required|array|min:1',
            'minat_ids.*' => 'required|exists:divisis,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar di sistem.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid.',
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.numeric' => 'Tinggi badan harus berupa angka.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.numeric' => 'Berat badan harus berupa angka.',
            'alamat_ktp.required' => 'Alamat KTP wajib diisi.',
            'alamat_domisili.required' => 'Alamat domisili wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.between' => 'Nomor telepon harus antara 10 sampai 15 digit.',
            'agama.required' => 'Agama wajib diisi.',
            'status_pernikahan.required' => 'Status pernikahan wajib diisi.',
            'status_pernikahan.in' => 'Pilihan status pernikahan tidak valid.',
            'instagram.url' => 'Format URL Instagram tidak valid (gunakan format http:// atau https://).',
            'linkedin.url' => 'Format URL LinkedIn tidak valid (gunakan format http:// atau https://).',
            'pernah_bekerja_internal.required' => 'Pilihan riwayat bekerja internal wajib diisi.',
            'nama_perusahaan_lama.required_if' => 'Nama perusahaan lama wajib diisi jika pernah bekerja di internal.',
            'jabatan_terakhir.required_if' => 'Jabatan terakhir wajib diisi jika pernah bekerja di internal.',
            'perokok.required' => 'Status perokok wajib diisi.',
            'bertato.required' => 'Status bertato wajib diisi.',
            'ekspektasi_gaji.required' => 'Ekspektasi gaji wajib diisi.',
            'ekspektasi_gaji.numeric' => 'Ekspektasi gaji harus berupa angka.',
            'bersedia_dinas_luar.required' => 'Pernyataan kesiapan dinas luar wajib diisi.',
            'bersedia_penempatan_luar.required' => 'Pernyataan kesiapan penempatan luar kota wajib diisi.',
            'minat_ids.required' => 'Minat bidang pekerjaan wajib diisi.',
            'minat_ids.array' => 'Format data minat pekerjaan tidak valid.',
            'minat_ids.min' => 'Minimal 1 minat bidang pekerjaan harus dipilih.',
            'minat_ids.*.required' => 'Minat bidang pekerjaan tidak valid.',
            'minat_ids.*.exists' => 'Minat bidang pekerjaan tidak valid.',
        ];
    }
}
