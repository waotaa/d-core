<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\AgeGroup;
use Illuminate\Database\Seeder;
use Vng\DennisCore\Helpers\Codelijsten;

/**
 * Leeftijdsgroep - LG
 */
class AgeGroupSeeder extends Seeder
{
    public function run(): void
    {
        AgeGroup::withoutEvents(function () {
            $leeftijdsgroepen = Codelijsten::get('Leeftijdsgroepen');
            foreach ($leeftijdsgroepen as $codeLeeftijdsgroepen => $naamLeeftijdsgroepen) {
                AgeGroup::query()->updateOrCreate(
                    ['code' => $codeLeeftijdsgroepen],
                    ['description' => $naamLeeftijdsgroepen]
                );
            }
        });
    }
}
