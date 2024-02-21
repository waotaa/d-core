<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegionalParty;

class RegionPageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Region::class;

    public function definition(): array
    {
        return [
            'description' => '',
            'cooperation_partners' => '',
            'additional_information'=> '',
            'terminology' => '',
        ];
    }

    public function forRegion(Region $region = null): Factory
    {
        return $this->for($region ?? Region::factory(), 'region');
    }

    public function forRegionalParty(RegionalParty $regionalParty = null): Factory
    {
        return $this->for($regionalParty ?? RegionalParty::factory()->create(), 'regionalParty');
    }
}
