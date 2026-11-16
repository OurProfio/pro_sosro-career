<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            'E-Commerce',
            'Export',
            'Finance & Accounting',
            'Pabrikan',
            'Human Capital',
            'Internal Audit & Business Process Management',
            'IT',
            'Marketing',
            'Sales & Distribution',
            'Operations Controller',
            'Strategic Account & Partnership',
            'National Development & Promotion',
            'Supply Chain',
            'Tea Institute',
        ];

        foreach ($divisions as $name) {
            Division::firstOrCreate(['name' => $name]);
        }
    }
}
