<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Division;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            Office::create([
                'name' => $office['name'],
                'type' => $office['type']
            ]);
        }

        $user = User::create([
            'email' => 'admin@admin.admin',
            'password' => 'admin',
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'office_id' => 1,
            'role' => 'superadmin',
            'name' => 'Admin',
        ]);

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

        $now = now();
        $stages = [

            ['name' => 'interview', 'type' => 'magang', 'step' => 1, 'created_at' => $now, 'updated_at' => $now],

            ['name' => 'administration', 'type' => 'internship', 'step' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'psikotes', 'type' => 'internship', 'step' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'interview', 'type' => 'internship', 'step' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'simulasi', 'type' => 'internship', 'step' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'offering', 'type' => 'internship', 'step' => 5, 'created_at' => $now, 'updated_at' => $now],

            ['name' => 'administration', 'type' => 'profesional', 'step' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'psikotes', 'type' => 'profesional', 'step' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'interview', 'type' => 'profesional', 'step' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'konfirmasi user', 'type' => 'profesional', 'step' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'offering', 'type' => 'profesional', 'step' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'mcu', 'type' => 'profesional', 'step' => 6, 'created_at' => $now, 'updated_at' => $now],

            ['name' => 'administration', 'type' => 'management_trainee', 'step' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'psikotes', 'type' => 'management_trainee', 'step' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'interview', 'type' => 'management_trainee', 'step' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'study case', 'type' => 'management_trainee', 'step' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'panel bod', 'type' => 'management_trainee', 'step' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'konfirmasi user', 'type' => 'management_trainee', 'step' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'offering', 'type' => 'management_trainee', 'step' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'mcu', 'type' => 'management_trainee', 'step' => 8, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('stages')->insert($stages);
    }
}
