<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        Sector::query()->firstOrCreate([
            'description' => 'Landbouw, Natuur, Milieu',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Bouw',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Detailhandel',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Administratie, Automatisering, ICT',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Horeca en Toerisme',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Techniek',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Overheid',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Transport en Logistiek',
        ]);
        Sector::query()->firstOrCreate([
            'description' => 'Zorg en Welzijn',
        ]);
    }
}
