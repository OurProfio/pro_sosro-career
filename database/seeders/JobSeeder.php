<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Job;
use App\Models\Office;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Seed sample job vacancies. Requires OfficeSeeder data and an admin from DatabaseSeeder.
     */
    public function run(): void
    {
        $admin = Admin::query()->firstOrFail();

        $jobs = [
            ['title' => 'Staff IT Support', 'category' => 'profesional', 'occupation' => 'Information Technology', 'type' => 'Full-Time', 'office' => 'Kantor Pusat', 'location' => 'Jakarta'],
            ['title' => 'Staff Akuntansi', 'category' => 'profesional', 'occupation' => 'Finance & Accounting', 'type' => 'Kontrak', 'office' => 'Kantor Pusat', 'location' => 'Jakarta'],
            ['title' => 'Quality Control Officer', 'category' => 'profesional', 'occupation' => 'Quality Control', 'type' => 'Full-Time', 'office' => 'Pabrik Sentul', 'location' => 'Bogor'],
            ['title' => 'Supervisor Produksi', 'category' => 'profesional', 'occupation' => 'Produksi / Teknik', 'type' => 'Full-Time', 'office' => 'Pabrik Ungaran', 'location' => 'Semarang'],
            ['title' => 'Sales Executive', 'category' => 'profesional', 'occupation' => 'Sales & Distribution', 'type' => 'Full-Time', 'office' => 'KPW Jawa Timur', 'location' => 'Surabaya'],
            ['title' => 'Management Trainee Batch 1', 'category' => 'management_trainee', 'occupation' => 'Marketing', 'type' => 'Kontrak', 'office' => 'Kantor Pusat', 'location' => 'Jakarta'],
            ['title' => 'Magang Human Resources', 'category' => 'magang', 'occupation' => 'Human Resources & People Development', 'type' => 'Part-Time', 'office' => 'Kantor Pusat', 'location' => 'Jakarta'],
            ['title' => 'Internship Supply Chain', 'category' => 'internship', 'occupation' => 'Supply Chain & Logistic', 'type' => 'Part-Time', 'office' => 'Pabrik Cibitung', 'location' => 'Bekasi'],
        ];

        foreach ($jobs as $job) {
            Job::firstOrCreate(
                ['title' => $job['title'], 'office_id' => Office::where('name', $job['office'])->value('id')],
                [
                    'admin_id' => $admin->id,
                    'category' => $job['category'],
                    'occupation' => $job['occupation'],
                    'type' => $job['type'],
                    'location' => $job['location'],
                    'opening_date' => now()->subWeek()->toDateString(),
                    'closing_date' => now()->addMonths(2)->toDateString(),
                    'description' => 'Bertanggung jawab atas operasional harian pada bidang '.$job['occupation'].'.',
                    'qualification' => 'Minimal D3/S1 terkait, teliti, mampu bekerja dalam tim, dan bersedia ditempatkan di '.$job['location'].'.',
                    'status' => 'aktif',
                ],
            );
        }
    }
}
