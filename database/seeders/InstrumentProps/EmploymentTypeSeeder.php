<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Models\EmploymentType;
use Illuminate\Database\Seeder;

/**
 * Dienstverband - DV
 */
class EmploymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        EmploymentType::withoutEvents(function () {
            $dienstverbanden = Codelijsten::get('Dienstverbanden');
            foreach ($dienstverbanden as $codeDienstverbanden => $naamDienstverbanden) {
                EmploymentType::query()->updateOrCreate(
                    ['code' => $codeDienstverbanden],
                    ['description' => $naamDienstverbanden]
                );
            }
        });
    }
}
