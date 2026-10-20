<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Seed applicant users with their main biodata (password: "password").
     */
    public function run(): void
    {
        $names = ['Budi Santoso', 'Siti Rahmawati', 'Andi Pratama'];
        $cities = ['Jakarta', 'Bandung', 'Semarang', 'Surabaya', 'Medan', 'Yogyakarta', 'Bogor', 'Malang'];

        foreach ($names as $index => $name) {
            $number = $index + 1;
            $email = 'applicant'.$number.'@applicant.test';
            $isMale = $number % 2 === 1;

            $user = User::firstOrCreate(
                ['email' => $email],
                ['password' => 'password', 'role' => 'user', 'email_verified_at' => now()],
            );

            Applicant::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $name,
                    'email' => $email,
                    'nik' => '3171'.str_pad((string) (1000000000 + $number * 7919), 12, '0', STR_PAD_LEFT),
                    'address_ktp' => 'Jl. Merdeka No. '.$number.', '.$cities[$index % count($cities)],
                    'address_domisili' => 'Jl. Melati No. '.($number + 10).', '.$cities[$index % count($cities)],
                    'postal_code_ktp' => '1'.str_pad((string) ($number * 137), 4, '0', STR_PAD_LEFT),
                    'postal_code_domisili' => '1'.str_pad((string) ($number * 211), 4, '0', STR_PAD_LEFT),
                    'gender' => $isMale ? 'l' : 'p',
                    'place_of_birth' => $cities[($index + 3) % count($cities)],
                    'date_of_birth' => now()->subYears(22 + $index % 8)->subDays($number * 17)->toDateString(),
                    'height' => $isMale ? 165 + $index : 152 + $index,
                    'weight' => $isMale ? 60 + $index : 48 + $index,
                    'blood_type' => ['A', 'B', 'AB', 'O'][$index % 4],
                    'phone_number' => '08123456'.str_pad((string) $number, 4, '0', STR_PAD_LEFT),
                    'religion' => ['Islam', 'Islam', 'Kristen', 'Islam', 'Katolik'][$index % 5],
                    'medical_history' => null,
                    'is_smoker' => $isMale && $number % 3 === 0 ? 'y' : 'n',
                    'has_tattoo' => 'n',
                    'instagram' => '@'.str_replace(' ', '.', strtolower($name)),
                    'linkedin' => 'https://linkedin.com/in/'.str_replace(' ', '-', strtolower($name)),
                    'driver_licenses' => $isMale ? ['A', 'C'] : ['C'],
                    'marital_status' => $number % 5 === 0 ? 'married' : 'single',
                    'marital_date' => $number % 5 === 0 ? '2022-06-12' : null,
                    'emergency_contact_name' => 'Keluarga '.$name,
                    'emergency_contact_relationship' => 'Orang Tua',
                    'emergency_contact_phone' => '08219876'.str_pad((string) $number, 4, '0', STR_PAD_LEFT),
                    'photo_url' => 'photos/default.jpg',
                ],
            );
        }
    }
}
