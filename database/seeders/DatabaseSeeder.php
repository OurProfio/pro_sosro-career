<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\ApplicantExpectation;
use App\Models\ApplicantInterest;
use App\Models\Application;
use App\Models\Division;
use App\Models\Job;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $offices = [
            ['name' => 'HEAD OFFICE', 'type' => 'HO'],
            ['name' => 'Kantor Pusat', 'type' => 'HO'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri', 'type' => 'KPW'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Medan', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Binjai', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Rantau Prapat', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Padang Sidempuan', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Kisaran', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KPP Tanjung Mulia', 'type' => 'KPP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Sumbar & Kep. Riau', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Batam', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KPP Bintan', 'type' => 'KPP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Padang', 'type' => 'KP'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri KP Bukit Tinggi', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel', 'type' => 'KPW'],
            ['name' => 'KPW Sumbagsel Babel KP Palembang', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel KP Lahat', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel KP Pangkal Pinang', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel KPP Belitung', 'type' => 'KPP'],
            ['name' => 'KPW Sumbagsel Babel KP Jambi', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel KP Bandar Lampung', 'type' => 'KP'],
            ['name' => 'KPW Sumbagsel Babel KP Bengkulu', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten', 'type' => 'KPW'],
            ['name' => 'KPW Jakarta Banten KP Cakung', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Palmerah', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Daan Mogot', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Bekasi MOT', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Jakarta Pusat & Timur', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Kelapa Gading', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP BCC', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Daan Mogot (MOT)', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Pluit Penjaringan Muara Karang', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Tangerang', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Parung Panjang', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Ciledug Neglasari', 'type' => 'KP'],
            ['name' => 'KPW Jakarta Banten KP Sawangan Cisalak', 'type' => 'KP'],
            ['name' => 'KPW Bali Nusra', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Barat', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Tengah', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Timur', 'type' => 'KPW'],
            ['name' => 'KPW Kalimantan Sulawesi', 'type' => 'KPW'],
            ['name' => 'Pabrik Cakung', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Cibitung', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Deli Serdang', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Gianyar', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Mojokerto', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Palembang', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Pandaan', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Purbalingga', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Sentul', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Slawi', 'type' => 'Pabrik'],
            ['name' => 'Pabrik Ungaran', 'type' => 'Pabrik'],
            ['name' => 'Kebun', 'type' => 'Lainnya'],
            ['name' => 'Poci Kreasi Mandiri', 'type' => 'Lainnya'],
        ];

        foreach ($offices as $office) {
            Office::firstOrCreate(
                ['name' => $office['name']],
                ['type' => $office['type']]
            );
        }

        $admins = [
            ['email' => 'kpw@admin.admin', 'name' => 'Admin KPW', 'role' => 'admin', 'office' => 'KPW Jakarta Banten'],
            ['email' => 'admin@admin.admin', 'name' => 'Admin', 'role' => 'superadmin', 'office' => 'Kantor Pusat'],
        ];

        foreach ($admins as $admin) {
            $user = User::firstOrCreate(
                ['email' => $admin['email']],
                ['password' => 'password', 'role' => 'admin', 'email_verified_at' => now()],
            );

            Admin::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'office_id' => Office::where('name', $admin['office'])->value('id'),
                    'role' => $admin['role'],
                    'name' => $admin['name'],
                ],
            );
        }

        $divisions = [
            'Administrasi',
            'Finance & Accounting',
            'General Affairs',
            'Human Resources & People Development',
            'Information Technology',
            'Internal Audit',
            'Marketing',
            'Produksi / Teknik',
            'Purchasing',
            'Quality Control',
            'Research & Development',
            'Sales & Distribution',
            'Supply Chain & Logistic',
        ];
        foreach ($divisions as $name) {
            Division::firstOrCreate(['name' => $name]);
        }

        $this->call([
            HrisMasterSeeder::class,
            StageSeeder::class,
            // JobSeeder::class,
            // ApplicantSeeder::class,
            // ApplicantEducationSeeder::class,
            // ApplicantFamilySeeder::class,
            // ApplicantWorkExprienceSeeder::class,
            // ApplicantTrainingSeeder::class,
            // ApplicantInterestSeeder::class,
            // ApplicantExpectationSeeder::class,
            // ApplicationSeeder::class,
        ]);

        // Salin foto profil pelamar dari public/assets/images ke storage/app/public/applicants
        $photoRelativePath = 'applicants/karyawan-3.png';
        $sourcePhotoPath = public_path('assets/images/karyawan-3.png');

        if (! File::exists($sourcePhotoPath)) {
            $sourcePhotoPath = public_path('assets/images/default profile.webp');
            $photoRelativePath = 'applicants/default-profile.webp';
        }

        if (File::exists($sourcePhotoPath)) {
            Storage::disk('public')->put($photoRelativePath, File::get($sourcePhotoPath));
        }

        // 1. Buat 1 Lowongan Pekerjaan Aktif (untuk pengujian tahapan/stage)
        $superAdmin = Admin::where('role', 'superadmin')->first() ?? Admin::first();
        $kantorPusatId = Office::where('name', 'Kantor Pusat')->value('id') ?? Office::value('id');

        $job = Job::updateOrCreate(
            [
                'title' => 'Staff IT Support',
                'office_id' => $kantorPusatId,
            ],
            [
                'admin_id' => $superAdmin->id,
                'category' => 'profesional',
                'occupation' => 'Information Technology',
                'type' => 'Full-Time',
                'location' => 'Jakarta',
                'opening_date' => now()->subDays(5)->toDateString(),
                'closing_date' => now()->addMonths(2)->toDateString(),
                'description' => 'Bertanggung jawab atas pemeliharaan infrastruktur IT, jaringan, perangkat keras, serta dukungan teknis operasional harian di lingkungan Kantor Pusat PT Sinar Sosro Gunung Slamat.',
                'qualification' => "1. Pendidikan minimal D3/S1 Teknik Informatika, Sistem Informasi, atau Ilmu Komputer.\n2. Memahami troubleshooting hardware, software, dan jaringan (LAN/WAN).\n3. Teliti, komunikatif, dan mampu bekerja sama dalam tim.\n4. Bersedia ditempatkan di Kantor Pusat (Jakarta).",
                'status' => 'aktif',
            ],
        );

        // 2. Buat 1 Akun Pelamar & Biodata Lengkap (Step 1 - 4)
        $applicantUser = User::updateOrCreate(
            ['email' => 'applicant1@applicant.test'],
            [
                'password' => 'password',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $religionId = DB::table('treligion')
            ->where('RELIGION_NAME_ID', 'LIKE', '%Islam%')
            ->value('RELIGION_ID') ?? 'Islam';

        $applicant = Applicant::updateOrCreate(
            ['user_id' => $applicantUser->id],
            [
                'name' => 'Budi Santoso',
                'email' => $applicantUser->email,
                'nik' => '3171011505990001',
                'address_ktp' => 'Jl. Raya Sultan Agung KM 28, Medan Satria, Bekasi',
                'address_domisili' => 'Jl. Raya Sultan Agung KM 28, Medan Satria, Bekasi',
                'postal_code_ktp' => '17132',
                'postal_code_domisili' => '17132',
                'gender' => 'l',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '1999-05-15',
                'height' => 172,
                'weight' => 65,
                'blood_type' => 'O',
                'phone_number' => '081234567890',
                'religion' => (string) $religionId,
                'medical_history' => null,
                'is_smoker' => 'n',
                'has_tattoo' => 'n',
                'instagram' => '@budisantoso',
                'linkedin' => 'https://linkedin.com/in/budi-santoso',
                'driver_licenses' => ['A', 'C'],
                'marital_status' => 'single',
                'marital_date' => null,
                'emergency_contact_name' => 'Bambang Santoso',
                'emergency_contact_relationship' => 'Ayah',
                'emergency_contact_phone' => '081198765432',
                'has_applied_sosro' => 'n',
                'previous_applied_position' => null,
                'previous_applied_year' => null,
                'photo_url' => $photoRelativePath,
                'is_completed' => true,
            ],
        );

        // Minat Divisi & Ekspektasi Gaji (Bagian Step 1)
        $divisionIds = Division::orderBy('id')->limit(3)->pluck('id')->all();
        ApplicantInterest::updateOrCreate(
            ['applicant_id' => $applicant->id],
            ['interests' => $divisionIds],
        );

        ApplicantExpectation::updateOrCreate(
            ['applicant_id' => $applicant->id],
            [
                'salary_expectation' => 7000000,
                'facility_expectation' => 'BPJS Kesehatan & Ketenagakerjaan, Tunjangan Transportasi',
                'ready_to_relocate' => true,
                'ready_to_travel' => true,
                'job_source' => 'Website Resmi Sosro',
                'reference_by' => null,
            ],
        );

        // Step 2: Data Keluarga
        if ($applicant->families()->doesntExist()) {
            $applicant->families()->createMany([
                [
                    'relationship' => 'father',
                    'name' => 'Bambang Santoso',
                    'gender' => 'l',
                    'place_of_birth' => 'Semarang',
                    'date_of_birth' => '1968-03-15',
                    'education' => 'D4/S1',
                    'phone_number' => '081198765432',
                    'work' => 'Wiraswasta',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
                [
                    'relationship' => 'mother',
                    'name' => 'Sri Wahyuni',
                    'gender' => 'p',
                    'place_of_birth' => 'Yogyakarta',
                    'date_of_birth' => '1971-08-21',
                    'education' => 'SMA/SMK',
                    'phone_number' => '081298765433',
                    'work' => 'Ibu Rumah Tangga',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
                [
                    'relationship' => 'sibling',
                    'name' => 'Rina Santoso',
                    'gender' => 'p',
                    'place_of_birth' => 'Jakarta',
                    'date_of_birth' => '2003-11-10',
                    'education' => 'SMA/SMK',
                    'phone_number' => '081398765434',
                    'work' => 'Mahasiswa',
                    'family_type' => 'biological',
                    'status' => 'alive',
                ],
            ]);
        }

        // Step 3: Riwayat Pendidikan
        if ($applicant->educations()->doesntExist()) {
            $applicant->educations()->createMany([
                [
                    'institution_name' => 'SMA Negeri 8 Jakarta',
                    'city' => 'Jakarta',
                    'degree_level' => 'SMA/SMK',
                    'major' => 'IPA',
                    'gpa' => 88.50,
                    'entry_year' => 2014,
                    'graduation_year' => 2017,
                ],
                [
                    'institution_name' => 'Universitas Indonesia',
                    'city' => 'Depok',
                    'degree_level' => 'D4/S1',
                    'major' => 'Teknik Informatika',
                    'gpa' => 3.65,
                    'entry_year' => 2017,
                    'graduation_year' => 2021,
                ],
            ]);
        }

        // Step 4: Pengalaman Kerja & Pelatihan
        if ($applicant->workExperiences()->doesntExist()) {
            $applicant->workExperiences()->create([
                'company_name' => 'PT Nusantara Digital Solusi',
                'company_address' => 'Jl. Jend. Sudirman Kav. 52, Jakarta Selatan',
                'company_phone' => '0215551234',
                'position' => 'IT Support Specialist',
                'division' => 'Information Technology',
                'salary' => 6000000,
                'start_date' => '2022-01-10',
                'end_date' => '2024-12-20',
                'facility' => 'BPJS Kesehatan, Ketenagakerjaan, Laptop Kerja',
                'reason_for_leaving' => 'Mengembangkan karier di industri FMCG skala nasional',
                'reference_name' => 'Hendra Kusuma',
                'reference_position' => 'IT Manager',
                'reference_phone' => '081511223344',
            ]);
        }

        if ($applicant->trainings()->doesntExist()) {
            $applicant->trainings()->create([
                'training_name' => 'Cisco Certified Network Associate (CCNA)',
                'organizer' => 'Cisco Networking Academy',
                'finished' => '2023-06-15',
            ]);
        }

        // 3. Buat 1 Riwayat Lamaran dari Pelamar ke Lowongan (siap untuk ditest dropdown stage)
        Application::updateOrCreate(
            [
                'applicant_id' => $applicant->id,
                'job_id' => $job->id,
            ],
            [
                'status' => 'pending',
                'stages_id' => null,
                'notes' => null,
            ],
        );
    }
}
