<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegionalParty;

class RegionalPartyFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = RegionalParty::class;

    public function definition()
    {
        return [
            'name' => 'Regionale partij',
        ];
    }

    public function forRegion(Region $region = null): Factory
    {
        return $this->for($region ?? Region::factory(), 'region');
    }
}

