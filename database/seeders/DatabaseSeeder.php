<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Cabang;
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
        $user = User::create([
            'email' => 'admin@admin.admin',
            'password' => 'admin',
            'role' => 'admin',
        ]);

        $office = Office::create([
            'name' => 'Kantor Pusat',
            'type' => 'HO',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'office_id' => $office->id,
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
    }
}
