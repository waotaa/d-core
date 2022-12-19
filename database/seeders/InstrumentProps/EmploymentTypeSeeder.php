<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\EmploymentType;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Name changes
        EmploymentType::query()->where([
            'description' => 'Stage'
        ])->update([
            'description' => 'Stage (met stagevergoeding)',
        ]);

        // Remove leerwerktraject filtering
        EmploymentType::query()->where([
            'description' => 'Leerwerktraject',
        ])->delete();

        // The data set
        EmploymentType::query()->firstOrCreate([
            'description' => 'Reguliere arbeidsovereenkomst',
        ]);
        EmploymentType::query()->firstOrCreate([
            'description' => 'BBL arbeidsovereenkomst',
        ]);
        EmploymentType::query()->firstOrCreate([
            'description' => 'Stage (met stagevergoeding)',
        ]);
        EmploymentType::query()->firstOrCreate([
            'description' => 'Werkervaring',
        ]);
    }
}
