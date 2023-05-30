<?php

namespace Database\Seeders\InstrumentProps;

use Vng\DennisCore\Models\TargetGroup;
use Illuminate\Database\Seeder;

/**
 * Dennis doelgroep - DD
 */
class TargetGroupSeeder extends Seeder
{
    public function run(): void
    {
        TargetGroup::query()->where([
            'description' => 'Beschut werk',
        ])->delete();


        TargetGroup::query()->updateOrCreate([
            'description' => 'Geen uitkering',
        ],[
            'code' => 'DD01',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'Participatiewet (Bijstand, IOAW, IOAZ)',
        ],[
            'code' => 'DD02',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'Wajong',
        ],[
            'code' => 'DD03',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'WAO, WIA, WAZ',
        ],[
            'code' => 'DD04',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'WW, IOW',
        ],[
            'code' => 'DD05',
        ]);
//        TargetGroup::query()->firstOrCreate([
//            'description' => 'Beschut werk',
//        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'Ondernemer met personeel',
        ],[
            'code' => 'DD06',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'Zelfstandig ondernemer (ZZP)',
        ],[
            'code' => 'DD07',
        ]);
        TargetGroup::query()->updateOrCreate([
            'description' => 'Met werkloosheid bedreigd',
        ],[
            'code' => 'DD08',
        ]);
    }
}
