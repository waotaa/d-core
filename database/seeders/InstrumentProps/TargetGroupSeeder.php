<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Models\TargetGroup;
use Illuminate\Database\Seeder;

/**
 * Dennis doelgroep - DD
 */
class TargetGroupSeeder extends Seeder
{
    public function run(): void
    {
        TargetGroup::withoutEvents(function () {
            $doelgroepen = Codelijsten::getDoelgroepenDennis();
            foreach ($doelgroepen as $codeDoelgroep => $naamDoelgroep) {
                TargetGroup::query()->updateOrCreate(
                    ['code' => $codeDoelgroep],
                    ['description' => $naamDoelgroep]
                );
            }
        });
    }
}
