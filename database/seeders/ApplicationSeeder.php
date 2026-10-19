<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Application;
use App\Models\Job;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Apply each applicant to one job, spreading statuses across the pipeline.
     */
    public function run(): void
    {
        $jobs = Job::orderBy('id')->get();

        if ($jobs->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'progress', 'progress', 'accepted', 'rejected'];

        Applicant::orderBy('id')->get()->each(function (Applicant $applicant, int $index) use ($jobs, $statuses) {
            $job = $jobs[$index % $jobs->count()];
            $status = $statuses[$index % count($statuses)];

            Application::firstOrCreate(
                ['applicant_id' => $applicant->id, 'job_id' => $job->id],
                [
                    'status' => $status,
                    'stages_id' => $status === 'pending' ? null : Stage::where('type', $job->category)->orderBy('step')->value('id'),
                ],
            );
        });
    }
}
