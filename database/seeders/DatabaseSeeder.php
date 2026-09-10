<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Cabang;
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
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'role' => 'admin',
        ]);

        $cabang = Cabang::create([
            'nama' => 'Kantor Pusat',
            'tipe' => 'HO',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'cabang_id' => $cabang->id,
            'role' => 'superadmin',
        ]);
    }
}
