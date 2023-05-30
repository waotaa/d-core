<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\InstrumentType;
use Illuminate\Database\Seeder;

/**
 * Instrument type - IT
 * Wordt waarschijnlijk verwijderd. Type af te leiden aan instrument entiteit
 */
class InstrumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        InstrumentType::query()->where([
            'code' => 'IT-3',
        ])->delete();

        InstrumentType::query()->where([
            'code' => 'IT-1',
        ])->update([
            'code' => 'IT01',
        ]);
        InstrumentType::query()->where([
            'code' => 'IT-2',
        ])->update([
            'code' => 'IT02',
        ]);

        // The data set
        InstrumentType::query()->updateOrCreate([
            'code' => 'IT01',
        ], [
            'name' => 'Werkzoekende-dienstverlening'
        ]);
        InstrumentType::query()->updateOrCreate([
            'code' => 'IT02',
        ], [
            'name' => 'Werkgevers-dienstverlening'
        ]);
    }
}
