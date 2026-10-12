<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Seed the recruitment stages for each job type.
     *
     * Uses updateOrCreate keyed by type + step so it can be re-run safely without
     * deleting stages (applications.stages_id cascades on delete).
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'administration', 'type' => 'magang', 'step' => 1],
            ['name' => 'psikotes', 'type' => 'magang', 'step' => 2],
            ['name' => 'interview', 'type' => 'magang', 'step' => 3],
            ['name' => 'simulasi', 'type' => 'magang', 'step' => 4],
            ['name' => 'offering', 'type' => 'magang', 'step' => 5],
            ['name' => 'administration', 'type' => 'profesional', 'step' => 1],
            ['name' => 'psikotes', 'type' => 'profesional', 'step' => 2],
            ['name' => 'interview', 'type' => 'profesional', 'step' => 3],
            ['name' => 'konfirmasi user', 'type' => 'profesional', 'step' => 4],
            ['name' => 'offering', 'type' => 'profesional', 'step' => 5],
            ['name' => 'mcu', 'type' => 'profesional', 'step' => 6],
            ['name' => 'administration', 'type' => 'management_trainee', 'step' => 1],
            ['name' => 'psikotes', 'type' => 'management_trainee', 'step' => 2],
            ['name' => 'interview', 'type' => 'management_trainee', 'step' => 3],
            ['name' => 'study case', 'type' => 'management_trainee', 'step' => 4],
            ['name' => 'panel bod', 'type' => 'management_trainee', 'step' => 5],
            ['name' => 'konfirmasi user', 'type' => 'management_trainee', 'step' => 6],
            ['name' => 'offering', 'type' => 'management_trainee', 'step' => 7],
            ['name' => 'mcu', 'type' => 'management_trainee', 'step' => 8],
            ['name' => 'administration', 'type' => 'internship', 'step' => 1],
            ['name' => 'interview 1', 'type' => 'internship', 'step' => 2],
            ['name' => 'interview 2', 'type' => 'internship', 'step' => 3],
        ];

        foreach ($stages as $stage) {
            Stage::updateOrCreate(
                ['type' => $stage['type'], 'step' => $stage['step']],
                ['name' => $stage['name']],
            );
        }
    }
}
