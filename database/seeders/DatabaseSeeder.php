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
    }
}
