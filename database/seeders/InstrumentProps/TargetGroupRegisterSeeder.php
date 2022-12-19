<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\TargetGroupRegister;
use Illuminate\Database\Seeder;

class TargetGroupRegisterSeeder extends Seeder
{
    public function run(): void
    {
        TargetGroupRegister::query()->firstOrCreate([
            'description' => 'Ja',
        ]);
        TargetGroupRegister::query()->firstOrCreate([
            'description' => 'Nee',
        ]);
    }
}
