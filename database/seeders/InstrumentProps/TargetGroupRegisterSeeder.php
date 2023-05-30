<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\TargetGroupRegister;
use Illuminate\Database\Seeder;

class TargetGroupRegisterSeeder extends Seeder
{
    public function run(): void
    {
        TargetGroupRegister::query()->updateOrCreate([
            'description' => 'Ja',
        ]);
        TargetGroupRegister::query()->updateOrCreate([
            'description' => 'Nee',
        ]);
    }
}
