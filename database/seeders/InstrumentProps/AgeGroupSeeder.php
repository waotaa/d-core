<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\AgeGroup;
use Illuminate\Database\Seeder;

class AgeGroupSeeder extends Seeder
{
    public function run(): void
    {
        // Name changes
        AgeGroup::query()->where([
            'description' => '16 t/m 21 jaar',
        ])->update([
            'description' => '16 t/m 18 jaar',
        ]);

        // The data set
        AgeGroup::query()->firstOrCreate([
            'description' => '16 t/m 18 jaar',
        ]);
        AgeGroup::query()->firstOrCreate([
            'description' => '19 t/m 21 jaar',
        ]);
        AgeGroup::query()->firstOrCreate([
            'description' => '22 t/m 26 jaar',
        ]);
        AgeGroup::query()->firstOrCreate([
            'description' => '27 t/m 55 jaar',
        ]);
        AgeGroup::query()->firstOrCreate([
            'description' => '56 jaar tot AOW leeftijd ',
        ]);
        AgeGroup::query()->firstOrCreate([
            'description' => 'AOW leeftijd en ouder',
        ]);
    }
}
