<?php

use Database\Seeders\Admin\TileSeeder;
use Database\Seeders\InstrumentProps\AgeGroupSeeder;
use Database\Seeders\InstrumentProps\EmploymentTypeSeeder;
use Database\Seeders\InstrumentProps\InstrumentTypeSeeder;
use Database\Seeders\InstrumentProps\SectorSeeder;
use Database\Seeders\InstrumentProps\TargetGroupRegisterSeeder;
use Database\Seeders\InstrumentProps\TargetGroupSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TileSeeder::class);

        $this->call(AgeGroupSeeder::class);
        $this->call(EmploymentTypeSeeder::class);
        $this->call(InstrumentTypeSeeder::class);
        $this->call(TargetGroupRegisterSeeder::class);
        $this->call(TargetGroupSeeder::class);
        $this->call(SectorSeeder::class);
    }
}
