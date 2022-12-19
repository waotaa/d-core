<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\InstrumentType;
use Illuminate\Database\Seeder;

class InstrumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        InstrumentType::query()->updateOrCreate([
            'key' => 'IT-1',
        ], [
            'name' => 'Werkzoekende-dienstverlening'
        ]);
        InstrumentType::query()->updateOrCreate([
            'key' => 'IT-2',
        ], [
            'name' => 'Werkgevers-dienstverlening'
        ]);
        InstrumentType::query()->where([
            'key' => 'IT-3',
        ])->delete();
    }
}
