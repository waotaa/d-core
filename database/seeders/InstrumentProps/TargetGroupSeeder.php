<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\TargetGroup;
use Illuminate\Database\Seeder;

class TargetGroupSeeder extends Seeder
{
    public function run(): void
    {
        TargetGroup::query()->where([
            'description' => 'Beschut werk',
        ])->delete();


        TargetGroup::query()->firstOrCreate([
            'description' => 'Geen uitkering',
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'Participatiewet (Bijstand, IOAW, IOAZ)',
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'Wajong'
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'WAO, WIA, WAZ',
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'WW, IOW',
        ]);
//        TargetGroup::query()->firstOrCreate([
//            'description' => 'Beschut werk',
//        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'Ondernemer met personeel',
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'Zelfstandig ondernemer (ZZP)',
        ]);
        TargetGroup::query()->firstOrCreate([
            'description' => 'Met werkloosheid bedreigd',
        ]);
    }
}
