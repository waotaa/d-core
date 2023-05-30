<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\EmploymentType;
use Illuminate\Database\Seeder;

/**
 * Dienstverband - DV
 */
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
        EmploymentType::query()->updateOrCreate([
            'description' => 'Reguliere arbeidsovereenkomst',
        ],[
            'code' => 'DV01',
        ]);
        EmploymentType::query()->updateOrCreate([
            'description' => 'BBL arbeidsovereenkomst',
        ],[
            'code' => 'DV02',
        ]);
        EmploymentType::query()->updateOrCreate([
            'description' => 'Stage (met stagevergoeding)',
        ],[
            'code' => 'DV03',
        ]);
        EmploymentType::query()->updateOrCreate([
            'description' => 'Werkervaring',
        ],[
            'code' => 'DV04',
        ]);
    }
}
