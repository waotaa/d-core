<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\AgeGroup;
use Illuminate\Database\Seeder;

/**
 * Leeftijdsgroep - LG
 */
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
        AgeGroup::query()->updateOrCreate([
            'description' => '16 t/m 18 jaar',
        ],[
            'code' => 'LG01'
        ]);
        AgeGroup::query()->updateOrCreate([
            'description' => '19 t/m 21 jaar',
        ],[
            'code' => 'LG02'
        ]);
        AgeGroup::query()->updateOrCreate([
            'description' => '22 t/m 26 jaar',
        ],[
            'code' => 'LG03'
        ]);
        AgeGroup::query()->updateOrCreate([
            'description' => '27 t/m 55 jaar',
        ],[
            'code' => 'LG04'
        ]);
        AgeGroup::query()->updateOrCreate([
            'description' => '56 jaar tot AOW leeftijd ',
        ],[
            'code' => 'LG05'
        ]);
        AgeGroup::query()->updateOrCreate([
            'description' => 'AOW leeftijd en ouder',
        ],[
            'code' => 'LG06'
        ]);
    }
}
