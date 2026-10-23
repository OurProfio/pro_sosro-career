<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Division;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $offices = [
            ['name' => 'Kantor Pusat', 'type' => 'HO'],
            ['name' => 'KPW Bali Nusra', 'type' => 'KPW'],
            ['name' => 'KPW Jakarta Banten', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Barat', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Tengah', 'type' => 'KPW'],
            ['name' => 'KPW Jawa Timur', 'type' => 'KPW'],
            ['name' => 'KPW Kalimantan Sulawesi', 'type' => 'KPW'],
            ['name' => 'KPW Sumbagsel Babel', 'type' => 'KPW'],
            ['name' => 'KPW Sumut NAD - Sumbar Kepri', 'type' => 'KPW'],
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
            ['email' => 'admin1@admin.test', 'name' => 'Admin HO', 'role' => 'superadmin', 'office' => 'Kantor Pusat'],
            ['email' => 'admin2@admin.test', 'name' => 'Admin KPW', 'role' => 'admin', 'office' => 'KPW Jakarta Banten'],
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
            // HrisMasterSeeder::class,
            StageSeeder::class,
            JobSeeder::class,
            // ApplicantSeeder::class,
            // ApplicantEducationSeeder::class,
            // ApplicantFamilySeeder::class,
            // ApplicantWorkExprienceSeeder::class,
            // ApplicantTrainingSeeder::class,
            // ApplicantInterestSeeder::class,
            // ApplicantExpectationSeeder::class,
            // ApplicationSeeder::class,
        ]);
    }
}
